<?php include 'views/client/layouts/header.php'; ?>

<!-- Animate.css để dùng hiệu ứng có sẵn -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="<?php echo Helper::asset('css/account.css') ?>">

<div class="container py-5">

  <!-- Tiêu đề trang -->
  <div class="d-flex align-items-center mb-4">
    <i class="fas fa-user-circle fs-1 text-primary me-3"></i>
    <div>
      <h1 class="fw-bold text-dark mb-1">Thông tin tài khoản</h1>
      <p class="text-muted mb-0">Quản lý hồ sơ & theo dõi đơn hàng của bạn</p>
    </div>
  </div>

  <?php if (isset($user)): ?>
    <!-- Card thông tin tài khoản -->
    <div class="card account-card mb-5 hover-shadow transition-all">
      <div class="card-body p-4">
        <div class="row g-4">
          <div class="col-md-6">
            <p class="mb-3 d-flex align-items-center">
              <i class="fas fa-user text-secondary me-2 fs-5"></i>
              <strong class="me-1">Tên:</strong> <?php echo htmlspecialchars($user['name']); ?>
            </p>
            <p class="mb-3 d-flex align-items-center">
              <i class="fas fa-envelope text-secondary me-2 fs-5"></i>
              <strong class="me-1">Email:</strong> <?php echo htmlspecialchars($user['email']); ?>
            </p>
          </div>
          <div class="col-md-6">
            <p class="mb-3 d-flex align-items-center">
              <i class="fas fa-user-tag text-secondary me-2 fs-5"></i>
              <strong class="me-1">Vai trò:</strong>
              <span class="badge bg-gradient bg-primary px-3 py-2 rounded-pill">
                <?php echo htmlspecialchars($user['role']); ?>
              </span>
            </p>
            <p class="mb-3 d-flex align-items-center">
              <i class="fas fa-calendar-alt text-secondary me-2 fs-5"></i>
              <strong class="me-1">Ngày tạo:</strong>
              <?php echo htmlspecialchars($user['created_at']); ?>
            </p>
          </div>
        </div>

        <!-- Nút hành động -->
        <div class="mt-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
          <div class="d-flex flex-wrap gap-2">
            <a href="<?php echo Helper::url('user/edit'); ?>" class="btn btn-primary rounded-pill px-4 py-2">
              <i class="fas fa-edit me-2"></i>Sửa thông tin
            </a>
            <?php if ($user['role'] === 'admin'): ?>
              <a href="<?php echo Helper::url('admin'); ?>" class="btn btn-warning rounded-pill px-4 py-2">
                <i class="fas fa-cogs me-2"></i>Trang Quản Trị
              </a>
            <?php endif; ?>
          </div>
          <div>
            <a href="<?php echo Helper::url('auth/logout'); ?>" class="btn btn-outline-danger rounded-pill px-4 py-2">
              <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Danh sách đơn hàng -->
    <h2 class="mb-3 fw-bold text-success d-flex align-items-center">
      <i class="fas fa-box-open me-2 fs-3"></i> Đơn hàng của bạn
    </h2>

    <?php if (!empty($orders)): ?>
      <div class="table-responsive rounded-4 shadow-sm overflow-hidden animate__animated animate__fadeInUp">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr class="text-center">
              <th class="py-3">Mã đơn</th>
              <th>Ngày đặt</th>
              <th>Tổng tiền</th>
              <th>Trạng thái</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $order): ?>
              <tr class="text-center">
                <td class="fw-bold text-primary">#<?php echo $order['id']; ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                <td class="text-danger fw-semibold">
                  <?php echo number_format($order['total_amount'], 0, ',', '.'); ?> đ
                </td>
                <td>
                  <?php
                    $status = $order['status'];
                    $badgeClass = match($status) {
                      'pending'    => 'bg-warning text-dark pulse-badge',
                      'processing' => 'bg-info',
                      'shipped'    => 'bg-primary',
                      'completed'  => 'bg-success',
                      'cancelled'  => 'bg-danger',
                      default      => 'bg-secondary'
                    };
                  ?>
                  <span class="badge rounded-pill <?php echo $badgeClass; ?> px-3 py-2 text-capitalize">
                    <?php echo $status; ?>
                  </span>
                </td>
                <td>
                  <a href="<?php echo Helper::url('checkout/detail/' . $order['id']); ?>" 
                     class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1">
                    <i class="fas fa-eye me-1"></i>Xem
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info rounded-4 shadow-sm p-4 mt-3">
        <i class="fas fa-info-circle me-2"></i>Bạn chưa có đơn hàng nào.
      </div>
    <?php endif; ?>

  <?php else: ?>
    <div class="alert alert-danger rounded-4 shadow-sm p-4">
      <i class="fas fa-exclamation-circle me-2"></i>Không tìm thấy thông tin tài khoản.
    </div>
  <?php endif; ?>
</div>

<?php
  $flashMessage = $_SESSION['success'] ?? $_SESSION['flash'] ?? null;

  if (!empty($flashMessage)):
  ?>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
      <div id="flashToast" class="toast align-items-center text-bg-success border-0" 
          role="alert" data-bs-autohide="true" data-bs-delay="3000">
        <div class="d-flex">
          <div class="toast-body">
            <i class="fas fa-check-circle me-2"></i><?= $flashMessage ?>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
      </div>
    </div>
  <?php
  unset($_SESSION['success'], $_SESSION['flash']);
  endif;
?>

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
