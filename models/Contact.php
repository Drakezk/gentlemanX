<?php
class Contact extends Model {
    protected $timestamps = false;
    protected $table = 'contact_messages';

    protected $fillable = [
        'name', 'email', 'subject', 'message', 'user_id',
        'status', 'admin_reply', 'replied_at', 'replied_by'
    ];

    // Lấy tất cả tin nhắn (không điều kiện)
    public function getAllMessages() {
        return $this->getAll([], 'created_at DESC');
    }

    // Lấy 1 tin nhắn theo ID
    public function getMessageById($id) {
        return $this->getById($id);
    }

    // Lấy tất cả tin nhắn theo user_id
    public function getMessagesByUserId($userId) {
        return $this->getAll(['user_id' => $userId], 'created_at DESC');
    }

    // Tạo tin nhắn mới
    public function createMessage($data) {
        return $this->create($data);
    }

    // Phản hồi tin nhắn từ admin
    public function replyMessage($id, $reply, $adminId) {
        $data = [
            'status' => 'replied',
            'admin_reply' => $reply,
            'replied_at' => date('Y-m-d H:i:s'),
            'replied_by' => $adminId
        ];
        return $this->update($id, $data);
    }
}
