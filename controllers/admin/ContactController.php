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
        $this->view('contact/detail', ['message' => $message], 'admin');
    }

    // Gửi phản hồi từ admin
    public function reply($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reply = trim($_POST['admin_reply'] ?? '');
            $adminId = $_SESSION['user']['id'] ?? null;

            if (empty($reply)) {
                $_SESSION['error'] = "Vui lòng nhập nội dung phản hồi.";
                Helper::redirect("admin/contact/detail/$id");
            }

            $message = $this->contactModel->getMessageById($id);
            if (!$message) {
                $_SESSION['error'] = "Liên hệ không tồn tại.";
                Helper::redirect("admin/contact/index");
            }

            // Gọi model để cập nhật phản hồi
            $this->contactModel->update($id, [
                'admin_reply' => $reply,
                'status' => 'replied',
                'replied_at' => date('Y-m-d H:i:s'),
                'admin_id' => $adminId
            ]);

            // Gửi mail nếu là khách
            if (empty($message['user_id'])) {
                Helper::sendMail($message['email'], 'Phản hồi từ GentlemanX', $reply);
            }

            $_SESSION['success'] = "Đã phản hồi thành công.";
            Helper::redirect("admin/contact/detail/$id");
        }
    }
}
