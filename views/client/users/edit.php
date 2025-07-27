<?php include 'views/client/layouts/header.php'; ?>

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="<?php echo Helper::asset('css/account.css') ?>">

<div class="container py-5">
  <!-- Tiêu đề trang -->
  <div class="text-center mb-5">
    <h1 class="fw-bold text-dark mb-2 animate__animated animate__fadeInDown">
      <i class="fas fa-user-cog text-primary me-2"></i>Cập nhật thông tin cá nhân
    </h1>
    <p class="text-muted">Cập nhật hồ sơ và bảo mật tài khoản của bạn</p>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-lg border-0 rounded-4 animate__animated animate__fadeInUp overflow-hidden">
        <div class="card-header bg-gradient-primary text-white py-4 px-4">
          <h3 class="mb-0 fw-bold d-flex align-items-center">
            <i class="fas fa-user-edit me-2 fs-4"></i>Sửa thông tin
          </h3>
        </div>
        <div class="card-body p-4 p-lg-5 bg-light">
          <form method="POST" action="" class="needs-validation" novalidate>
            <!-- Họ tên -->
            <div class="mb-4">
              <label class="form-label fw-semibold text-dark">
                <i class="fas fa-user me-2 text-primary"></i>Họ tên
              </label>
              <div class="input-group input-group-lg shadow-sm rounded-3">
                <span class="input-group-text bg-white border-end-0">
                  <i class="fas fa-user text-secondary"></i>
                </span>
                <input type="text" name="name" class="form-control border-start-0" 
                       value="<?php echo htmlspecialchars($user['name']); ?>" required>
              </div>
            </div>

            <!-- Email -->
            <div class="mb-4">
              <label class="form-label fw-semibold text-dark">
                <i class="fas fa-envelope me-2 text-primary"></i>Email
              </label>
              <div class="input-group input-group-lg shadow-sm rounded-3">
                <span class="input-group-text bg-white border-end-0">
                  <i class="fas fa-envelope text-secondary"></i>
                </span>
                <input type="email" name="email" class="form-control border-start-0"
                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
              </div>
            </div>

            <!-- Mật khẩu -->
            <div class="mb-4">
              <label class="form-label fw-semibold text-dark">
                <i class="fas fa-lock me-2 text-primary"></i>Mật khẩu mới
              </label>
              <div class="input-group input-group-lg shadow-sm rounded-3">
                <span class="input-group-text bg-white border-end-0">
                  <i class="fas fa-lock text-secondary"></i>
                </span>
                <input type="password" name="password" class="form-control border-start-0"
                       placeholder="Để trống nếu không đổi mật khẩu">
              </div>
            </div>

            <!-- Nút hành động -->
            <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
              <a href="<?php echo Helper::url('auth/account'); ?>" 
                 class="btn btn-outline-secondary rounded-pill px-4 py-2 btn-action">
                <i class="fas fa-arrow-left me-2"></i>Quay lại
              </a>
              <button type="submit" 
                      class="btn btn-gradient-primary rounded-pill px-4 py-2 btn-action">
                <i class="fas fa-save me-2"></i>Lưu thay đổi
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
/* Gradient màu chính */
.bg-gradient-primary {
  background: linear-gradient(135deg, #0d6efd, #6610f2);
}

/* Nút gradient chính */
.btn-gradient-primary {
  background: linear-gradient(135deg, #0d6efd, #6610f2);
  color: #fff;
  border: none;
  transition: all 0.3s ease;
}
.btn-gradient-primary:hover {
  filter: brightness(1.1);
  transform: translateY(-2px);
  box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
}

/* Nút hành động chung */
.btn-action {
  transition: all 0.3s ease;
}
.btn-action:hover {
  transform: translateY(-2px);
  box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
}

/* Input focus hiện đại */
.input-group .form-control:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 0 0.25rem rgba(13,110,253,0.25);
}
.input-group-text {
  border-radius: 0.75rem 0 0 0.75rem;
}
.input-group .form-control {
  border-radius: 0 0.75rem 0.75rem 0;
}
</style>

<?php include 'views/client/layouts/footer.php'; ?>
