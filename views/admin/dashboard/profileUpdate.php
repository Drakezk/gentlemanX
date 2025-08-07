<?php include_once 'views/admin/layouts/header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo Helper::asset('css/profile.css') ?>">

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger shadow-sm"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
    <!-- Header -->
    <div class="card-header bg-gradient-primary d-flex justify-content-between align-items-center rounded-top-4 py-3 px-4">
      <h4 class="mb-0 fw-bold">
        <i class="bi bi-person-circle me-2 fs-3"></i> Cập nhật thông tin Admin
      </h4>
      <a href="<?= Helper::url('admin/profile/index') ?>" class="btn btn-light btn-sm rounded-pill d-flex align-items-center gap-2 shadow-sm fw-semibold">
        <i class="fas fa-arrow-left"></i> Quay lại
      </a>
    </div>

    <!-- Body -->
    <form action="<?= Helper::url('admin/profile/update') ?>" method="post" class="p-4 bg-light">
      <div class="mb-3">
        <label for="name" class="form-label"><i class="bi bi-person-fill"></i> Họ tên</label>
        <input type="text" class="form-control rounded-3" id="name" name="name" value="<?= $admin['name'] ?>" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>
        <input type="email" class="form-control rounded-3" id="email" name="email" value="<?= $admin['email'] ?>" required>
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label"><i class="bi bi-telephone-fill"></i> Số điện thoại</label>
        <input type="text" class="form-control rounded-3" id="phone" name="phone" value="<?= $admin['phone'] ?>">
      </div>

      <hr class="my-4">

      <div class="mb-3">
        <label for="password" class="form-label"><i class="bi bi-lock-fill"></i> Mật khẩu mới (nếu muốn đổi)</label>
        <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Để trống nếu không đổi">
      </div>

      <div class="mb-4">
        <label for="password_confirmation" class="form-label"><i class="bi bi-lock-fill"></i> Xác nhận mật khẩu mới</label>
        <input type="password" class="form-control rounded-3" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu mới">
      </div>

      <div class="d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-gradient px-4 rounded-pill fw-semibold shadow-sm">
          <i class="bi bi-save me-1"></i> Lưu thay đổi
        </button>
      </div>
    </form>
  </div>
</div>

<?php include_once 'views/admin/layouts/footer.php'; ?>
