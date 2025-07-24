<?php
/**
 * Base Model Class - Lớp Model cơ sở
 * Tất cả các Model khác sẽ kế thừa từ lớp này
 * Cung cấp các phương thức CRUD cơ bản
 */

class Model {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $timestamps = true;
    
    /**
     * Constructor - Khởi tạo kết nối database
     */
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Lấy tất cả records từ table
     * @param array $conditions
     * @param string $orderBy
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAll($conditions = [], $orderBy = '', $limit = 0, $offset = 0) {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        
        // Thêm điều kiện WHERE
        if (!empty($conditions)) {
            $whereClause = [];
            foreach ($conditions as $field => $value) {
                $whereClause[] = "{$field} = ?";
                $params[] = $value;
            }
            $sql .= " WHERE " . implode(' AND ', $whereClause);
        }
        
        // Thêm ORDER BY
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        // Thêm LIMIT và OFFSET
        if ($limit > 0) {
            $sql .= " LIMIT {$limit}";
            if ($offset > 0) {
                $sql .= " OFFSET {$offset}";
            }
        }
        
        return $this->db->select($sql, $params);
    }
    
    /**
     * Lấy record theo ID
     * @param int $id
     * @return array|null
     */
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->selectOne($sql, [$id]);
    }
    
    /**
     * Lấy record theo điều kiện
     * @param array $conditions
     * @return array|null
     */
    public function getWhere($conditions) {
        $whereClause = [];
        $params = [];
        
        foreach ($conditions as $field => $value) {
            $whereClause[] = "{$field} = ?";
            $params[] = $value;
        }
        
        $sql = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $whereClause);
        return $this->db->selectOne($sql, $params);
    }
    
    /**
     * Thêm record mới
     * @param array $data
     * @return int|false - ID của record mới hoặc false nếu lỗi
     */
    public function create($data) {
        // Lọc dữ liệu theo fillable
        $data = $this->filterFillable($data);
        
        // Thêm timestamps
        if ($this->timestamps) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $fields = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        
        if ($this->db->execute($sql, $data)) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    /**
     * Cập nhật record
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        // Lọc dữ liệu theo fillable
        $data = $this->filterFillable($data);
        
        // Thêm updated_at
        if ($this->timestamps) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = :{$key}";
        }
        $fields = implode(', ', $fields);
        
        $sql = "UPDATE {$this->table} SET {$fields} WHERE {$this->primaryKey} = :id";
        $data['id'] = $id;
        
        return $this->db->execute($sql, $data);
    }
    
    /**
     * Xóa record
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->execute($sql, [$id]);
    }
    
    /**
     * Soft delete record
     * @param int $id
     * @return bool
     */
    public function softDelete($id) {
        $data = ['deleted_at' => date('Y-m-d H:i:s')];
        return $this->update($id, $data);
    }
    
    /**
     * Đếm số lượng records
     * @param array $conditions
     * @return int
     */
    public function count($conditions = []) {
        $where = '';
        $params = [];
        
        if (!empty($conditions)) {
            $whereClause = [];
            foreach ($conditions as $field => $value) {
                $whereClause[] = "{$field} = ?";
                $params[] = $value;
            }
            $where = implode(' AND ', $whereClause);
        }
        
        return $this->db->count($this->table, $where, $params);
    }
    
    /**
     * Phân trang
     * @param int $page
     * @param int $perPage
     * @param array $conditions
     * @param string $orderBy
     * @return array
     */
    public function paginate($page = 1, $perPage = 10, $conditions = [], $orderBy = '') {
        $offset = ($page - 1) * $perPage;
        $data = $this->getAll($conditions, $orderBy, $perPage, $offset);
        $total = $this->count($conditions);
        
        return [
            'data' => $data,
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'last_page' => ceil($total / $perPage)
        ];
    }
    
    /**
     * Lọc dữ liệu theo fillable
     * @param array $data
     * @return array
     */
    protected function filterFillable($data) {
        if (empty($this->fillable)) {
            return $data;
        }
        
        return array_intersect_key($data, array_flip($this->fillable));
    }
    
    /**
     * Thực thi raw SQL
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function raw($sql, $params = []) {
        return $this->db->select($sql, $params);
    }

    // Trong class Model
public function insert($data) {
    $fields = array_keys($data);
    $placeholders = implode(',', array_fill(0, count($fields), '?'));
    $columns = implode(',', $fields);

    $values = array_values($data);

    $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
    return $this->db->insert($sql, $values); // giả sử Database class có insert
}

}
?>
