<?php
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

    // Lấy chi tiết theo id và user
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

    // Tổng doanh thu
    public function getTotalRevenue() {
        $sql = "SELECT SUM(total_amount) AS revenue FROM {$this->table} WHERE status = 'confirmed'";
        return $this->db->selectOne($sql)['revenue'] ?? 0;
    }

    // Tổng số đơn hàng (mọi trạng thái)
    public function getTotalOrders() {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
        return $this->db->selectOne($sql)['total'] ?? 0;
    }

    // Tổng số đơn hàng thành công (confirmed)
    public function getConfirmedOrders() {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table} WHERE status = 'confirmed'";
        return $this->db->selectOne($sql)['total'] ?? 0;
    }

    // Doanh thu theo tháng
    public function getRevenueByMonth() {
        $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS label, SUM(total_amount) AS revenue
                FROM {$this->table}
                WHERE status = 'confirmed'
                GROUP BY label
                ORDER BY label DESC
                LIMIT 12";
        return $this->db->select($sql);
    }

    // Doanh thu theo tuần
    public function getRevenueByWeek() {
        $sql = "SELECT CONCAT(YEAR(created_at), '-W', LPAD(WEEK(created_at, 1), 2, '0')) AS label, SUM(total_amount) AS revenue
                FROM {$this->table}
                WHERE status = 'confirmed'
                GROUP BY label
                ORDER BY label DESC
                LIMIT 9";
        return $this->db->select($sql);
    }

    // Doanh thu theo năm
    public function getRevenueByYear() {
        $sql = "SELECT YEAR(created_at) AS label, SUM(total_amount) AS revenue
                FROM {$this->table}
                WHERE status = 'confirmed'
                GROUP BY label
                ORDER BY label DESC
                LIMIT 6";
        return $this->db->select($sql);
    }

    // Số lượng đơn theo trạng thái
    public function getOrderCountByStatus() {
        $sql = "SELECT status, COUNT(*) AS count FROM {$this->table} GROUP BY status";
        return $this->db->select($sql);
    }

    public function searchOrders($keyword, $status = null) {
        $sql = "SELECT o.*, u.name AS customer_name
                FROM {$this->table} o
                LEFT JOIN users u ON o.user_id = u.id
                WHERE (o.order_number LIKE ? OR u.name LIKE ? OR o.shipping_address LIKE ?)";
        
        $kw = "%{$keyword}%";
        $params = [$kw, $kw, $kw];

        if (!empty($status)) {
            $sql .= " AND o.status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY o.created_at DESC";

        return $this->db->select($sql, $params);
    }

}
