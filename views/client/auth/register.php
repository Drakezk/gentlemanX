<?php include 'views/client/layouts/header.php'; ?>
<div class="container py-5">
  <h2 class="mb-4">Đăng ký</h2>
  <?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>
  <form method="POST" action="<?= Helper::url('auth/register'); ?>">
    <div class="mb-3">
      <label>Họ tên</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Mật khẩu</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Nhập lại mật khẩu</label>
      <input type="password" name="confirm_password" class="form-control" required>
    </div>
    <button class="btn btn-success">Đăng ký</button>
  </form>
</div>
<?php include 'views/client/layouts/footer.php'; ?>
