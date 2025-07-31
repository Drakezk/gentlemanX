<?php
/**
 * Product Controller - Controller cho sản phẩm Client
 * Xử lý các request liên quan đến sản phẩm
 */

class ProductController extends Controller {
    private $productModel;
    private $categoryModel;
    private $reviewModel;
    
    public function __construct() {
        parent::__construct();
        $this->productModel = $this->model('Product');
        $this->categoryModel = $this->model('Category');
        $this->reviewModel = $this->model('Review');
    }
    
    /**
     * Danh sách sản phẩm
     */
    public function index() {
        $page = (int)$this->get('page', 1);
        $filters = [
            'category_id' => $this->get('category'),
            'brand_id' => $this->get('brand'),
            'min_price' => $this->get('min_price'),
            'max_price' => $this->get('max_price'),
            'sort' => $this->get('sort', 'created_at DESC')
        ];
        
        // Lọc bỏ giá trị rỗng
        $filters = array_filter($filters);
        
        $products = $this->productModel->getAll(
            ['status' => 'active'],
            $filters['sort'] ?? 'created_at DESC',
            PRODUCTS_PER_PAGE,
            ($page - 1) * PRODUCTS_PER_PAGE
        );
        
        $total = $this->productModel->count(['status' => 'active']);
        
        $pagination = [
            'current_page' => $page,
            'per_page' => PRODUCTS_PER_PAGE,
            'total' => $total,
            'last_page' => ceil($total / PRODUCTS_PER_PAGE)
        ];
        
        $data = [
            'title' => 'Sản phẩm',
            'products' => $products,
            'pagination' => $pagination,
            'filters' => $filters
        ];
        
        $this->view('product/index', $data, 'client');
    }
    
    /**
     * Chi tiết sản phẩm
     * @param string $slug
     */
    public function detail($slug) {
        $product = $this->productModel->getBySlug($slug);
        
        if (!$product || $product['status'] !== 'active') {
            $this->show404('Sản phẩm không tồn tại');
        }
        
        // Tăng lượt xem
        $this->productModel->incrementViewCount($product['id']);
        
        // Lấy sản phẩm liên quan
        $relatedProducts = $this->productModel->getRelated($product['id'], 4);
        
        // Lấy breadcrumb
        $breadcrumb = $this->categoryModel->getBreadcrumb($product['category_id']);
        
        $reviews = $this->reviewModel->getByProductId($product['id']);
        $reviewStats = $this->reviewModel->getStatsByProductId($product['id']);

        $data = [
            'title' => $product['name'],
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'breadcrumb' => $breadcrumb,
            'reviews' => $reviews,
            'reviewStats' => $reviewStats
        ];
        
        $this->view('home/detail', $data, 'client');
    }
    
    /**
     * Tìm kiếm sản phẩm
     */
    public function search() {
        $keyword = $this->get('q', '');
        $page = (int)$this->get('page', 1);
        
        if (empty($keyword)) {
            $this->redirect('product');
        }
        
        $filters = [
            'category_id' => $this->get('category'),
            'brand_id' => $this->get('brand')
        ];
        
        $filters = array_filter($filters);
        
        $result = $this->productModel->search($keyword, $page, PRODUCTS_PER_PAGE, $filters);
        
        $data = [
            'title' => 'Tìm kiếm: ' . $keyword,
            'keyword' => $keyword,
            'products' => $result['data'],
            'pagination' => $result,
            'filters' => $filters
        ];
        
        $this->view('home/search', $data, 'client');
    }
}
?>
