<?php
class CartItem extends Model {
    protected $table = 'cart_items';

    //  Lấy danh sách giỏ hàng cho user hoặc session
    public function getCartItems($userId = null, $sessionId = null) {
        if ($userId) {
            $sql = "SELECT c.id, c.quantity, 
                           p.id AS product_id, p.name, p.slug, p.price, p.featured_image
                    FROM {$this->table} c
                    JOIN products p ON c.product_id = p.id
                    WHERE c.user_id = ?";
            return $this->db->select($sql, [$userId]);
        } else {
            $sql = "SELECT c.id, c.quantity, 
                           p.id AS product_id, p.name, p.slug, p.price, p.featured_image
                    FROM {$this->table} c
                    JOIN products p ON c.product_id = p.id
                    WHERE c.session_id = ?";
            return $this->db->select($sql, [$sessionId]);
        }
    }

    //  Hàm cũ vẫn giữ nguyên, chỉ rename nhẹ nếu muốn
    public function getByUserOrSession($userId = null, $sessionId = null) {
        return $this->getCartItems($userId, $sessionId);
    }

    //  Thêm sản phẩm vào giỏ
    public function addItem($userId, $sessionId, $productId, $quantity = 1) {
        $whereField = $userId ? 'user_id' : 'session_id';
        $whereValue = $userId ?: $sessionId;

        $existing = $this->db->selectOne(
            "SELECT id, quantity FROM {$this->table} WHERE $whereField = ? AND product_id = ?",
            [$whereValue, $productId]
        );

        if ($existing) {
            $newQty = $existing['quantity'] + $quantity;
            $this->db->execute(
                "UPDATE {$this->table} SET quantity = ? WHERE id = ?",
                [$newQty, $existing['id']]
            );
        } else {
            $this->db->execute(
                "INSERT INTO {$this->table} ($whereField, product_id, quantity) VALUES (?, ?, ?)",
                [$whereValue, $productId, $quantity]
            );
        }
    }

    //  Xóa item khỏi giỏ
    public function removeItem($id, $userId = null, $sessionId = null) {
        if ($userId) {
            $this->db->execute("DELETE FROM {$this->table} WHERE id = ? AND user_id = ?", [$id, $userId]);
        } else {
            $this->db->execute("DELETE FROM {$this->table} WHERE id = ? AND session_id = ?", [$id, $sessionId]);
        }
    }

    //  Cập nhật số lượng
    public function updateItem($id, $quantity, $userId = null, $sessionId = null) {
        if ($userId) {
            $this->db->execute(
                "UPDATE {$this->table} SET quantity = ? WHERE id = ? AND user_id = ?",
                [$quantity, $id, $userId]
            );
        } else {
            $this->db->execute(
                "UPDATE {$this->table} SET quantity = ? WHERE id = ? AND session_id = ?",
                [$quantity, $id, $sessionId]
            );
        }
    }

    //  Đếm tổng số item trong giỏ
    public function countItems($userId = null, $sessionId = null) {
        if ($userId) {
            $res = $this->db->selectOne(
                "SELECT SUM(quantity) as total FROM {$this->table} WHERE user_id = ?",
                [$userId]
            );
        } else {
            $res = $this->db->selectOne(
                "SELECT SUM(quantity) as total FROM {$this->table} WHERE session_id = ?",
                [$sessionId]
            );
        }
        return $res && $res['total'] ? (int)$res['total'] : 0;
    }

    //  Xóa toàn bộ giỏ (sau khi checkout)
    public function clearCart($userId = null, $sessionId = null) {
        if ($userId) {
            return $this->db->execute("DELETE FROM {$this->table} WHERE user_id = ?", [$userId]);
        } else {
            return $this->db->execute("DELETE FROM {$this->table} WHERE session_id = ?", [$sessionId]);
        }
    }
}
