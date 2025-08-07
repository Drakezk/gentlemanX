<?php
class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = $this->model('User');
    }

    /**
     * Hiển thị form login
     */
    public function showLogin() {
        $this->view('auth/login');
    }

    /**
     * Xử lý login
     */
    public function login() {
    // Chỉ xử lý khi gửi form POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        Helper::redirect('auth/showLogin');
    }

    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Kiểm tra rỗng
    if ($email === '' || $password === '') {
        $_SESSION['error'] = 'Vui lòng nhập đầy đủ email và mật khẩu!';
        Helper::redirect('auth/showLogin');
    }

    // Lấy user từ DB
    $user = $this->userModel->getByEmail($email);
    if (!$user) {
        $_SESSION['error'] = 'Email không tồn tại!';
        Helper::redirect('auth/showLogin');
    }

    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = 'Mật khẩu không đúng!';
        Helper::redirect('auth/showLogin');
    }

    if ($user['status'] !== 'active') {
        $_SESSION['error'] = 'Tài khoản chưa được kích hoạt!';
        Helper::redirect('auth/showLogin');
    }

    // Lưu session sau khi đăng nhập thành công
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user'] = [               
        'id'    => $user['id'],
        'name'  => $user['name'],
        'email' => $user['email'],
        'role'  => $user['role']
    ];

    $this->userModel->update($user['id'], ['last_login_at' => date('Y-m-d H:i:s')]);
    $_SESSION['success'] = 'Đăng nhập thành công!';
    if ($user['role'] === 'admin') {
        Helper::redirect('admin/dashboard');
    } else {
        Helper::redirect('home/index');
    }
}


    /**
     * Hiển thị form register
     */
    public function showRegister() {
        $this->view('auth/register');
    }

    /**
     * Xử lý register
     */
    public function register() {
    // Chỉ xử lý khi gửi form POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        Helper::redirect('auth/showRegister');
    }

    $name     = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email    = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $confirm  = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

    // Kiểm tra dữ liệu rỗng
    if ($name === '' || $email === '' || $password === '' || $confirm === '') {
        $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
        Helper::redirect('auth/showRegister');
    }

    if ($password !== $confirm) {
        $_SESSION['error'] = 'Mật khẩu xác nhận không khớp!';
        Helper::redirect('auth/showRegister');
    }

    if ($this->userModel->emailExists($email)) {
        $_SESSION['error'] = 'Email đã tồn tại!';
        Helper::redirect('auth/showRegister');
    }

    $hashed = password_hash($password, HASH_ALGO);

    $data = [
        'name'       => $name,
        'email'      => $email,
        'password'   => $hashed,
        'role'       => 'customer',
        'status'     => 'active',
        'created_at' => date('Y-m-d H:i:s')
    ];

    // Gọi create
    $this->userModel->create($data);

    $_SESSION['success'] = 'Đăng ký thành công! Mời bạn đăng nhập.';
    Helper::redirect('auth/showLogin');
}


    /**
     * Đăng xuất
     */
    public function logout()
{
    // Xóa thông tin user khỏi session
    unset($_SESSION['user']);
    session_destroy(); // huỷ toàn bộ session nếu muốn

    // Chuyển hướng về trang login hoặc trang chủ
    Helper::redirect('auth/showLogin');
}

public function account() {
    // Kiểm tra đăng nhập
    if (!isset($_SESSION['user'])) {
        $_SESSION['error'] = 'Vui lòng đăng nhập!';
        Helper::redirect('auth/showLogin');
    }

    // Lấy user ID từ session
    $userId = $_SESSION['user']['id'];

    // Lấy thông tin user từ DB
    $user = $this->model('User')->getById($userId);

    // Lấy danh sách đơn hàng của user
    $orderModel = $this->model('Order');
    $orders = $orderModel->getByUserId($userId);

    // Truyền sang view
    $this->view('users/account', [
        'title' => 'Thông tin tài khoản',
        'user' => $user,
        'orders' => $orders
    ], 'client');
}

}
