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

    /**
     * Danh sach sản phẩm
     */
    public function productList() {
    // Lấy dữ liệu GET
    $categorySlug = isset($_GET['category']) ? $_GET['category'] : null;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : null;

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

    // Gọi model lấy dữ liệu
    if ($categoryId) {
        $products = $this->productModel->getFiltered(['category_id' => $categoryId], $orderBy);
    } else {
        $products = $this->productModel->getFiltered([], $orderBy);
    }

    // Lấy danh mục cho menu
    $categories = $this->categoryModel->getParentCategories();

    $data = [
        'title' => 'Danh sách sản phẩm',
        'products' => $products,
        'categories' => $categories,
        'selectedCategorySlug' => $categorySlug,
        'selectedSort' => $sort
    ];

    $this->view('home/productList', $data, 'client');
}


    
    /**
     * Trang giới thiệu
     */
    public function about() {
        $data = [
            'title' => 'Giới thiệu',
            'content' => 'Đây là trang giới thiệu về chúng tôi.'
        ];
        
        $this->view('home/about', $data, 'client');
    }
    
    /**
     * Trang liên hệ
     */
    public function contact() {
        if ($this->isMethod('POST')) {
            return $this->handleContactForm();
        }
        
        $data = [
            'title' => 'Liên hệ'
        ];
        
        $this->view('home/contact', $data, 'client');
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
