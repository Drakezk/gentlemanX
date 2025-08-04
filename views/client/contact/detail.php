<?php include 'views/client/layouts/header.php'; ?>
<div class="container mt-5">
  <h4><strong>Chủ đề:</strong> <?= $message['subject'] ?></h4>
  <p><strong>Nội dung:</strong><br><?= nl2br($message['message']) ?></p>
  <p><strong>Phản hồi:</strong><br><?= $message['admin_reply'] ? nl2br($message['admin_reply']) : 'Chưa có phản hồi' ?></p>
</div>
<?php include 'views/client/layouts/footer.php'; ?>
