<?php

class Review extends Model
{
    protected $table = 'reviews';

    public function __construct() {
        parent::__construct();
    }

    // Ghi đè đúng chuẩn hàm getAll từ Model
    public function getAll($conditions = [], $orderBy = '', $limit = 0, $offset = 0)
    {
        return parent::getAll($conditions, $orderBy, $limit, $offset);
    }

    // Lấy tất cả đánh giá theo product_id, chỉ lấy những đánh giá đã duyệt
    public function getByProductId($productId)
    {
        $sql = "SELECT r.*, u.name AS user_name 
            FROM {$this->table} r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.product_id = :product_id 
            AND r.status = 'approved' 
            ORDER BY r.created_at DESC";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (product_id, user_id, order_id, rating, title, comment, images, is_verified, status, helpful_count, created_at, updated_at)
                VALUES (:product_id, :user_id, :order_id, :rating, :title, :comment, :images, :is_verified, :status, 0, NOW(), NOW())";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':product_id', $data['product_id']);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':order_id', $data['order_id']);
        $stmt->bindParam(':rating', $data['rating']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':comment', $data['comment']);
        $images = !empty($data['images']) ? $data['images'] : '[]';
        $stmt->bindParam(':images', $images);
        $stmt->bindParam(':is_verified', $data['is_verified'], PDO::PARAM_INT);
        $stmt->bindParam(':status', $data['status']);

        return $stmt->execute();
    }

    public function getStatsByProductId($productId)
    {
        $sql = "SELECT COUNT(*) AS total_reviews, AVG(rating) AS avg_rating 
                FROM {$this->table} 
                WHERE product_id = :product_id AND status = 'approved'";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function incrementHelpful($reviewId)
    {
        $sql = "UPDATE {$this->table} SET helpful_count = helpful_count + 1 WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $reviewId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Admin
    public function getAllWithDetails()
    {
        $sql = "SELECT 
                    r.*, 
                    p.name AS product_name, 
                    u.name AS user_name
                FROM {$this->table} r
                LEFT JOIN products p ON r.product_id = p.id
                LEFT JOIN users u ON r.user_id = u.id
                ORDER BY r.created_at DESC";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //  Thêm mới: Lấy 1 đánh giá theo ID, kèm tên sản phẩm và người dùng
    public function getByIdWithDetails($id)
    {
        $sql = "SELECT 
                    r.*, 
                    p.name AS product_name, 
                    u.name AS user_name
                FROM {$this->table} r
                LEFT JOIN products p ON r.product_id = p.id
                LEFT JOIN users u ON r.user_id = u.id
                WHERE r.id = :id";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status)
    {
        $sql = "UPDATE {$this->table} 
                SET status = :status, updated_at = NOW() 
                WHERE id = :id";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getPending()
    {
        $sql = "SELECT r.*, u.name AS user_name, p.name AS product_name
                FROM {$this->table} r
                JOIN users u ON r.user_id = u.id
                JOIN products p ON r.product_id = p.id
                WHERE r.status = 'pending'
                ORDER BY r.created_at DESC";

        return $this->db->select($sql);
    }

    // Danh sách đánh giá đã bị từ chối
    public function getRejected()
    {
        $sql = "SELECT r.*, u.name AS user_name, p.name AS product_name
                FROM {$this->table} r
                JOIN users u ON r.user_id = u.id
                JOIN products p ON r.product_id = p.id
                WHERE r.status = 'rejected'
                ORDER BY r.created_at DESC";

        return $this->db->select($sql);
    }

    public function searchReviews($keyword, $status = null) {
        $sql = "SELECT r.*, p.name AS product_name, u.name AS user_name
                FROM {$this->table} r
                LEFT JOIN products p ON r.product_id = p.id
                LEFT JOIN users u ON r.user_id = u.id
                WHERE (p.name LIKE ? OR u.name LIKE ?)";

        $params = ["%{$keyword}%", "%{$keyword}%"];

        // Nếu có truyền status thì thêm điều kiện lọc
        if (!empty($status)) {
            $sql .= " AND r.status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY r.created_at DESC";

        return $this->db->select($sql, $params);
    }

}
