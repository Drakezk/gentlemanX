<?php include 'views/client/layouts/header.php'; ?>

<section class="contact-form-section py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold display-6">📬 Liên hệ với <span class="text-primary">GentlemanX</span></h2>
      <p class="text-muted">Nếu bạn có bất kỳ câu hỏi, góp ý hoặc cần hỗ trợ, hãy gửi tin nhắn cho chúng tôi. Chúng tôi luôn sẵn lòng lắng nghe.</p>
    </div>

    <form action="<?= BASE_URL ?>contact/send" method="POST" class="row g-4 mb-5 bg-white p-4 rounded shadow-sm">
      <div class="col-md-6">
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-user"></i></span>
          <input type="text" name="name" class="form-control" value="<?= $_SESSION['user']['name'] ?? '' ?>" <?= isset($_SESSION['user']) ? 'readonly' : '' ?> required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          <input type="email" name="email" class="form-control" value="<?= $_SESSION['user']['email'] ?? '' ?>" <?= isset($_SESSION['user']) ? 'readonly' : '' ?> required>
        </div>
      </div>
      <div class="col-12">
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-tag"></i></span>
          <input type="text" name="subject" class="form-control" placeholder="Chủ đề" required>
        </div>
      </div>
      <div class="col-12">
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-comment-dots"></i></span>
          <textarea name="message" rows="5" class="form-control" placeholder="Nội dung tin nhắn..." required></textarea>
        </div>
      </div>
      <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary btn-lg px-5">
          <i class="fas fa-paper-plane me-2"></i>Gửi liên hệ
        </button>
      </div>
    </form>

    <?php if (!empty($_SESSION['user']) && !empty($messages)): ?>
      <div class="history-section my-5">
        <h4 class="mb-4 text-center text-primary fw-bold">
          <i class="fas fa-history me-2"></i>Lịch sử liên hệ của bạn
        </h4>

        <!-- Desktop View -->
        <div class="table-responsive d-none d-md-block">
          <table class="table table-bordered table-hover shadow-sm align-middle">
            <thead class="table-light text-center">
              <tr class="text-uppercase text-secondary">
                <th>Chủ đề</th>
                <th>Ngày gửi</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($messages as $msg): ?>
                <tr>
                  <td class="text-start"><?= htmlspecialchars($msg['subject']) ?></td>
                  <td class="text-center text-muted"><?= date('d/m/Y H:i', strtotime($msg['created_at'])) ?></td>
                  <td class="text-center">
                    <span class="badge rounded-pill px-3 py-2 fw-semibold 
                      <?= $msg['status'] === 'replied' ? 'bg-success text-white' : 'bg-warning text-dark' ?>">
                      <?= $msg['status'] === 'replied' ? 'Đã phản hồi' : 'Chưa phản hồi' ?>
                    </span>
                  </td>
                  <td class="text-center">
                    <a href="<?= BASE_URL ?>contact/detail/<?= $msg['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                      <i class="fas fa-eye me-1"></i>Chi tiết
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <!-- Mobile View -->
        <div class="d-md-none">
          <?php foreach ($messages as $msg): ?>
            <div class="card mb-3 shadow-sm border-0 rounded-4">
              <div class="card-body bg-light-subtle rounded-4">
                <h5 class="card-title text-dark fw-bold"><?= htmlspecialchars($msg['subject']) ?></h5>
                <p class="card-text mb-1"><strong>Ngày gửi:</strong> <?= date('d/m/Y H:i', strtotime($msg['created_at'])) ?></p>
                <p class="card-text mb-2">
                  <strong>Trạng thái:</strong>
                  <span class="badge rounded-pill px-3 py-1 fw-semibold 
                    <?= $msg['status'] === 'replied' ? 'bg-success text-white' : 'bg-warning text-dark' ?>">
                    <?= $msg['status'] === 'replied' ? 'Đã phản hồi' : 'Chưa phản hồi' ?>
                  </span>
                </p>
                <a href="<?= BASE_URL ?>contact/detail/<?= $msg['id'] ?>" class="btn btn-outline-primary w-100 rounded-pill">Xem chi tiết</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php if (!empty($_SESSION['success'])): ?>
  <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
    <div id="successToast" class="toast align-items-center text-bg-success border-0 show" role="alert">
      <div class="d-flex">
        <div class="toast-body">
          <i class="fas fa-check-circle me-2"></i>
          <?= $_SESSION['success'] ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toastEl = document.getElementById('successToast');
    if (toastEl) {
      var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
      toast.show();
    }
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- FontAwesome for icons -->
<script src="https://kit.fontawesome.com/a2d2a93bcd.js" crossorigin="anonymous"></script>

<?php include 'views/client/layouts/footer.php'; ?>
