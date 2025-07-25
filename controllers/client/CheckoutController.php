<?php
class CheckoutController extends Controller {
    private $cartItemModel;
    private $orderModel;
    private $orderItemModel;

    public function __construct() {
        parent::__construct();
        $this->cartItemModel = $this->model('CartItem');
        $this->orderModel = $this->model('Order');
        $this->orderItemModel = $this->model('OrderItem');
    }

    public function index() {
        $user = $_SESSION['user'] ?? null;
        $userId = $_SESSION['user']['id'] ?? null;
        $sessionId = session_id();

        $cartItems = $this->cartItemModel->getCartItems($userId, $sessionId);
        if (empty($cartItems)) {
            Helper::redirect('cart');
            return;
        }

        // Tính tổng
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $data = [
            'user'    => $user,
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shipping_fee' => 30000,
            'discount_amount' => 0,
            'total_amount' => $subtotal + 30000
        ];

        $this->view('checkout/index', $data, 'client');
    }

    public function placeOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user']['id'] ?? null;
            $sessionId = session_id();
            $cartItems = $this->cartItemModel->getCartItems($userId, $sessionId);

            if (empty($cartItems)) {
                Helper::redirect('cart');
            }

            // Lấy dữ liệu form
            $data = [
                'user_id' => $userId,
                'order_number' => 'ORD' . time(),
                'customer_name' => $_POST['customer_name'],
                'customer_email' => $_POST['customer_email'],
                'customer_phone' => $_POST['customer_phone'],

                'shipping_name' => $_POST['shipping_name'],
                'shipping_phone' => $_POST['shipping_phone'],
                'shipping_province' => $_POST['shipping_province'],
                'shipping_district' => $_POST['shipping_district'],
                'shipping_ward' => $_POST['shipping_ward'],
                'shipping_address' => $_POST['shipping_address'],
                'shipping_postal_code' => $_POST['shipping_postal_code'],

                'subtotal' => $_POST['subtotal'],
                'shipping_fee' => $_POST['shipping_fee'],
                'tax_amount' => $_POST['tax_amount'],
                'discount_amount' => $_POST['discount_amount'],
                'total_amount' => $_POST['total_amount'],

                'coupon_code' => null,
                'coupon_discount' => 0,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $_POST['payment_method'],
                'notes' => $_POST['notes']
            ];

            $orderId = $this->orderModel->createOrder($data);
            if ($orderId) {
                foreach ($cartItems as $item) {
                    $this->orderItemModel->createItem([
                        'order_id'      => $orderId,
                        'product_id'    => $item['product_id'],
                        'product_name'  => $item['name'],
                        'product_sku'   => $item['sku'] ?? '',
                        'product_image' => $item['featured_image'] ?? '',
                        'unit_price'    => $item['price'],
                        'quantity'      => $item['quantity'],
                        'total_price'   => $item['price'] * $item['quantity']
                    ]);
                }
                $this->cartItemModel->clearCart($userId, $sessionId);

                Helper::redirect('checkout/success/' . $orderId);
            } else {
                echo "Đặt hàng thất bại!";
            }
        }
    }

    // Trang thành công
    public function success($orderId) {
        $order = $this->orderModel->getByIdAndUser($orderId, $_SESSION['user']['id'] ?? null);
        $items = $this->orderItemModel->getByOrderId($orderId);

        $this->view('checkout/success', [
            'order' => $order,
            'items' => $items
        ], 'client');
    }

    public function detail($id) {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            // Nếu chưa đăng nhập thì yêu cầu đăng nhập
            Helper::redirect('auth/login');
            return;
        }

        // Lấy thông tin đơn hàng (theo user hiện tại)
        $order = $this->orderModel->getByIdAndUser($id, $userId);
        if (!$order) {
            echo "<h3 class='text-danger'>Đơn hàng không tồn tại hoặc không thuộc về bạn!</h3>";
            return;
        }

        // Lấy danh sách sản phẩm trong đơn hàng
        $orderItems = $this->orderItemModel->getByOrderId($id);

        $data = [
            'order' => $order,
            'orderItems' => $orderItems
        ];

        $this->view('home/orderDetail', $data, 'client');
    }
}
