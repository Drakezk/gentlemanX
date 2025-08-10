<?php
class CategoryController extends Controller {
    private $categoryModel;

    public function __construct() {
        parent::__construct();
        $this->categoryModel = $this->model('Category');
    }

    public function index() {
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $status  = isset($_GET['status']) ? trim($_GET['status']) : '';

        if ($keyword !== '' || $status !== '') {
            $categories = $this->categoryModel->searchCategory($keyword, $status);
        } else {
            $categories = $this->categoryModel->getAll([], 'sort_order ASC');
        }

        // Chuẩn bị danh sách tên danh mục cha
        $parentNames = [];
        foreach ($categories as $cat) {
            $parentNames[$cat['id']] = $cat['name'];
        }

        $this->view('categories/index', [
            'categories'  => $categories,
            'parentNames' => $parentNames,
            'keyword'     => $keyword,
            'status'      => $status
        ], 'admin');
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'parent_id'   => $_POST['parent_id'] ?: null,
                'name'        => $_POST['name'],
                'slug'        => $_POST['slug'],
                'description' => $_POST['description'],
                'sort_order'  => $_POST['sort_order'],
                'status'      => $_POST['status'],
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ];
            $this->categoryModel->create($data);
            Helper::redirect('admin/category/index');
        }
        // Lấy danh mục cha cho dropdown (chỉ hiển thị danh mục không có cha)
        $parentCategories = $this->categoryModel->getParentCategories();
        $this->view('categories/create', ['parentCategories' => $parentCategories], 'admin');
    }

    public function edit($id) {
        $category = $this->categoryModel->getById($id);
        if (!$category) {
            die('Không tìm thấy danh mục');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'parent_id'   => $_POST['parent_id'] ?: null,
                'name'        => $_POST['name'],
                'slug'        => $_POST['slug'],
                'description' => $_POST['description'],
                'sort_order'  => $_POST['sort_order'],
                'status'      => $_POST['status'],
                'updated_at'  => date('Y-m-d H:i:s')
            ];
            $this->categoryModel->update($id, $data);
            Helper::redirect('admin/category/index');
        }
        // Lấy danh mục cha để chọn (trừ chính nó ra để tránh lặp đệ quy)
        $parentCategories = array_filter(
            $this->categoryModel->getParentCategories(),
            fn($cat) => $cat['id'] != $id
        );
        $this->view('categories/edit', [
            'category' => $category,
            'parentCategories' => $parentCategories
        ], 'admin');
    }

    public function delete($id) {
        $this->categoryModel->delete($id);
        Helper::redirect('admin/category/index');
    }
}
