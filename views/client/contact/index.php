<?php include 'views/client/layouts/header.php'; ?>

<?php if (!empty($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <?= htmlspecialchars($_SESSION['success']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <?= htmlspecialchars($_SESSION['error']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<section class="contact-form-section py-5 bg-light">
  <div class="container">
    <h2 class="text-center fw-bold mb-4">📬 Liên hệ với GentlemanX</h2>
    <p class="text-center mb-4">Nếu bạn có bất kỳ câu hỏi, góp ý hoặc cần hỗ trợ, hãy gửi tin nhắn cho chúng tôi.</p>

    <form action="<?= BASE_URL ?>contact/send" method="POST" class="row g-3 mb-5">
      <div class="col-md-6">
        <input type="text" name="name" class="form-control" placeholder="Họ tên của bạn" required>
      </div>
      <div class="col-md-6">
        <input type="email" name="email" class="form-control" placeholder="Email liên hệ" required>
      </div>
      <div class="col-12">
        <input type="text" name="subject" class="form-control" placeholder="Chủ đề" required>
      </div>
      <div class="col-12">
        <textarea name="message" rows="5" class="form-control" placeholder="Nội dung tin nhắn..." required></textarea>
      </div>
      <div class="col-12 text-center">
        <button type="submit" class="btn btn-dark px-5 py-2">Gửi liên hệ</button>
      </div>
    </form>

    <!--  Lịch sử liên hệ nếu có -->
    <?php if (!empty($messages)): ?>
      <h4 class="mb-3">📜 Lịch sử liên hệ của bạn</h4>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="table-dark">
            <tr>
              <th>Chủ đề</th>
              <th>Ngày gửi</th>
              <th>Trạng thái</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($messages as $msg): ?>
              <tr>
                <td><?= htmlspecialchars($msg['subject']) ?></td>
                <td><?= htmlspecialchars($msg['created_at']) ?></td>
                <td><?= $msg['status'] === 'replied' ? 'Đã phản hồi' : 'Chưa phản hồi' ?></td>
                <td><a href="<?= BASE_URL ?>contact/detail/<?= $msg['id'] ?>" class="btn btn-sm btn-info">Chi tiết</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'views/client/layouts/footer.php'; ?>
