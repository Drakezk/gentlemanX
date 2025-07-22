<?php include 'views/client/layouts/header.php'; ?>

<section class="min-vh-100 d-flex align-items-center justify-content-center bg-light py-5">
  <div class="card shadow-lg border-0 rounded-4" style="max-width: 540px; width: 100%;">
    <div class="card-body p-5">
      <h1 class="fw-bold mb-4 text-center display-5">Đăng ký</h1>

      <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger rounded-3 fs-5 py-3">
          <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="<?= Helper::url('auth/register'); ?>">
        <!-- Họ tên -->
        <div class="mb-4">
          <label for="name" class="form-label fw-semibold fs-5 mb-2">Họ tên</label>
          <div class="input-group input-group-lg">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-user text-muted"></i>
            </span>
            <input type="text" name="name" id="name"
                   class="form-control border-start-0 fs-5"
                   placeholder="Nhập họ và tên" required>
          </div>
        </div>

        <!-- Email -->
        <div class="mb-4">
          <label for="email" class="form-label fw-semibold fs-5 mb-2">Email</label>
          <div class="input-group input-group-lg">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-envelope text-muted"></i>
            </span>
            <input type="email" name="email" id="email"
                   class="form-control border-start-0 fs-5"
                   placeholder="Nhập email của bạn" required>
          </div>
        </div>

        <!-- Mật khẩu -->
        <div class="mb-4">
          <label for="password" class="form-label fw-semibold fs-5 mb-2">Mật khẩu</label>
          <div class="input-group input-group-lg">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-lock text-muted"></i>
            </span>
            <input type="password" name="password" id="password"
                   class="form-control border-start-0 fs-5"
                   placeholder="Nhập mật khẩu" required>
          </div>
        </div>

        <!-- Xác nhận mật khẩu -->
        <div class="mb-4">
          <label for="confirm_password" class="form-label fw-semibold fs-5 mb-2">Nhập lại mật khẩu</label>
          <div class="input-group input-group-lg">
            <span class="input-group-text bg-white border-end-0">
              <i class="fas fa-lock text-muted"></i>
            </span>
            <input type="password" name="confirm_password" id="confirm_password"
                   class="form-control border-start-0 fs-5"
                   placeholder="Nhập lại mật khẩu" required>
          </div>
        </div>

        <!-- Nút đăng ký -->
        <button type="submit" class="btn btn-success w-100 rounded-pill py-3 fs-5 fw-bold">
          <i class="fas fa-user-plus me-2"></i> Đăng ký
        </button>
      </form>

      <hr class="my-5">
      <p class="text-center fs-6 mb-0">
        Đã có tài khoản?
        <a href="<?= Helper::url('auth/login'); ?>" class="fw-bold text-decoration-none">Đăng nhập ngay</a>
      </p>
    </div>
  </div>
</section>

<style>
  input.form-control:focus {
  border-color: #198754;
  box-shadow: 0 0 0 0.2rem rgba(25,135,84,.25);
  }
  button.btn-success:hover {
    background-color: #157347;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    transition: all 0.25s ease;
  }
  .card {
    background: #fff;
  }
</style>
<?php include 'views/client/layouts/footer.php'; ?>
