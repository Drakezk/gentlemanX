<?php include_once 'views/admin/layouts/header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success shadow-sm"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div class="container py-5">
  <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
    <div class="card-header text-white py-4" style="background: linear-gradient(90deg, #0d6efd, #6610f2);">
      <h4 class="mb-0 d-flex align-items-center">
        <i class="bi bi-person-circle me-2 fs-3"></i>
        Thông tin Quản trị viên
      </h4>
    </div>

    <div class="card-body p-4 bg-light">
      <?php
        $fields = [
          'ID' => $admin['id'],
          'Họ tên' => $admin['name'],
          'Email' => $admin['email'],
          'Số điện thoại' => $admin['phone'],
          'Vai trò' => ucfirst($admin['role']),
          'Đăng nhập lần cuối' => $admin['last_login_at'] ?? '<span class="text-muted">Chưa có</span>',
        ];
        foreach ($fields as $label => $value):
      ?>
        <div class="row mb-4 align-items-center hover-shadow-sm transition">
          <div class="col-sm-4 fw-semibold text-secondary">
            <i class="bi bi-dot text-primary me-1"></i><?= $label ?>:
          </div>
          <div class="col-sm-8"><?= $value ?></div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="card-footer bg-white text-end p-3">
      <a href="<?= Helper::url('admin/profile/update') ?>" class="btn btn-gradient px-4 rounded-pill">
        <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa thông tin
      </a>
    </div>
  </div>
</div>

<style>
.btn-gradient {
  background: linear-gradient(90deg, #0d6efd, #6610f2);
  color: #fff;
  border: none;
  transition: all 0.3s ease;
}

.btn-gradient:hover {
  opacity: 0.9;
  transform: translateY(-1px);
}

.hover-shadow-sm:hover {
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
  background-color: #f8f9fa;
  border-radius: 0.5rem;
}

.transition {
  transition: all 0.2s ease-in-out;
}
</style>

<?php include_once 'views/admin/layouts/footer.php'; ?>