<?php include_once 'views/admin/layouts/header.php'; ?>

<h4>Chi tiết liên hệ</h4>
<p><strong>Tên:</strong> <?= $message['name'] ?></p>
<p><strong>Email:</strong> <?= $message['email'] ?></p>
<p><strong>Chủ đề:</strong> <?= $message['subject'] ?></p>
<p><strong>Nội dung:</strong><br><?= nl2br($message['message']) ?></p>

<?php if ($message['status'] !== 'replied'): ?>
<form method="POST">
    <textarea name="admin_reply" rows="5" class="form-control mb-3" placeholder="Nội dung phản hồi"></textarea>
    <button type="submit" class="btn btn-success">Gửi phản hồi</button>
</form>
<?php else: ?>
<p><strong>Phản hồi từ admin:</strong><br><?= nl2br($message['admin_reply']) ?></p>
<p><strong>Thời gian:</strong> <?= $message['replied_at'] ?></p>
<?php endif; ?>

<?php include_once 'views/admin/layouts/footer.php'; ?>