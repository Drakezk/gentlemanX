<?php
class ContactController extends Controller {
    private $contactModel;

    public function __construct() {
        $this->contactModel = $this->model('Contact');
    }

    // Trang liên hệ
    public function index() {
        $messages = [];
        if (!empty($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $messages = $this->contactModel->getMessagesByUserId($userId);
        }
        $this->view('contact/index', ['messages' => $messages], 'client');
    }

    // Gửi liên hệ
    public function send() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';
            $user_id = $_SESSION['user']['id'] ?? null;

            if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin.';
                return Helper::redirect('contact/index');
            }

            $data = [
                'user_id' => $user_id,
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Lưu vào CSDL
            $this->contactModel->createMessage($data);
            $_SESSION['success'] = "Liên hệ của bạn đã được gửi thành công!";
            return Helper::redirect('contact/index');
        }

        // Nếu không phải POST
        return Helper::redirect('contact/index');
    }

    public function list() {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) return Helper::redirect('auth/showLogin');

        $messages = $this->contactModel->getMessagesByUserId($userId);
        $this->view('contact/index', ['messages' => $messages], 'client');
    }

    public function detail($id) {
        $message = $this->contactModel->getMessageById($id);
        if (!$message || $message['user_id'] != ($_SESSION['user']['id'] ?? null)) {
            $_SESSION['error'] = 'Bạn không có quyền truy cập.';
            return Helper::redirect('contact/list');
        }
        $this->view('contact/detail', ['message' => $message], 'client');
    }
}
