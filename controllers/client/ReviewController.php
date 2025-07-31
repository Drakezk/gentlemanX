<?php
class ReviewController extends Controller {
    private $reviewModel;
    private $productModel;

    public function __construct() {
        parent::__construct();
        $this->reviewModel = $this->model('Review');
        $this->productModel = $this->model('Product');
    }

    public function submit($slug = '') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy sản phẩm theo slug
            $product = $this->productModel->getBySlug($slug);
            if (!$product || $product['status'] !== 'active') {
                $this->show404('Sản phẩm không tồn tại');
                return;
            }

            $userId = $_SESSION['user']['id'];
            $productId = $product['id'];
            $rating = $_POST['rating'] ?? 5;
            $title = trim($_POST['title'] ?? '');
            $comment = trim($_POST['comment'] ?? '');

            if (!$comment) {
                $_SESSION['error'] = 'Vui lòng nhập nội dung đánh giá.';
                Helper::redirect('product/' . $slug);
                return;
            }

            // Upload ảnh
            $imagePaths = [];
            if (!empty($_FILES['images']['name'][0])) {
                $targetDir = 'assets/uploads/review/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                foreach ($_FILES['images']['name'] as $key => $name) {
                    $tmpName = $_FILES['images']['tmp_name'][$key];
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $fileName = uniqid('review_') . '.' . $ext;
                    $targetFile = $targetDir . $fileName;

                    if (move_uploaded_file($tmpName, $targetFile)) {
                        $imagePaths[] = 'review/' . $fileName;
                    } else {
                        error_log("Upload thất bại: $tmpName -> $targetFile");
                    }
                }
            }

            $data = [
                'user_id' => $userId,
                'product_id' => $productId,
                'rating' => $rating,
                'title' => $title,
                'comment' => $comment,
                'images' => json_encode($imagePaths, JSON_UNESCAPED_SLASHES),
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->reviewModel->create($data);

            $_SESSION['success'] = 'Cảm ơn bạn đã đánh giá sản phẩm!';
            Helper::redirect('product/' . $slug);
        }
    }

}
