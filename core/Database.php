<?php
/**
 * Class Database - Quản lý kết nối cơ sở dữ liệu
 * Sử dụng Singleton pattern và PDO để đảm bảo kết nối an toàn
 */

class Database {
    private static $instance = null;
    private $connection;
    private $config;
    
    /**
     * Constructor - Private để implement Singleton
     */
    private function __construct() {
        $configPath = ROOT_PATH . 'config/database.php';
        
        // Kiểm tra xem file cấu hình có tồn tại không
        if (!file_exists($configPath)) {
            die("Lỗi: File cấu hình database không tìm thấy tại: " . $configPath);
        }
        
        // Tải file cấu hình
        $this->config = require_once $configPath;

        // Kiểm tra xem file cấu hình có trả về một mảng hợp lệ không
        if (!is_array($this->config)) {
            die("Lỗi: File cấu hình database không trả về mảng hợp lệ. Vui lòng kiểm tra cú pháp.");
        }
        
        $this->connect();
    }
    
    /**
     * Kết nối database
     */
    private function connect() {
        try {
            // Xây dựng DSN (Data Source Name)
            // Bỏ 'charset' ra khỏi DSN, chỉ dựa vào PDO::MYSQL_ATTR_INIT_COMMAND để thiết lập bộ mã
            $dsn = "mysql:host={$this->config['host']};dbname={$this->config['dbname']}";
            
            $this->connection = new PDO(
                $dsn,
                $this->config['username'],
                $this->config['password'],
                $this->config['options']
            );
        } catch (PDOException $e) {
            die("Lỗi kết nối database: " . $e->getMessage());
        }
    }
    
    /**
     * Lấy instance của Database (Singleton)
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Lấy connection PDO
     * @return PDO
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Thực thi câu query SELECT
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function select($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Database Select Error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Thực thi câu query SELECT và trả về 1 record
     * @param string $sql
     * @param array $params
     * @return array|null
     */
    public function selectOne($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch();
            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Database SelectOne Error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Thực thi câu query INSERT, UPDATE, DELETE
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public function execute($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Database Execute Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Lấy ID của record vừa insert
     * @return string
     */
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
    
    /**
     * Bắt đầu transaction
     */
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    
    /**
     * Commit transaction
     */
    public function commit() {
        return $this->connection->commit();
    }
    
    /**
     * Rollback transaction
     */
    public function rollback() {
        return $this->connection->rollback();
    }
    
    /**
     * Đếm số lượng records
     * @param string $table
     * @param string $where
     * @param array $params
     * @return int
     */
    public function count($table, $where = '', $params = []) {
        $sql = "SELECT COUNT(*) as total FROM {$table}";
        if ($where) {
            $sql .= " WHERE {$where}";
        }
        
        $result = $this->selectOne($sql, $params);
        return $result ? (int)$result['total'] : 0;
    }
}
?>
