<?php
/**
 * Session Class - Quản lý session
 * Cung cấp các phương thức tiện ích để làm việc với session
 */

class Session {
    
    /**
     * Khởi tạo session nếu chưa có
     */
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Lưu giá trị vào session
     * @param string $key
     * @param mixed $value
     */
    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }
    
    /**
     * Lấy giá trị từ session
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null) {
        self::start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    
    /**
     * Kiểm tra key có tồn tại trong session không
     * @param string $key
     * @return bool
     */
    public static function has($key) {
        self::start();
        return isset($_SESSION[$key]);
    }
    
    /**
     * Xóa một key khỏi session
     * @param string $key
     */
    public static function remove($key) {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    /**
     * Xóa toàn bộ session
     */
    public static function destroy() {
        self::start();
        session_destroy();
        $_SESSION = [];
    }
    
    /**
     * Lưu flash message
     * @param string $type - success, error, warning, info
     * @param string $message
     */
    public static function setFlash($type, $message) {
        self::set('flash_' . $type, $message);
    }
    
    /**
     * Lấy và xóa flash message
     * @param string $type
     * @return string|null
     */
    public static function getFlash($type) {
        $message = self::get('flash_' . $type);
        self::remove('flash_' . $type);
        return $message;
    }
    
    /**
     * Kiểm tra có flash message không
     * @param string $type
     * @return bool
     */
    public static function hasFlash($type) {
        return self::has('flash_' . $type);
    }
    
    /**
     * Lấy tất cả flash messages
     * @return array
     */
    public static function getAllFlash() {
        $flashes = [];
        $types = ['success', 'error', 'warning', 'info'];
        
        foreach ($types as $type) {
            if (self::hasFlash($type)) {
                $flashes[$type] = self::getFlash($type);
            }
        }
        
        return $flashes;
    }
    
    /**
     * Regenerate session ID
     */
    public static function regenerate() {
        self::start();
        session_regenerate_id(true);
    }
    
    /**
     * Lưu dữ liệu tạm thời (old input)
     * @param array $data
     */
    public static function setOldInput($data) {
        self::set('old_input', $data);
    }
    
    /**
     * Lấy old input
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getOldInput($key = null, $default = null) {
        $oldInput = self::get('old_input', []);
        
        if ($key === null) {
            return $oldInput;
        }
        
        return isset($oldInput[$key]) ? $oldInput[$key] : $default;
    }
    
    /**
     * Xóa old input
     */
    public static function clearOldInput() {
        self::remove('old_input');
    }
}
?>
