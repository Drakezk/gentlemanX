<?php
class OrderController extends Controller {
    private $orderModel;

    public function __construct() {
        parent::__construct();
        $this->orderModel = $this->model('Order');
    }

    // Danh sách đơn hàng
    public function index() {
        $orders = $this->orderModel->getAll([], 'created_at DESC');
        $data = [
            'title' => 'Quản lý đơn hàng',
            'orders' => $orders
        ];
        $this->view('orders/index', $data, 'admin');
    }

    // Sửa đơn hàng
    public function edit($id) {
        $order = $this->orderModel->getById($id);
        if (!$order) {
            Helper::redirect('admin/order/index');
            return;
        }

        // Chặn chỉnh sửa nếu đã xác nhận hoặc đã hủy
        if (in_array($order['status'], ['confirmed','cancelled'])) {
            // Bạn có thể redirect hoặc báo lỗi
            $_SESSION['error'] = 'Đơn hàng đã xác nhận hoặc đã hủy, không thể chỉnh sửa!';
            Helper::redirect('admin/order/index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updateData = [
                'status' => $_POST['status'],
                'payment_status' => $_POST['payment_status'],
                'payment_method' => $_POST['payment_method'],
                'shipping_address' => $_POST['shipping_address'],
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->orderModel->update($id, $updateData);
            Helper::redirect('admin/order/index');
        }

        $data = [
            'title' => 'Cập nhật đơn hàng',
            'order' => $order
        ];
        $this->view('orders/edit', $data, 'admin');
    }

    // Xóa đơn hàng
    public function delete($id) {
        $this->orderModel->delete($id);
        Helper::redirect('admin/order/index');
    }

    // Doanh thu thống kê
    public function stats() {
        $filter = $_GET['filter'] ?? 'month'; // Default: tháng

        switch ($filter) {
            case 'week':
                $monthlyRevenue = $this->orderModel->getRevenueByWeek();
                break;
            case 'year':
                $monthlyRevenue = $this->orderModel->getRevenueByYear();
                break;
            case 'month':
            default:
                $monthlyRevenue = $this->orderModel->getRevenueByMonth();
                break;
        }

        $totalRevenue = $this->orderModel->getTotalRevenue();
        $totalOrders = $this->orderModel->getTotalOrders();
        $successfulOrders = $this->orderModel->getConfirmedOrders();
        $orderByStatus = $this->orderModel->getOrderCountByStatus();

        $data = [
            'title' => 'Thống kê doanh thu',
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'successfulOrders' => $successfulOrders,
            'monthlyRevenue' => $monthlyRevenue,
            'orderByStatus' => $orderByStatus,
            'filter' => $filter
        ];

        $this->view('dashboard/stats', $data, 'admin');
    }
    
}
