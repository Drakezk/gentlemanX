<?php

class ProfileController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function index(){
        $admin = $this->userModel->find($_SESSION['user']['id']);
        $this->view('dashboard/profile', ['admin' => $admin], 'admin');
    }

    public function update(){
        // Lấy ID admin đang đăng nhập
        $adminId = $_SESSION['user']['id'] ?? null;

        if (!$adminId || $_SESSION['user']['role'] !== 'admin') {
            Helper::redirect('auth/login');
        }

        // Lấy dữ liệu người dùng hiện tại
        $admin = $this->userModel->find($adminId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = trim($_POST['name']);
            $phone    = trim($_POST['phone']);
            $email    = trim($_POST['email']);
            $password = trim($_POST['password'] ?? '');
            $confirm  = trim($_POST['password_confirmation'] ?? '');

            $data = [
                'name'  => $name,
                'email' => $email,
                'phone' => $phone,
            ];

            // Nếu có thay đổi mật khẩu
            if (!empty($password)) {
                if ($password !== $confirm) {
                    $_SESSION['error'] = 'Mật khẩu xác nhận không khớp.';
                    Helper::redirect('admin/profile/update');
                }
                $data['password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            // Kiểm tra email đã tồn tại chưa (trừ chính mình)
            if ($this->userModel->emailExists($email, $adminId)) {
                $_SESSION['error'] = 'Email đã tồn tại!';
                Helper::redirect('admin/profile/update');
            }

            // Cập nhật dữ liệu
            $this->userModel->update($adminId, $data);

            // Cập nhật session
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['email'] = $email;

            $_SESSION['success'] = 'Cập nhật thông tin thành công!';
            Helper::redirect('admin/profile/index');
        }

        $this->view('dashboard/profileUpdate', [
            'admin' => $admin
        ], 'admin');
    }
}
