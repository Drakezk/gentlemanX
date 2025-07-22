<?php
class CartController extends Controller {
    private $cartItemModel;

    public function __construct() {
        parent::__construct();
        $this->cartItemModel = $this->model('CartItem');
    }

    private function currentSessionId() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return session_id();
    }

    public function index() {
        $userId = $_SESSION['user']['id'] ?? null;
        $sessionId = $userId ? null : $this->currentSessionId();

        $items = $this->cartItemModel->getByUserOrSession($userId, $sessionId);

        $this->view('home/cart', [
            'items' => $items,
            'title' => 'Giỏ hàng'
        ], 'client');
    }

    public function add($productId = null) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user']['id'] ?? null;
            $sessionId = $userId ? null : $this->currentSessionId();

            $productId = (int)$_POST['product_id'];
            $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            $this->cartItemModel->addItem($userId, $sessionId, $productId, $qty);

            Helper::redirect('cart');
            return;
        }

        // Cho phép gọi trực tiếp qua URL (GET)
        if ($productId) {
            $userId    = $_SESSION['user']['id'] ?? null;
            $sessionId = $userId ? null : session_id();

            $this->cartItemModel->addItem($userId, $sessionId, (int)$productId, 1);
            Helper::redirect('cart');
            return;
        }
        
        Helper::redirect('cart');
    }

    public function remove($id) {
        $userId = $_SESSION['user']['id'] ?? null;
        $sessionId = $userId ? null : $this->currentSessionId();

        $this->cartItemModel->removeItem($id, $userId, $sessionId);
        Helper::redirect('cart');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user']['id'] ?? null;
            $sessionId = $userId ? null : $this->currentSessionId();

            $id = (int)$_POST['cart_id'];
            $qty = (int)$_POST['quantity'];

            $this->cartItemModel->updateItem($id, $qty, $userId, $sessionId);
        }
        Helper::redirect('cart');
    }
}
