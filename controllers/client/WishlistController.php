<?php
class WishlistController extends Controller {
    private $wishlistModel;

    public function __construct() {
        parent::__construct();
        $this->wishlistModel = $this->model('Wishlist');
    }

    // Danh sách wishlist
    public function index() {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            Helper::redirect('auth/login');
            return;
        }
        $items = $this->wishlistModel->getByUser($userId);
        $this->view('home/wishlist', ['items' => $items], 'client');
    }

    // Thêm vào wishlist
    public function add($productId) {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            Helper::redirect('auth/login');
            return;
        }
        $this->wishlistModel->add($userId, $productId);
        Helper::redirect('wishlist');
    }

    // Xóa khỏi wishlist
    public function remove($productId) {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            Helper::redirect('auth/login');
            return;
        }
        $this->wishlistModel->remove($userId, $productId);
        Helper::redirect('wishlist');
    }
}
