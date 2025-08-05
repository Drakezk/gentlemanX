<?php
/**
 * Home Controller - Controller cho trang chủ Client
 * Xử lý các request liên quan đến trang chủ
 */

class HomeController extends Controller {
    private $productModel;
    private $categoryModel;
    
    public function __construct() {
        parent::__construct();
        $this->productModel = $this->model('Product');
        $this->categoryModel = $this->model('Category');
    }
    
    /**
     * Trang chủ
     */
    public function index() {
        // Lấy sản phẩm nổi bật
        $featuredProducts = $this->productModel->getFeatured(8);
        
        // Lấy sản phẩm mới nhất
        $latestProducts = $this->productModel->getLatest(8);
        
        // Lấy danh mục
        $categories = $this->categoryModel->getParentCategories();
        
        $data = [
            'title' => 'Trang chủ',
            'featuredProducts' => $featuredProducts,
            'latestProducts' => $latestProducts,
            'categories' => $categories
        ];
        
        $this->view('home/index', $data, 'client');
    }

    public function shop() {
        $this->view('home/shop', [], 'client');
    }

    /**
     * Danh sach sản phẩm
     */
    public function productList() {
        // Lấy dữ liệu GET
        $categorySlug = isset($_GET['category']) ? $_GET['category'] : null;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
        $priceRange   = isset($_GET['price_range']) ? $_GET['price_range'] : null;
        
        // Lấy category_id từ slug (nếu có slug)
        $categoryId = null;
        if ($categorySlug) {
            $category = $this->categoryModel->getBySlug($categorySlug);
            if ($category) {
                $categoryId = $category['id'];
            }
        }

        // Xử lý sắp xếp
        $orderBy = 'p.created_at DESC'; // mặc định
        if ($sort == 'price_asc') {
            $orderBy = 'p.price ASC';
        } elseif ($sort == 'price_desc') {
            $orderBy = 'p.price DESC';
        } elseif ($sort == 'newest') {
            $orderBy = 'p.created_at DESC';
        }

        // Tạo mảng filters
        $filters = [];
        if ($categoryId) {
            $filters['category_id'] = $categoryId;
        }

        // Lọc theo khoảng giá
        if ($priceRange) {
            switch ($priceRange) {
                case 'under_500':
                    $filters['price_max'] = 500000;
                    break;
                case '500_1000':
                    $filters['price_min'] = 500000;
                    $filters['price_max'] = 1000000;
                    break;
                case '1000_2000':
                    $filters['price_min'] = 1000000;
                    $filters['price_max'] = 2000000;
                    break;
                case 'above_2000':
                    $filters['price_min'] = 2000000;
                    break;
            }
        }

        // Gọi model lấy danh sách sản phẩm
        $products = $this->productModel->getFiltered($filters, $orderBy);

        // Lấy danh mục cho menu
        $categories = $this->categoryModel->getParentCategories();

        $data = [
            'title' => 'Danh sách sản phẩm',
            'products' => $products,
            'categories' => $categories,
            'selectedCategorySlug' => $categorySlug,
            'selectedSort' => $sort,
            'selectedPriceRange' => $priceRange
        ];

        $this->view('home/productList', $data, 'client');
    }
    
    /**
     * Xử lý form liên hệ
     */
    private function handleContactForm() {
        $rules = [
            'name' => 'required|min:2',
            'email' => 'required|email',
            'subject' => 'required|min:5',
            'message' => 'required|min:10'
        ];
        
        $data = $this->post();
        $errors = $this->validate($data, $rules);
        
        if (empty($errors)) {
            // Lưu tin nhắn liên hệ vào database
            $contactModel = $this->model('ContactMessage');
            $contactId = $contactModel->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? '',
                'subject' => $data['subject'],
                'message' => $data['message']
            ]);
            
            if ($contactId) {
                $this->redirectWithMessage('contact', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.', 'success');
            } else {
                $this->redirectWithMessage('contact', 'Có lỗi xảy ra. Vui lòng thử lại!', 'error');
            }
        } else {
            Session::setOldInput($data);
            Session::setFlash('errors', $errors);
            $this->redirect('contact');
        }
    }
}
?>
