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
            $phone    = trim($_POST['phone']);
            $email    = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm  = trim($_POST['password_confirmation'] ?? '');

            $data = [
                'name'  => $name,
                'email' => $email,
                'phone' => $phone,
            ];

            // Nếu có nhập mật khẩu mới → phải xác nhận đúng
            if (!empty($password)) {
                if ($password !== $confirm) {
                    $_SESSION['error'] = 'Mật khẩu xác nhận không khớp.';
                    Helper::redirect('user/edit');
                }
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
