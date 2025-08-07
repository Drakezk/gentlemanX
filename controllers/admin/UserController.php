<?php
class UserController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    // Trang danh sách Khách hàng
    public function customers() {
        $users = $this->userModel->getAll(['role' => 'customer']);
        $data = [
            'title' => 'Danh sách Khách hàng',
            'users' => $users
        ];
        $this->view('users/customers', $data, 'admin');
    }

    // Thêm người dùng
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lọc dữ liệu cần thiết
            $data = [
                'name'   => trim($_POST['name']),
                'email'  => trim($_POST['email']),
                'phone'  => trim($_POST['phone']),
                'role'   => $_POST['role'],
                'status' => $_POST['status']
            ];

            // Nếu có password thì hash
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
            }

            $this->userModel->createUser($data);
            Helper::redirect('admin/user/customers');
        }

        $this->view('users/create', ['title' => 'Thêm người dùng'], 'admin');
    }

    // Sửa người dùng
    public function edit($id) {
        // Lấy user hiện tại
        $user = $this->userModel->getUser($id);
        if (!$user) {
            Helper::redirect('admin/user/index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'   => trim($_POST['name']),
                'email'  => trim($_POST['email']),
                'phone'  => trim($_POST['phone']),
                'role'   => $_POST['role'],
                'status' => $_POST['status']
            ];

            // Nếu nhập password mới thì hash lại
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
            }

            $this->userModel->updateUser($id, $data);
            Helper::redirect('admin/user/customers');
        }

        $this->view('users/edit', [
            'title' => 'Sửa người dùng',
            'user'  => $user
        ], 'admin');
    }

    // Xóa người dùng
    public function delete($id) {
        $this->userModel->deleteUser($id);
        Helper::redirect('admin/user/customers');
    }

}
