<?php
// models/Order.php
class Order extends Model {
    protected $table = 'orders';          // Tên bảng
    protected $primaryKey = 'id';         // Khóa chính
    protected $fillable = [               // Các trường cho phép insert/update
        'user_id', 'status', 'total', 'shipping_address', 'created_at', 'updated_at'
    ];

    // Lấy tất cả đơn hàng của user
    public function getByUserId($userId) {
        return $this->getAll(['user_id' => $userId], 'created_at DESC');
    }

    // Nếu cần lấy chi tiết theo id và user
    public function getByIdAndUser($id, $userId) {
        $sql = "SELECT o.*, u.name AS user_name, u.phone AS user_phone
                FROM {$this->table} o
                LEFT JOIN users u ON o.user_id = u.id
                WHERE o.{$this->primaryKey} = ? AND o.user_id = ?";
        return $this->db->selectOne($sql, [$id, $userId]);
    }

    // Tạo đơn hàng mới
    public function createOrder($data) {
        $sql = "INSERT INTO {$this->table} 
            (user_id, order_number, subtotal, shipping_fee, discount_amount, total_amount, status, payment_status, payment_method, shipping_address, shipping_phone)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        return $this->db->insert($sql, [
            $data['user_id'],
            $data['order_number'],
            $data['subtotal'],
            $data['shipping_fee'],
            $data['discount_amount'],
            $data['total_amount'],
            $data['status'],
            $data['payment_status'],
            $data['payment_method'],
            $data['shipping_address'],
            $data['shipping_phone']
        ]);
    }

    public function cancelOrder($id, $userId) {
        $sql = "UPDATE {$this->table} SET status = 'cancelled' WHERE id = ? AND user_id = ?";
        return $this->db->execute($sql, [$id, $userId]);
    }

}
