<?php
/**
 * Auth Class - Xử lý xác thực người dùng
 * Quản lý đăng nhập, đăng xuất, kiểm tra quyền
 */

class Auth {
    private $userModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        require_once 'models/User.php';
        $this->userModel = new User();
    }
    
    /**
     * Đăng nhập
     * @param string $email
     * @param string $password
     * @param bool $remember
     * @return bool
     */
    public function login($email, $password, $remember = false) {
        $user = $this->userModel->getByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            // Kiểm tra trạng thái tài khoản
            if ($user['status'] !== 'active') {
                return false;
            }
            
            // Lưu thông tin user vào session
            Session::set('user_id', $user['id']);
            Session::set('user_email', $user['email']);
            Session::set('user_name', $user['name']);
            Session::set('user_role', $user['role']);
            Session::set('logged_in', true);
            
            // Cập nhật last_login_at
            $this->userModel->update($user['id'], [
                'last_login_at' => date('Y-m-d H:i:s')
            ]);
            
            // Xử lý remember me
            if ($remember) {
                $token = $this->generateRememberToken();
                $this->userModel->update($user['id'], ['remember_token' => $token]);
                setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/'); // 30 days
            }
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Đăng xuất
     */
    public function logout() {
        // Xóa remember token nếu có
        if ($this->check()) {
            $userId = Session::get('user_id');
            $this->userModel->update($userId, ['remember_token' => null]);
        }
        
        // Xóa session
        Session::destroy();
        
        // Xóa remember cookie
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
    }
    
    /**
     * Kiểm tra đăng nhập
     * @return bool
     */
    public function check() {
        if (Session::get('logged_in')) {
            return true;
        }
        
        // Kiểm tra remember token
        if (isset($_COOKIE['remember_token'])) {
            $user = $this->userModel->getWhere(['remember_token' => $_COOKIE['remember_token']]);
            if ($user && $user['status'] === 'active') {
                // Tự động đăng nhập
                Session::set('user_id', $user['id']);
                Session::set('user_email', $user['email']);
                Session::set('user_name', $user['name']);
                Session::set('user_role', $user['role']);
                Session::set('logged_in', true);
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Lấy thông tin user hiện tại
     * @return array|null
     */
    public function user() {
        if (!$this->check()) {
            return null;
        }
        
        return [
            'id' => Session::get('user_id'),
            'email' => Session::get('user_email'),
            'name' => Session::get('user_name'),
            'role' => Session::get('user_role')
        ];
    }
    
    /**
     * Lấy ID user hiện tại
     * @return int|null
     */
    public function id() {
        return $this->check() ? Session::get('user_id') : null;
    }
    
    /**
     * Kiểm tra quyền admin
     * @return bool
     */
    public function isAdmin() {
        return $this->check() && Session::get('user_role') === 'admin';
    }
    
    /**
     * Kiểm tra quyền customer
     * @return bool
     */
    public function isCustomer() {
        return $this->check() && Session::get('user_role') === 'customer';
    }
    
    /**
     * Đăng ký tài khoản mới
     * @param array $data
     * @return int|false
     */
    public function register($data) {
        // Kiểm tra email đã tồn tại
        if ($this->userModel->getByEmail($data['email'])) {
            return false;
        }
        
        // Hash password
        $data['password'] = password_hash($data['password'], HASH_ALGO);
        $data['role'] = 'customer';
        $data['status'] = 'active';
        
        return $this->userModel->create($data);
    }
    
    /**
     * Thay đổi mật khẩu
     * @param int $userId
     * @param string $currentPassword
     * @param string $newPassword
     * @return bool
     */
    public function changePassword($userId, $currentPassword, $newPassword) {
        $user = $this->userModel->getById($userId);
        
        if ($user && password_verify($currentPassword, $user['password'])) {
            $hashedPassword = password_hash($newPassword, HASH_ALGO);
            return $this->userModel->update($userId, ['password' => $hashedPassword]);
        }
        
        return false;
    }
    
    /**
     * Tạo remember token
     * @return string
     */
    private function generateRememberToken() {
        return bin2hex(random_bytes(32));
    }
    
    /**
     * Kiểm tra quyền truy cập
     * @param string $permission
     * @return bool
     */
    public function can($permission) {
        // Implement logic kiểm tra quyền ở đây
        // Ví dụ: admin có tất cả quyền
        if ($this->isAdmin()) {
            return true;
        }
        
        // Implement logic phức tạp hơn nếu cần
        return false;
    }
}
?>
