<?php 
class ContactController extends Controller {
    private $contactModel;

    public function __construct() {
        $this->contactModel = $this->model('Contact');
    }

    // Danh sách liên hệ
    public function index() {
        $messages = $this->contactModel->getAllMessages();
        $this->view('contact/index', ['messages' => $messages], 'admin');
    }

    // Chi tiết 1 liên hệ
    public function detail($id) {
        $message = $this->contactModel->getMessageById($id);

        if (!$message) {
            $_SESSION['error'] = "Tin nhắn không tồn tại.";
            Helper::redirect('admin/contact/index');
        }

        // Gửi phản hồi từ admin
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reply = trim($_POST['admin_reply'] ?? '');
            $adminId = $_SESSION['user']['id'] ?? null;

            if (empty($reply)) {
                $_SESSION['error'] = "Vui lòng nhập nội dung phản hồi.";
                Helper::redirect("admin/contact/detail/$id");
            }

            $this->contactModel->replyMessage($id, $reply, $adminId);

            $_SESSION['success'] = "Đã phản hồi thành công.";
            Helper::redirect("admin/contact/detail/$id");
        }
        $this->view('contact/detail', ['message' => $message], 'admin');
    }

}
