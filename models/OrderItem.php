<?php
class OrderItem extends Model {
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id', 'product_id',
        'product_name', 'product_sku', 'product_image',
        'unit_price', 'quantity', 'total_price'
    ];

    /**
     * Tạo chi tiết đơn hàng mới
     */
    public function createItem($data) {
        $sql = "INSERT INTO {$this->table} (
            order_id, product_id,
            product_name, product_sku, product_image,
            unit_price, quantity, total_price
        ) VALUES (?,?,?,?,?,?,?,?)";

        return $this->db->insert($sql, [
            $data['order_id'],
            $data['product_id'],
            $data['product_name'],
            $data['product_sku'],
            $data['product_image'],
            $data['unit_price'],
            $data['quantity'],
            $data['total_price']
        ]);
    }

    /**
     * Lấy tất cả item theo order_id
     */
    public function getByOrderId($orderId) {
        $sql = "SELECT * FROM {$this->table} WHERE order_id = ?";
        return $this->db->select($sql, [$orderId]);
    }
}
