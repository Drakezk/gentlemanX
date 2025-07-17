<?php
/**
 * Category Model - Model cho bảng categories
 * Xử lý các thao tác liên quan đến danh mục sản phẩm
 */

class Category extends Model {
    protected $table = 'categories';
    protected $fillable = [
        'parent_id', 'name', 'slug', 'description', 'image',
        'meta_title', 'meta_description', 'sort_order', 'status'
    ];
    
    /**
     * Lấy category theo slug
     * @param string $slug
     * @return array|null
     */
    public function getBySlug($slug) {
        $sql = "SELECT c.*, parent.name as parent_name
                FROM {$this->table} c
                LEFT JOIN {$this->table} parent ON c.parent_id = parent.id
                WHERE c.slug = ? AND c.deleted_at IS NULL";
        
        return $this->db->selectOne($sql, [$slug]);
    }
    
    /**
     * Lấy danh mục cha
     * @return array
     */
    public function getParentCategories() {
        return $this->getAll(['parent_id' => null, 'status' => 'active'], 'sort_order ASC, name ASC');
    }
    
    /**
     * Lấy danh mục con
     * @param int $parentId
     * @return array
     */
    public function getChildCategories($parentId) {
        return $this->getAll(['parent_id' => $parentId, 'status' => 'active'], 'sort_order ASC, name ASC');
    }
    
    /**
     * Lấy cây danh mục
     * @return array
     */
    public function getCategoryTree() {
        $parents = $this->getParentCategories();
        $tree = [];
        
        foreach ($parents as $parent) {
            $parent['children'] = $this->getChildCategories($parent['id']);
            $tree[] = $parent;
        }
        
        return $tree;
    }
    
    /**
     * Lấy breadcrumb của category
     * @param int $categoryId
     * @return array
     */
    public function getBreadcrumb($categoryId) {
        $breadcrumb = [];
        $category = $this->getById($categoryId);
        
        while ($category) {
            array_unshift($breadcrumb, $category);
            
            if ($category['parent_id']) {
                $category = $this->getById($category['parent_id']);
            } else {
                break;
            }
        }
        
        return $breadcrumb;
    }
    
    /**
     * Kiểm tra slug đã tồn tại chưa
     * @param string $slug
     * @param int $excludeId
     * @return bool
     */
    public function slugExists($slug, $excludeId = null) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE slug = ? AND deleted_at IS NULL";
        $params = [$slug];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $result = $this->db->selectOne($sql, $params);
        return $result['total'] > 0;
    }
    
    /**
     * Lấy số lượng sản phẩm trong danh mục
     * @param int $categoryId
     * @return int
     */
    public function getProductCount($categoryId) {
        $sql = "SELECT COUNT(*) as total FROM products 
                WHERE category_id = ? AND status = 'active' AND deleted_at IS NULL";
        $result = $this->db->selectOne($sql, [$categoryId]);
        return $result['total'];
    }
}
?>
