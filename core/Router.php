<?php
/**
 * Router Class - Xử lý điều hướng URL
 * Phân tích URL và gọi controller/action tương ứng
 * Hỗ trợ routing cho cả Client và Admin area
 */

class Router {
    private $routes = [];
    
    /**
     * Xử lý request từ URL
     */
    public function handleRequest() {
        $url = $this->parseUrl();
        
        // Kiểm tra nếu là admin area
        if (isset($url[0]) && $url[0] === ADMIN_PREFIX) {
            $this->handleAdminRequest(array_slice($url, 1));
        } else {
            $this->handleClientRequest($url);
        }
    }
    
    /**
     * Xử lý request cho Client area
     * @param array $url
     */
    private function handleClientRequest($url) {
        $controllerName = isset($url[0]) ? ucfirst($url[0]) : DEFAULT_CONTROLLER;
        $actionName = isset($url[1]) ? $url[1] : DEFAULT_ACTION;
        $params = array_slice($url, 2);
        
        // Xử lý các route đặc biệt
        if ($controllerName === 'Product' && isset($url[1]) && $url[1] !== 'category') {
            // URL: /product/slug-san-pham -> ProductController::detail($slug)
            $actionName = 'detail';
            $params = [$url[1]];
        } elseif ($controllerName === 'Category' && isset($url[1])) {
            // URL: /category/slug-danh-muc -> CategoryController::products($slug)
            $actionName = 'products';
            $params = [$url[1]];
        }
        
        $this->loadController('client', $controllerName, $actionName, $params);
    }
    
    /**
     * Xử lý request cho Admin area
     * @param array $url
     */
    private function handleAdminRequest($url) {
        $controllerName = isset($url[0]) ? ucfirst($url[0]) : 'Dashboard';
        $actionName = isset($url[1]) ? $url[1] : 'index';
        $params = array_slice($url, 2);
        
        $this->loadController('admin', $controllerName, $actionName, $params);
    }
    
    /**
     * Load controller và thực thi action
     * @param string $area - client hoặc admin
     * @param string $controllerName
     * @param string $actionName
     * @param array $params
     */
    private function loadController($area, $controllerName, $actionName, $params) {
        $controllerPath = "controllers/{$area}/{$controllerName}Controller.php";
        
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            
            $controllerClass = $controllerName . 'Controller';
            
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                
                if (method_exists($controller, $actionName)) {
                    call_user_func_array([$controller, $actionName], $params);
                } else {
                    $this->show404("Action '{$actionName}' không tồn tại trong controller '{$controllerClass}'");
                }
            } else {
                $this->show404("Controller class '{$controllerClass}' không tồn tại");
            }
        } else {
            $this->show404("Controller file không tồn tại: {$controllerPath}");
        }
    }
    
    /**
     * Phân tích URL thành mảng
     * @return array
     */
    private function parseUrl() {
        if (isset($_GET['url'])) {
            $url = filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL);
            return $url ? explode('/', $url) : [];
        }
        return [];
    }
    
    /**
     * Hiển thị trang 404
     * @param string $message
     */
    private function show404($message = 'Trang không tồn tại') {
        http_response_code(404);
        
        // Kiểm tra xem có file 404 không
        $errorFile = 'views/errors/404.php';
        if (file_exists($errorFile)) {
            include $errorFile;
        } else {
            echo "<h1>404 - Không tìm thấy trang</h1>";
            echo "<p>{$message}</p>";
            echo "<a href='" . BASE_URL . "'>Về trang chủ</a>";
        }
        exit();
    }
    
    /**
     * Thêm route tùy chỉnh
     * @param string $pattern
     * @param string $controller
     * @param string $action
     */
    public function addRoute($pattern, $controller, $action) {
        $this->routes[$pattern] = [
            'controller' => $controller,
            'action' => $action
        ];
    }
}
?>
