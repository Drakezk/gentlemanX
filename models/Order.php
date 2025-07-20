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
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? AND user_id = ?";
        return $this->db->selectOne($sql, [$id, $userId]);
    }

    // Tạo đơn hàng mới
    public function createOrder($data) {
        $sql = "INSERT INTO {$this->table} 
            (user_id, order_number, subtotal, shipping_fee, tax_amount, discount_amount, total_amount, status, payment_status, payment_method)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        return $this->db->insert($sql, [
            $data['user_id'],
            $data['order_number'],
            $data['subtotal'],
            $data['shipping_fee'],
            $data['tax_amount'],
            $data['discount_amount'],
            $data['total_amount'],
            $data['status'],
            $data['payment_status'],
            $data['payment_method']
        ]);
    }
}
