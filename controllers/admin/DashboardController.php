<?php
/**
 * Dashboard Controller - Controller cho trang quản trị
 * Xử lý các request liên quan đến dashboard admin
 */

class DashboardController extends Controller {
    private $userModel;
    private $productModel;
    private $orderModel;
    
    public function __construct() {
        parent::__construct();
        $this->requireAdmin();
        
        $this->userModel = $this->model('User');
        $this->productModel = $this->model('Product');
        // $this->orderModel = $this->model('Order');
    }
    
    /**
     * Trang dashboard chính
     */
    public function index() {
        // Lấy thống kê
        $userStats = $this->userModel->getStats();
        $productStats = $this->productModel->getStats();
        // $orderStats = $this->orderModel->getStats();
        
        // Sản phẩm mới nhất
        $latestProducts = $this->productModel->getLatest(5);
        
        // Users mới nhất
        $latestUsers = $this->userModel->getAll(['role' => 'customer'], 'created_at DESC', 5);
        
        $data = [
            'title' => 'Dashboard',
            'userStats' => $userStats,
            'productStats' => $productStats,
            // 'orderStats' => $orderStats,
            'latestProducts' => $latestProducts,
            'latestUsers' => $latestUsers
        ];
        
        $this->view('dashboard/index', $data, 'admin');
    }
    
    /**
     * Thống kê chi tiết
     */
    public function stats() {
        // Implement thống kê chi tiết
        $data = [
            'title' => 'Thống kê'
        ];
        
        $this->view('dashboard/stats', $data, 'admin');
    }
}
?>
