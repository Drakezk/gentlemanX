<?php include 'views/client/layouts/header.php'; ?>

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="<?php echo Helper::asset('css/account.css') ?>">
<link rel="stylesheet" href="<?php echo Helper::asset('css/editinfo.css') ?>">

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
              <label class="form-label fw-semibold text-dark d-flex align-items-center">
                <i class="fas fa-envelope me-2 text-primary"></i>Email
                <span class="badge bg-secondary ms-2">Chỉ xem</span>
              </label>
              <div class="input-group input-group-lg shadow-sm rounded-3">
                <span class="input-group-text bg-white border-end-0">
                  <i class="fas fa-envelope text-secondary"></i>
                </span>
                <input 
                  type="email" 
                  name="email" 
                  value="<?= htmlspecialchars($user['email']) ?>" 
                  class="form-control bg-light text-muted border-start-0" 
                  readonly
                >
              </div>
            </div>

            <!-- Phone -->
            <div class="mb-4">
              <label class="form-label fw-semibold text-dark">
                <i class="fas fa-phone-alt me-2 text-primary"></i>Số điện thoại
              </label>
              <div class="input-group input-group-lg shadow-sm rounded-3">
                <span class="input-group-text bg-white border-end-0">
                  <i class="fas fa-phone-alt text-secondary"></i>
                </span>
                <input
                  type="text"
                  name="phone"
                  class="form-control border-start-0"
                  value="<?php echo htmlspecialchars($user['phone']??''); ?>"
                  placeholder="VD: 0901234567"
                  pattern="0[0-9]{9,10}"
                  maxlength="11"
                  required
                >
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

            <!-- Xác nhận mật khẩu -->
            <div class="mb-4">
              <label class="form-label fw-semibold text-dark">
                <i class="fas fa-lock me-2 text-primary"></i>Xác nhận mật khẩu
              </label>
              <div class="input-group input-group-lg shadow-sm rounded-3">
                <span class="input-group-text bg-white border-end-0">
                  <i class="fas fa-lock text-secondary"></i>
                </span>
                <input type="password" name="password_confirmation" class="form-control border-start-0"
                      placeholder="Nhập lại mật khẩu mới">
              </div>
            </div>

            <!-- Nút hành động -->
            <div class="bg-gradient-primary text-white rounded shadow-sm p-4 mt-4">
              <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <a href="<?php echo Helper::url('auth/account'); ?>" 
                  class="btn btn-outline-light rounded-pill px-4 py-2 btn-action">
                  <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
                <button type="submit" class="btn btn-light text-primary rounded-pill px-4 py-2 btn-action fw-bold btn-hover-glow">
                  <i class="fas fa-save me-2"></i>Lưu thay đổi
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if (isset($_SESSION['error'])): ?>
  <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div id="flashToast" class="toast align-items-center text-white bg-danger border-0" 
        role="alert" data-bs-autohide="true" data-bs-delay="3000">
      <div class="d-flex">
        <div class="toast-body">
          <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['error']; ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var toastEl = document.getElementById('flashToast');
    if (toastEl) {
      var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
      toast.show(); // Hiển thị toast và tự ẩn sau delay
    }
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'views/client/layouts/footer.php'; ?>
