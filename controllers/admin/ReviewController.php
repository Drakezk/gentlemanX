<?php
class ReviewController extends Controller {
    private $reviewModel;
    private $productModel;
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->reviewModel = $this->model('Review');
        $this->productModel = $this->model('Product');
        $this->userModel = $this->model('User');
    }

    // Danh sách tất cả đánh giá
    public function index() {
        $reviews = $this->reviewModel->getAllWithDetails(); // JOIN product, user
        $this->view('reviews/index', ['reviews' => $reviews], 'admin');
    }

    // Chi tiết 1 đánh giá
    public function show($id) {
        $review = $this->reviewModel->getByIdWithDetails($id);
        if (!$review) {
            $this->show404("Không tìm thấy đánh giá");
            return;
        }
        $this->view('reviews/show', ['review' => $review], 'admin');
    }

    // Duyệt đánh giá
    public function approve($id) {
        $this->reviewModel->updateStatus($id, 'approved');
        $_SESSION['success'] = 'Đã duyệt đánh giá';
        Helper::redirect('admin/review');
    }

    // Từ chối đánh giá
    public function rejected($id) {
        $this->reviewModel->updateStatus($id, 'rejected');
        $_SESSION['success'] = 'Đánh giá đã bị từ chối';
        Helper::redirect('admin/review');
    }

    public function rejectedView()
    {
        $reviews = $this->reviewModel->getRejected();
        $this->view('reviews/rejected', ['reviews' => $reviews], 'admin');
    }

    // Xoá đánh giá
    public function delete($id) {
        $this->reviewModel->delete($id);
        $_SESSION['success'] = 'Đã xóa đánh giá';
        Helper::redirect('admin/review');
    }
}
