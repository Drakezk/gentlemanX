<?php
class ProductController extends Controller {
    private $productModel;

    public function __construct() {
        parent::__construct();
        $this->productModel = $this->model('Product');
    }

    public function index() {
        $productModel = new Product();

        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $status  = isset($_GET['status']) ? trim($_GET['status']) : '';

        if ($keyword !== '' || $status !== '') {
            $products = $productModel->searchProducts($keyword, $status);
        } else {
            $products = $productModel->getAll();
        }

        $this->view('product/index', [
            'products' => $products,
            'keyword'  => $keyword,
            'status'   => $status
        ], 'admin');
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Kiểm tra trùng SKU
            $existingProduct = $this->productModel->getBySku($_POST['sku']);
            if ($existingProduct) {
                $_SESSION['error'] = 'SKU đã tồn tại. Vui lòng chọn mã SKU khác.';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            // Tạo thư mục con nếu chưa có
            $subFolder = 'products/'; // thư mục con trong assets/uploads/
            if (!is_dir(UPLOAD_PATH . $subFolder)) {
                mkdir(UPLOAD_PATH . $subFolder, 0777, true);
            }

            // Xử lý upload ảnh đại diện
            $featuredImage = null;
            if (!empty($_FILES['featured_image']['name'])) {
                $fileName = time() . '_' . basename($_FILES['featured_image']['name']);
                $targetPath = UPLOAD_PATH . $subFolder . $fileName; // => assets/uploads/products/xxx.jpg

                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $targetPath)) {
                    // Lưu đường dẫn tương đối vào DB
                    $featuredImage = $subFolder . $fileName;
                }
            }

            // Xử lý upload gallery
            $galleryFiles = [];
            if (!empty($_FILES['gallery']['name'][0])) {
                foreach ($_FILES['gallery']['name'] as $key => $name) {
                    if ($_FILES['gallery']['error'][$key] == UPLOAD_ERR_OK) {
                        $fileName = time() . '_' . basename($name);
                        $targetPath = UPLOAD_PATH . $subFolder . $fileName;

                        if (move_uploaded_file($_FILES['gallery']['tmp_name'][$key], $targetPath)) {
                            $galleryFiles[] = $subFolder . $fileName;
                        }
                    }
                }
            }
  
            // --- Dữ liệu sản phẩm ---
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
                'featured_image' => $featuredImage,
                'gallery' => json_encode($galleryFiles),
                'status' => $_POST['status'],
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0
            ];
            
            $this->productModel->create($data);
            Helper::redirect('admin/product/index');
        }
        $this->view('product/create', [], 'admin');
    }

    public function edit($id) {
        // Lấy sản phẩm hiện tại
        $product = $this->productModel->getById($id);
        if (!$product) {
            die('Sản phẩm không tồn tại!');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subFolder = 'products/';

            // Giữ lại ảnh cũ nếu không chọn ảnh mới
            $featuredImage = $product['featured_image'];
            $galleryFiles = json_decode($product['gallery'] ?? '[]', true);

            // Xử lý ảnh đại diện
            if (!empty($_FILES['featured_image']['name'])) {
                $fileName = time() . '_' . basename($_FILES['featured_image']['name']);
                $targetPath = UPLOAD_PATH . $subFolder . $fileName;
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $targetPath)) {
                    $featuredImage = $subFolder . $fileName;

                    // Nếu muốn xóa file cũ:
                    if (!empty($product['featured_image']) && file_exists(UPLOAD_PATH . $product['featured_image'])) {
                        unlink(UPLOAD_PATH . $product['featured_image']);
                    }
                }
            }

            // Xử lý gallery
            if (!empty($_FILES['gallery']['name'][0])) {
                $newGallery = [];
                foreach ($_FILES['gallery']['name'] as $key => $name) {
                    if ($_FILES['gallery']['error'][$key] == UPLOAD_ERR_OK) {
                        $fileName = time() . '_' . basename($name);
                        $targetPath = UPLOAD_PATH . $subFolder . $fileName;
                        if (move_uploaded_file($_FILES['gallery']['tmp_name'][$key], $targetPath)) {
                            $newGallery[] = $subFolder . $fileName;
                        }
                    }
                }

                // Ghi đè gallery cũ (nếu muốn gộp thì merge)
                if (!empty($newGallery)) {
                    // (tùy chọn) Xóa gallery cũ
                    if (!empty($galleryFiles)) {
                        foreach ($galleryFiles as $old) {
                            if (!empty($old) && file_exists(UPLOAD_PATH . $old)) {
                                unlink(UPLOAD_PATH . $old);
                            }
                        }
                    }
                    $galleryFiles = $newGallery;
                }
            }

            // Gom dữ liệu đầy đủ
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
                'featured_image' => $featuredImage,
                'gallery' => json_encode($galleryFiles),
                'status' => $_POST['status'],
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0
            ];

            // Cập nhật vào database
            $this->productModel->update($id, $data);

            // Quay lại danh sách
            Helper::redirect('admin/product/index');
        }
        $this->view('product/edit', ['product' => $product], 'admin');
    }

    public function delete($id) {
        $this->productModel->deleteProduct($id);
        Helper::redirect('admin/product/index');
    }
}
