<?php
/**
 * Product Model - Model cho bảng products
 * Xử lý các thao tác liên quan đến sản phẩm
 */

class Product extends Model {
    protected $table = 'products';
    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'sku', 
        'short_description', 'description', 'price', 'compare_price', 
        'cost_price', 'stock_quantity', 'min_stock_level', 
        'track_inventory', 'allow_backorder', 'weight', 'length', 
        'width', 'height', 'featured_image', 'gallery', 
        'meta_title', 'meta_description', 'meta_keywords', 
        'status', 'is_featured', 'is_digital'
    ];
    
    /**
     * Lấy sản phẩm theo slug
     * @param string $slug
     * @return array|null
     */
    public function getBySlug($slug) {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug,
                       b.name as brand_name, b.slug as brand_slug
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE p.slug = ? AND p.deleted_at IS NULL";
        
        return $this->db->selectOne($sql, [$slug]);
    }
    
    /**
     * Lấy sản phẩm theo danh mục
     * @param int $categoryId
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return array
     */
    public function getByCategory($categoryId, $page = 1, $perPage = 12, $filters = []) {
        $offset = ($page - 1) * $perPage;
        $conditions = ['category_id' => $categoryId, 'status' => 'active'];
        $params = [$categoryId, 'active'];
        
        $sql = "SELECT p.*, c.name as category_name, b.name as brand_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE p.category_id = ? AND p.status = ? AND p.deleted_at IS NULL";
        
        // Thêm filters
        if (isset($filters['brand_id'])) {
            $sql .= " AND p.brand_id = ?";
            $params[] = $filters['brand_id'];
        }
        
        if (isset($filters['min_price'])) {
            $sql .= " AND p.price >= ?";
            $params[] = $filters['min_price'];
        }
        
        if (isset($filters['max_price'])) {
            $sql .= " AND p.price <= ?";
            $params[] = $filters['max_price'];
        }
        
        // Sắp xếp
        $orderBy = isset($filters['sort']) ? $filters['sort'] : 'created_at DESC';
        $sql .= " ORDER BY {$orderBy} LIMIT {$perPage} OFFSET {$offset}";
        
        $data = $this->db->select($sql, $params);
        
        // Đếm tổng số
        $countSql = str_replace('SELECT p.*, c.name as category_name, b.name as brand_name', 'SELECT COUNT(*) as total', $sql);
        $countSql = preg_replace('/ORDER BY.*/', '', $countSql);
        $countSql = preg_replace('/LIMIT.*/', '', $countSql);
        
        $totalResult = $this->db->selectOne($countSql, array_slice($params, 0, -2));
        $total = $totalResult['total'];
        
        return [
            'data' => $data,
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'last_page' => ceil($total / $perPage)
        ];
    }

    /**
     * Lấy sản phẩm theo bộ lọc
     * @param array $filters
     * @param string $orderBy
     * @return array
     */
    public function getFiltered($filters = [], $orderBy = 'p.created_at DESC') {
    $sql = "SELECT p.*, c.name as category_name, b.name as brand_name
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            WHERE p.status = 'active' AND p.deleted_at IS NULL";

    $params = [];

    // Nếu lọc theo danh mục
    if (isset($filters['category_id'])) {
        $sql .= " AND p.category_id = ?";
        $params[] = $filters['category_id'];
    }

    // Bạn có thể thêm các filter khác như brand_id, price range ở đây nếu cần

    // Thêm sắp xếp
    $sql .= " ORDER BY $orderBy";

    return $this->db->select($sql, $params);
}

    
    /**
     * Lấy sản phẩm nổi bật
     * @param int $limit
     * @return array
     */
    public function getFeatured($limit = 8) {
        $sql = "SELECT p.*, c.name as category_name, b.name as brand_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE p.is_featured = 1 AND p.status = 'active' AND p.deleted_at IS NULL
                ORDER BY p.created_at DESC
                LIMIT {$limit}";
        
        return $this->db->select($sql);
    }
    
    /**
     * Lấy sản phẩm mới nhất
     * @param int $limit
     * @return array
     */
    public function getLatest($limit = 8) {
        $sql = "SELECT p.*, c.name as category_name, b.name as brand_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE p.status = 'active' AND p.deleted_at IS NULL
                ORDER BY p.created_at DESC
                LIMIT {$limit}";
        
        return $this->db->select($sql);
    }
    
    /**
     * Tìm kiếm sản phẩm
     * @param string $keyword
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @return array
     */
    public function search($keyword, $page = 1, $perPage = 12, $filters = []) {
        $offset = ($page - 1) * $perPage;
        $searchTerm = "%{$keyword}%";
        
        $sql = "SELECT p.*, c.name as category_name, b.name as brand_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE (p.name LIKE ? OR p.short_description LIKE ? OR p.sku LIKE ?)
                AND p.status = 'active' AND p.deleted_at IS NULL";
        
        $params = [$searchTerm, $searchTerm, $searchTerm];
        
        // Thêm filters
        if (isset($filters['category_id'])) {
            $sql .= " AND p.category_id = ?";
            $params[] = $filters['category_id'];
        }
        
        if (isset($filters['brand_id'])) {
            $sql .= " AND p.brand_id = ?";
            $params[] = $filters['brand_id'];
        }
        
        $sql .= " ORDER BY p.created_at DESC LIMIT {$perPage} OFFSET {$offset}";
        
        $data = $this->db->select($sql, $params);
        
        // Đếm tổng số
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} p
                     WHERE (p.name LIKE ? OR p.short_description LIKE ? OR p.sku LIKE ?)
                     AND p.status = 'active' AND p.deleted_at IS NULL";
        $countParams = [$searchTerm, $searchTerm, $searchTerm];
        
        if (isset($filters['category_id'])) {
            $countSql .= " AND p.category_id = ?";
            $countParams[] = $filters['category_id'];
        }
        
        if (isset($filters['brand_id'])) {
            $countSql .= " AND p.brand_id = ?";
            $countParams[] = $filters['brand_id'];
        }
        
        $totalResult = $this->db->selectOne($countSql, $countParams);
        $total = $totalResult['total'];
        
        return [
            'data' => $data,
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'last_page' => ceil($total / $perPage)
        ];
    }
    
    /**
     * Cập nhật số lượt xem
     * @param int $productId
     * @return bool
     */
    public function incrementViewCount($productId) {
        $sql = "UPDATE {$this->table} SET view_count = view_count + 1 WHERE id = ?";
        return $this->db->execute($sql, [$productId]);
    }
    
    /**
     * Cập nhật số lượng đã bán
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function incrementSoldCount($productId, $quantity) {
        $sql = "UPDATE {$this->table} SET sold_count = sold_count + ? WHERE id = ?";
        return $this->db->execute($sql, [$quantity, $productId]);
    }
    
    /**
     * Cập nhật stock quantity
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function updateStock($productId, $quantity) {
        $sql = "UPDATE {$this->table} SET stock_quantity = stock_quantity - ? WHERE id = ?";
        return $this->db->execute($sql, [$quantity, $productId]);
    }
    
    /**
     * Kiểm tra sản phẩm có đủ stock không
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function hasStock($productId, $quantity) {
        $product = $this->getById($productId);
        
        if (!$product) {
            return false;
        }
        
        // Nếu không track inventory thì luôn có stock
        if (!$product['track_inventory']) {
            return true;
        }
        
        // Nếu cho phép backorder thì luôn có stock
        if ($product['allow_backorder']) {
            return true;
        }
        
        return $product['stock_quantity'] >= $quantity;
    }
    
    /**
     * Lấy sản phẩm liên quan
     * @param int $productId
     * @param int $limit
     * @return array
     */
    public function getRelated($productId, $limit = 4) {
        $product = $this->getById($productId);
        
        if (!$product) {
            return [];
        }
        
        $sql = "SELECT p.*, c.name as category_name, b.name as brand_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE p.category_id = ? AND p.id != ? 
                AND p.status = 'active' AND p.deleted_at IS NULL
                ORDER BY RAND()
                LIMIT {$limit}";
        
        return $this->db->select($sql, [$product['category_id'], $productId]);
    }
    
    /**
     * Lấy thống kê sản phẩm
     * @return array
     */
    public function getStats() {
        $stats = [];
        
        // Tổng số sản phẩm
        $stats['total'] = $this->count(['deleted_at' => null]);
        
        // Sản phẩm active
        $stats['active'] = $this->count(['status' => 'active', 'deleted_at' => null]);
        
        // Sản phẩm hết hàng
        $sql = "SELECT COUNT(*) as total FROM {$this->table} 
                WHERE stock_quantity <= min_stock_level 
                AND track_inventory = 1 
                AND deleted_at IS NULL";
        $result = $this->db->selectOne($sql);
        $stats['low_stock'] = $result['total'];
        
        // Sản phẩm nổi bật
        $stats['featured'] = $this->count(['is_featured' => 1, 'deleted_at' => null]);
        
        return $stats;
    }
}
?>
