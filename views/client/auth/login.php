<?php include 'views/client/layouts/header.php'; ?>

<section class="min-vh-100 d-flex align-items-center justify-content-center bg-light py-5">
  <div class="card shadow-lg border-0 rounded-4" style="max-width: 540px; width: 100%;">
    <div class="card-body p-5">
      <h1 class="fw-bold mb-4 text-center display-5">Đăng nhập</h1>

      <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger rounded-3 fs-5 py-3">
          <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="<?= Helper::url('auth/login'); ?>">
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

        <!-- Password -->
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

        <!-- Quên mật khẩu -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <a href="<?= Helper::url('auth/forgot'); ?>" class="fs-6 text-decoration-none text-primary">
            Quên mật khẩu?
          </a>
        </div>

        <!-- Nút đăng nhập -->
        <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fs-5 fw-bold">
          <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
        </button>
      </form>

      <hr class="my-5">
      <p class="text-center fs-6 mb-0">
        Chưa có tài khoản?
        <a href="<?= Helper::url('auth/register'); ?>" class="fw-bold text-decoration-none">Đăng ký ngay</a>
      </p>
    </div>
  </div>
</section>

<style>
  input.form-control:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
}
  button.btn-primary:hover {
    background-color: #0b5ed7;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    transition: all 0.25s ease;
  }
  .card {
    background: #fff;
  }
</style>
<?php include 'views/client/layouts/footer.php'; ?>
