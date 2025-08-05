<?php include_once 'views/admin/layouts/header.php'; ?>

<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-gradient-primary rounded-top-4">
      <h4 class="mb-0 fw-bold"><i class="fas fa-envelope-open-text me-2"></i>Chi tiết liên hệ</h4>
    </div>
    <div class="card-body">

      <!-- Thông báo -->
      <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
          <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
          <i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <!-- Thông tin liên hệ -->
      <div class="mb-4">
        <p><strong><i class="fas fa-user me-2 text-primary"></i>Tên:</strong> <?= htmlspecialchars($message['name']) ?></p>
        <p><strong><i class="fas fa-envelope me-2 text-primary"></i>Email:</strong> <?= htmlspecialchars($message['email']) ?></p>
        <p><strong><i class="fas fa-tag me-2 text-primary"></i>Chủ đề:</strong> <?= htmlspecialchars($message['subject']) ?></p>
        <p><strong><i class="fas fa-comment-dots me-2 text-primary"></i>Nội dung:</strong><br><?= nl2br(htmlspecialchars($message['message'])) ?></p>
      </div>

      <!-- Phản hồi -->
      <?php if ($message['status'] !== 'replied'): ?>
        <form action="<?= BASE_URL ?>/admin/contact/detail/<?= $message['id'] ?>" method="POST">
          <div class="mb-3">
            <label for="admin_reply" class="form-label fw-semibold">
              <i class="fas fa-reply me-2 text-success"></i>Phản hồi đến người gửi:
            </label>
            <textarea name="admin_reply" rows="5" class="form-control" placeholder="Nội dung phản hồi..." required></textarea>
          </div>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-paper-plane me-1"></i> Gửi phản hồi
          </button>
        </form>
      <?php else: ?>
        <div class="admin-reply-box mt-4">
          <h6 class="fw-bold mb-2"><i class="fas fa-reply me-2 text-success"></i>Phản hồi từ Admin:</h6>
          <p><?= nl2br(htmlspecialchars($message['admin_reply'])) ?></p>
          <small class="text-muted"><i class="fas fa-clock me-1"></i>Thời gian: <?= date('d/m/Y H:i', strtotime($message['replied_at'])) ?></small>
        </div>
      <?php endif; ?>

    </div>
  </div>
</div>

<style>
.card-header.bg-gradient-primary {
    background: linear-gradient(90deg, #0d6efd, #6610f2);
    color: white;
}

.form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
}

textarea.form-control {
    resize: vertical;
}

.btn-success:hover {
    background-color: #198754;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

.alert {
    margin-bottom: 1.5rem;
}

.admin-reply-box {
    background-color: #f8f9fa;
    border-left: 5px solid #0d6efd;
    padding: 1rem;
    border-radius: 0.5rem;
}
</style>

<?php include_once 'views/admin/layouts/footer.php'; ?>
