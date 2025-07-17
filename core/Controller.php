<?php
/**
 * Base Controller Class - Lớp Controller cơ sở
 * Tất cả các Controller khác sẽ kế thừa từ lớp này
 * Cung cấp các phương thức tiện ích cho controller
 */

class Controller {
    protected $auth;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->auth = new Auth();
    }
    
    /**
     * Load view file
     * @param string $view - Tên file view
     * @param array $data - Dữ liệu truyền vào view
     * @param string $layout - Layout sử dụng (client/admin)
     */
    protected function view($view, $data = [], $layout = 'client') {
        // Extract data để sử dụng trong view
        extract($data);
        
        // Thêm các biến global
        $auth = $this->auth;
        $currentUser = $this->auth->user();
        $isLoggedIn = $this->auth->check();
        
        // Xác định đường dẫn view
        $viewPath = "views/{$layout}/{$view}.php";
        
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            $this->show404("View không tồn tại: {$viewPath}");
        }
    }
    
    /**
     * Load model
     * @param string $model - Tên model
     * @return object
     */
    protected function model($model) {
        $modelPath = "models/{$model}.php";
        
        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $model();
        } else {
            die("Model không tồn tại: {$modelPath}");
        }
    }
    
    /**
     * Redirect đến URL khác
     * @param string $url
     */
    protected function redirect($url) {
        // Nếu URL không bắt đầu bằng http, thêm BASE_URL
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = BASE_URL . ltrim($url, '/');
        }
        
        header("Location: " . $url);
        exit();
    }
    
    /**
     * Redirect với thông báo
     * @param string $url
     * @param string $message
     * @param string $type - success, error, warning, info
     */
    protected function redirectWithMessage($url, $message, $type = 'success') {
        Session::setFlash($type, $message);
        $this->redirect($url);
    }
    
    /**
     * Trả về JSON response
     * @param array $data
     * @param int $statusCode
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    /**
     * Kiểm tra method request
     * @param string $method
     * @return bool
     */
    protected function isMethod($method) {
        return $_SERVER['REQUEST_METHOD'] === strtoupper($method);
    }
    
    /**
     * Lấy dữ liệu POST
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function post($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
    }
    
    /**
     * Lấy dữ liệu GET
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function get($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return isset($_GET[$key]) ? trim($_GET[$key]) : $default;
    }
    
    /**
     * Validate dữ liệu đầu vào
     * @param array $data
     * @param array $rules
     * @return array - Mảng lỗi (rỗng nếu không có lỗi)
     */
    protected function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            $value = isset($data[$field]) ? $data[$field] : '';
            $ruleList = explode('|', $rule);
            
            foreach ($ruleList as $singleRule) {
                if ($singleRule === 'required' && empty($value)) {
                    $errors[$field] = ucfirst($field) . ' là bắt buộc';
                    break;
                }
                
                if (strpos($singleRule, 'min:') === 0 && strlen($value) < substr($singleRule, 4)) {
                    $errors[$field] = ucfirst($field) . ' phải có ít nhất ' . substr($singleRule, 4) . ' ký tự';
                    break;
                }
                
                if (strpos($singleRule, 'max:') === 0 && strlen($value) > substr($singleRule, 4)) {
                    $errors[$field] = ucfirst($field) . ' không được quá ' . substr($singleRule, 4) . ' ký tự';
                    break;
                }
                
                if ($singleRule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = ucfirst($field) . ' không đúng định dạng email';
                    break;
                }
                
                if ($singleRule === 'numeric' && !is_numeric($value)) {
                    $errors[$field] = ucfirst($field) . ' phải là số';
                    break;
                }
            }
        }
        
        return $errors;
    }
    
    /**
     * Kiểm tra quyền admin
     */
    protected function requireAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        $_SESSION['error'] = 'Bạn không có quyền truy cập trang quản trị.';
        Helper::redirect('auth/showLogin'); // hoặc admin/login
        exit();
    }
    }
    
    /**
     * Kiểm tra đăng nhập
     */
    protected function requireAuth() {
        if (!$this->auth->check()) {
            $this->redirect('auth/login');
        }
    }
    
    /**
     * Upload file
     * @param array $file - $_FILES['field_name']
     * @param string $folder - Thư mục lưu file
     * @return string|false - Đường dẫn file hoặc false nếu lỗi
     */
    protected function uploadFile($file, $folder = 'general') {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        
        // Kiểm tra kích thước file
        if ($file['size'] > MAX_FILE_SIZE) {
            return false;
        }
        
        // Kiểm tra loại file
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, ALLOWED_IMAGE_TYPES)) {
            return false;
        }
        
        // Tạo tên file unique
        $fileName = uniqid() . '.' . $extension;
        $uploadDir = UPLOAD_PATH . $folder . '/';
        
        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $uploadPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return $folder . '/' . $fileName;
        }
        
        return false;
    }
    
    /**
     * Hiển thị trang 404
     * @param string $message
     */
    protected function show404($message = 'Trang không tồn tại') {
    http_response_code(404);
    $errorFile = 'views/errors/404.php';
    if (file_exists($errorFile)) {
        // Truyền message vào biến cục bộ
        $messageVar = $message;
        include $errorFile;
    } else {
        echo "<h1>404 - Không tìm thấy trang</h1>";
        echo "<p>{$message}</p>";
        echo "<a href='" . BASE_URL . "'>Về trang chủ</a>";
    }
    exit();
}

}
?>
