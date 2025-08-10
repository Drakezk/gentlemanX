<?php
class Wishlist extends Model {
    protected $table = 'wishlists';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'product_id', 'created_at'];

    // Lấy danh sách wishlist theo user
    public function getByUser($userId) {
        $sql = "SELECT w.id as wishlist_id, w.created_at, 
                       p.id as product_id, p.name, p.slug, p.price, p.featured_image
                FROM {$this->table} w
                JOIN products p ON w.product_id = p.id
                WHERE w.user_id = ?
                ORDER BY w.created_at DESC";
        return $this->db->select($sql, [$userId]);
    }

    public function add($userId, $productId) {
        // Kiểm tra trùng
        $check = $this->db->selectOne(
            "SELECT id FROM {$this->table} WHERE user_id = ? AND product_id = ?",
            [$userId, $productId]
        );
        if ($check) {
            return false; // đã có rồi
        }
        return $this->db->execute(
            "INSERT INTO {$this->table} (user_id, product_id) VALUES (?, ?)",
            [$userId, $productId]
        );
    }

    public function remove($userId, $productId) {
        return $this->db->execute(
            "DELETE FROM {$this->table} WHERE user_id = ? AND product_id = ?",
            [$userId, $productId]
        );
    }

    // Kiểm tra 1 sản phẩm đã có trong wishlist chưa
    public function exists($userId, $productId) {
        $row = $this->db->selectOne(
            "SELECT id FROM {$this->table} WHERE user_id = ? AND product_id = ?",
            [$userId, $productId]
        );
        return $row ? true : false;
    }
}
