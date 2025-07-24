<?php
class CategoryController extends Controller {
    private $categoryModel;

    public function __construct() {
        parent::__construct();
        $this->categoryModel = $this->model('Category');
    }

    public function index() {
        $categories = $this->categoryModel->getAll();
        $this->view('categories/index', ['categories' => $categories], 'admin');
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
        $this->view('categories/create', [], 'admin');
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
        $this->view('categories/edit', ['category' => $category], 'admin');
    }

    public function delete($id) {
        $this->categoryModel->delete($id);
        Helper::redirect('admin/category/index');
    }
}
