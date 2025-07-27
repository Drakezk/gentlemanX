<?php
class UserController extends Controller {
    private $userModel;

    public function __construct() {
        parent::__construct(); // nếu Controller cha có constructor
        $this->userModel = $this->model('User');

        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Bạn cần đăng nhập để thực hiện thao tác này';
            Helper::redirect('auth/showLogin');
        }
    }

    public function edit() {
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->find($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = trim($_POST['name']);
            $email    = trim($_POST['email']);
            $password = trim($_POST['password']);

            $data = [
                'name'  => $name,
                'email' => $email,
            ];

            // Nếu có đổi mật khẩu
            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            // Thực hiện update
            $this->userModel->update($userId, $data);

            $_SESSION['success'] = 'Cập nhật thông tin thành công!';
            Helper::redirect('auth/account');
        }

        // Truyền dữ liệu ra view
        $this->view('users/edit', [
            'user' => $user
        ]);
    }
}
