<?php
class ProductController extends Controller {
    private $productModel;

    public function __construct() {
        parent::__construct();
        $this->productModel = $this->model('Product');
    }

    // Danh sách sản phẩm
    public function index() {
        $products = $this->productModel->getAll(); // bạn viết hàm getAll trong model
        $this->view('product/index', ['products' => $products], 'admin');
    }

    // Form thêm sản phẩm
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => $_POST['category_id'],
                'brand_id' => $_POST['brand_id'],
                'name' => $_POST['name'],
                'slug' => $_POST['slug'],
                'sku' => $_POST['sku'],
                'short_description' => $_POST['short_description'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'compare_price' => $_POST['compare_price'],
                'stock_quantity' => $_POST['stock_quantity'],
                'featured_image' => $_POST['featured_image'],
                'status' => $_POST['status'],
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0
            ];
            $this->productModel->create($data);
            Helper::redirect('admin/product/index');
        }
        $this->view('product/create', [], 'admin');
    }

    // Xóa sản phẩm
    public function delete($id) {
        $this->productModel->delete($id);
        Helper::redirect('admin/product/index');
    }

    // Sửa sản phẩm
    public function edit($id) {
        $product = $this->productModel->getById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => $_POST['category_id'],
                'brand_id' => $_POST['brand_id'],
                'name' => $_POST['name'],
                'slug' => $_POST['slug'],
                'sku' => $_POST['sku'],
                'short_description' => $_POST['short_description'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'compare_price' => $_POST['compare_price'],
                'stock_quantity' => $_POST['stock_quantity'],
                'featured_image' => $_POST['featured_image'],
                'status' => $_POST['status'],
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0
            ];
            $this->productModel->update($id, $data);
            Helper::redirect('admin/product/index');
        }
        $this->view('product/edit', ['product' => $product], 'admin');
    }
}
