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
        return $this->getCategory(['parent_id' => null, 'status' => 'active'], 'sort_order ASC, name ASC');
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

    /**
     * Quan ly danh mục
     */
    public function create($data) {
        $fields = array_keys($data);
        $placeholders = array_fill(0, count($fields), '?');
        $sql = "INSERT INTO {$this->table} (".implode(',', $fields).") VALUES (".implode(',', $placeholders).")";
        return $this->db->execute($sql, array_values($data));
    }

    public function update($id, $data) {
        $fields = [];
        $params = [];
        foreach ($data as $k => $v) {
            $fields[] = "`$k`=?";
            $params[] = $v;
        }
        $params[] = $id;
        $sql = "UPDATE {$this->table} SET ".implode(',', $fields)." WHERE id=?";
        return $this->db->execute($sql, $params);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id=?";
        return $this->db->execute($sql, [$id]);
    }
}
?>
