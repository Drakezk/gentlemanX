<?php
/**
 * User Model
 * Xử lý các thao tác liên quan đến người dùng
 */

class User extends Model {
    protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'avatar', 
        'date_of_birth', 'gender', 'role', 'status', 
        'email_verified_at', 'last_login_at', 'remember_token'
    ];
    
    /**
     * Lấy user theo email
     */
    public function getByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? AND deleted_at IS NULL";
        return $this->db->selectOne($sql, [$email]);
    }
    
    /**
     * Lấy user theo remember token
     */
    public function getByRememberToken($token) {
        $sql = "SELECT * FROM {$this->table} WHERE remember_token = ? AND deleted_at IS NULL";
        return $this->db->selectOne($sql, [$token]);
    }
    
    /**
     * Lấy danh sách customers
     */
    public function getCustomers($page = 1, $perPage = 20, $filters = []) {
        $conditions = ['role' => 'customer'];
        
        if (isset($filters['status'])) {
            $conditions['status'] = $filters['status'];
        }
        
        return $this->paginate($page, $perPage, $conditions, 'created_at DESC');
    }
    
    /**
     * Lấy danh sách admins
     */
    public function getAdmins() {
        return $this->getAll(['role' => 'admin'], 'created_at DESC');
    }
    
    /**
     * Tìm kiếm users
     */
    public function search($keyword, $page = 1, $perPage = 20) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM {$this->table} 
                WHERE (name LIKE ? OR email LIKE ?) 
                AND deleted_at IS NULL 
                ORDER BY created_at DESC 
                LIMIT {$perPage} OFFSET {$offset}";
        
        $searchTerm = "%{$keyword}%";
        $data = $this->db->select($sql, [$searchTerm, $searchTerm]);
        
        // Đếm tổng số
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} 
                     WHERE (name LIKE ? OR email LIKE ?) 
                     AND deleted_at IS NULL";
        $totalResult = $this->db->selectOne($countSql, [$searchTerm, $searchTerm]);
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
     * Cập nhật thông tin profile
     */
    public function updateProfile($userId, $data) {
        // Loại bỏ các field không được phép cập nhật
        unset($data['password'], $data['role'], $data['email']);
        
        return $this->update($userId, $data);
    }
    
    /**
     * Thay đổi mật khẩu
     */
    public function changePassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, HASH_ALGO);
        return $this->update($userId, ['password' => $hashedPassword]);
    }
    
    /**
     * Kích hoạt/vô hiệu hóa tài khoản
     */
    public function changeStatus($userId, $status) {
        $allowedStatuses = ['active', 'inactive', 'banned'];
        
        if (!in_array($status, $allowedStatuses)) {
            return false;
        }
        
        return $this->update($userId, ['status' => $status]);
    }
    
    /**
     * Lấy thống kê users
     */
    public function getStats() {
        $stats = [];

        // Tổng số users (chưa xóa mềm)
        $sqlTotal = "SELECT COUNT(*) as total FROM {$this->table} WHERE deleted_at IS NULL";
        $resTotal = $this->db->selectOne($sqlTotal);
        $stats['total'] = ($resTotal && isset($resTotal['total'])) ? (int)$resTotal['total'] : 0;

        // Số customers
        $sqlCustomers = "SELECT COUNT(*) as total FROM {$this->table} WHERE role = 'customer' AND deleted_at IS NULL";
        $resCustomers = $this->db->selectOne($sqlCustomers);
        $stats['customers'] = ($resCustomers && isset($resCustomers['total'])) ? (int)$resCustomers['total'] : 0;

        // Số admins
        $sqlAdmins = "SELECT COUNT(*) as total FROM {$this->table} WHERE role = 'admin' AND deleted_at IS NULL";
        $resAdmins = $this->db->selectOne($sqlAdmins);
        $stats['admins'] = ($resAdmins && isset($resAdmins['total'])) ? (int)$resAdmins['total'] : 0;

        // Users đang active
        $sqlActive = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'active' AND deleted_at IS NULL";
        $resActive = $this->db->selectOne($sqlActive);
        $stats['active'] = ($resActive && isset($resActive['total'])) ? (int)$resActive['total'] : 0;

        // Users đăng ký trong tháng này
        $sqlThisMonth = "SELECT COUNT(*) as total FROM {$this->table}
                        WHERE MONTH(created_at) = MONTH(CURRENT_DATE())
                        AND YEAR(created_at) = YEAR(CURRENT_DATE())
                        AND deleted_at IS NULL";
        $resMonth = $this->db->selectOne($sqlThisMonth);
        $stats['this_month'] = ($resMonth && isset($resMonth['total'])) ? (int)$resMonth['total'] : 0;

        return $stats;
    }
    
    /**
     * Xóa mềm user
     */
    public function softDelete($userId) {
        return $this->update($userId, ['deleted_at' => date('Y-m-d H:i:s')]);
    }
    
    /**
     * Khôi phục user đã xóa mềm
     */
    public function restore($userId) {
        return $this->update($userId, ['deleted_at' => null]);
    }
    
    /**
     * Kiểm tra email đã tồn tại chưa
     */
    public function emailExists($email, $excludeId = null) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE email = ? AND deleted_at IS NULL";
        $params = [$email];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $result = $this->db->selectOne($sql, $params);
        return $result['total'] > 0;
    }

    // Lấy tất cả user (bỏ qua deleted_at)
    public function getAllUsers() {
        $sql = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL ORDER BY created_at DESC";
        return $this->db->select($sql);
    }

    // Lấy 1 user
    public function getUser($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? AND deleted_at IS NULL";
        return $this->db->selectOne($sql, [$id]);
    }

    public function find($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        return $this->db->selectOne($sql, [$id]);
    }


    // Thêm mới user
    public function createUser($data) {
        // Tự động bổ sung thời gian
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        // Chuẩn bị cột và giá trị
        $fields = array_keys($data);
        $placeholders = array_fill(0, count($fields), '?');
        $sql = "INSERT INTO {$this->table} (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
        $values = array_values($data);

        return $this->db->insert($sql, $values);
    }

    // Cập nhật user
    public function updateUser($id, $data) {
        // Xây dựng câu lệnh UPDATE thủ công
        $fields = [];
        $params = [];

        foreach ($data as $key => $value) {
            $fields[] = "`$key` = ?";
            $params[] = $value;
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE {$this->primaryKey} = ?";
        $params[] = $id;

        return $this->db->execute($sql, $params);
    }

    // Xóa mềm user
    public function deleteUser($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->execute($sql, [$id]);
    }

    public function searchCustomers($keyword, $status = null) {
        $sql = "SELECT * FROM {$this->table}
                WHERE role = 'customer'
                AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)";
        
        $kw = "%{$keyword}%";
        $params = [$kw, $kw, $kw];

        if (!empty($status)) {
            $sql .= " AND status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY created_at DESC";

        return $this->db->select($sql, $params);
    }

    public function searchAdmins($keyword, $status = null) {
        $sql = "SELECT * FROM {$this->table}
                WHERE role = 'admin'
                AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)";
        
        $kw = "%{$keyword}%";
        $params = [$kw, $kw, $kw];

        if (!empty($status)) {
            $sql .= " AND status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY created_at DESC";

        return $this->db->select($sql, $params);
    }

}
?>
