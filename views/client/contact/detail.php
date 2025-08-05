<?php include 'views/client/layouts/header.php'; ?>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container my-5">
  <div class="card shadow-sm border-0">
    <div class="card-body p-4">
      <h3 class="card-title mb-4">
        <i class="bi bi-envelope-paper-fill me-2 text-primary"></i>
        Chi tiết liên hệ
      </h3>

      <div class="mb-4">
        <h5 class="mb-2"><strong><i class="bi bi-pin-angle-fill me-2 text-danger"></i>Chủ đề:</strong></h5>
        <p class="ps-3"><?= htmlspecialchars($message['subject']) ?></p>
      </div>

      <div class="mb-4">
        <h5 class="mb-2"><strong><i class="bi bi-chat-left-text-fill me-2 text-info"></i>Nội dung bạn gửi:</strong></h5>
        <div class="ps-3 border-start border-3 border-info">
          <p class="mb-0"><?= nl2br(htmlspecialchars($message['message'])) ?></p>
        </div>
      </div>

      <div class="mb-4">
        <h5 class="mb-2"><strong><i class="bi bi-reply-fill me-2 text-success"></i>Phản hồi từ GentlemanX:</strong></h5>
        <?php if (!empty($message['admin_reply'])): ?>
          <div class="ps-3 border-start border-3 border-success bg-light p-3 rounded">
            <p class="mb-0 text-success"><?= nl2br(htmlspecialchars($message['admin_reply'])) ?></p>
          </div>
        <?php else: ?>
          <div class="alert alert-secondary ps-3">
            <i class="bi bi-hourglass-split me-2"></i>Chưa có phản hồi từ quản trị viên.
          </div>
        <?php endif; ?>
      </div>

      <div class="text-end">
        <a href="<?= BASE_URL ?>contact" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
        </a>
      </div>
    </div>
  </div>
</div>

<?php include 'views/client/layouts/footer.php'; ?>
