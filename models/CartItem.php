<?php
class CartItem extends Model {
    protected $table = 'cart_items';

    public function getByUserOrSession($userId = null, $sessionId = null) {
        if ($userId) {
            $sql = "SELECT c.id, c.quantity, p.id AS product_id, p.name, p.slug, p.price, p.featured_image
                    FROM cart_items c
                    JOIN products p ON c.product_id = p.id
                    WHERE c.user_id = ?";
            return $this->db->select($sql, [$userId]);
        } else {
            $sql = "SELECT c.id, c.quantity, p.id AS product_id, p.name, p.slug, p.price, p.featured_image
                    FROM cart_items c
                    JOIN products p ON c.product_id = p.id
                    WHERE c.session_id = ?";
            return $this->db->select($sql, [$sessionId]);
        }
    }

    public function addItem($userId, $sessionId, $productId, $quantity = 1) {
        $whereField = $userId ? 'user_id' : 'session_id';
        $whereValue = $userId ?: $sessionId;

        $existing = $this->db->selectOne(
            "SELECT id, quantity FROM cart_items WHERE $whereField = ? AND product_id = ?",
            [$whereValue, $productId]
        );

        if ($existing) {
            $newQty = $existing['quantity'] + $quantity;
            $this->db->execute(
                "UPDATE cart_items SET quantity = ? WHERE id = ?",
                [$newQty, $existing['id']]
            );
        } else {
            $this->db->execute(
                "INSERT INTO cart_items ($whereField, product_id, quantity) VALUES (?, ?, ?)",
                [$whereValue, $productId, $quantity]
            );
        }
    }

    public function removeItem($id, $userId = null, $sessionId = null) {
        if ($userId) {
            $this->db->execute("DELETE FROM cart_items WHERE id = ? AND user_id = ?", [$id, $userId]);
        } else {
            $this->db->execute("DELETE FROM cart_items WHERE id = ? AND session_id = ?", [$id, $sessionId]);
        }
    }

    public function updateItem($id, $quantity, $userId = null, $sessionId = null) {
        if ($userId) {
            $this->db->execute("UPDATE cart_items SET quantity = ? WHERE id = ? AND user_id = ?", [$quantity, $id, $userId]);
        } else {
            $this->db->execute("UPDATE cart_items SET quantity = ? WHERE id = ? AND session_id = ?", [$quantity, $id, $sessionId]);
        }
    }

    public function countItems($userId = null, $sessionId = null) {
        if ($userId) {
            $res = $this->db->selectOne("SELECT SUM(quantity) as total FROM cart_items WHERE user_id = ?", [$userId]);
        } else {
            $res = $this->db->selectOne("SELECT SUM(quantity) as total FROM cart_items WHERE session_id = ?", [$sessionId]);
        }
        return $res && $res['total'] ? (int)$res['total'] : 0;
    }
}
