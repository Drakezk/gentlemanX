<?php include 'views/admin/layouts/header.php'; ?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h3 fw-bold text-primary d-flex align-items-center gap-2">
    <i class="fas fa-tachometer-alt"></i> <?php echo Helper::e($title) ?>
  </h1>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
  <div class="col-xl-3 col-md-6">
    <div class="card shadow-sm border-0 rounded-3 h-100">
      <div class="card-body d-flex align-items-center">
        <div class="flex-grow-1">
          <p class="text-muted text-uppercase fw-semibold small mb-1">Tổng khách hàng</p>
          <h3 class="mb-0 fw-bold text-primary"><?php echo number_format($userStats['customers']) ?></h3>
        </div>
        <div class="ms-3 text-primary">
          <i class="fas fa-users fa-2x"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card shadow-sm border-0 rounded-3 h-100">
      <div class="card-body d-flex align-items-center">
        <div class="flex-grow-1">
          <p class="text-muted text-uppercase fw-semibold small mb-1">Tổng sản phẩm</p>
          <h3 class="mb-0 fw-bold text-success"><?php echo number_format($productStats['total']) ?></h3>
        </div>
        <div class="ms-3 text-success">
          <i class="fas fa-box fa-2x"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card shadow-sm border-0 rounded-3 h-100">
      <div class="card-body d-flex align-items-center">
        <div class="flex-grow-1">
          <p class="text-muted text-uppercase fw-semibold small mb-1">Sản phẩm active</p>
          <h3 class="mb-0 fw-bold text-info"><?php echo number_format($productStats['active']) ?></h3>
        </div>
        <div class="ms-3 text-info">
          <i class="fas fa-check-circle fa-2x"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card shadow-sm border-0 rounded-3 h-100">
      <div class="card-body d-flex align-items-center">
        <div class="flex-grow-1">
          <p class="text-muted text-uppercase fw-semibold small mb-1">Sắp hết hàng</p>
          <h3 class="mb-0 fw-bold text-warning"><?php echo number_format($productStats['low_stock']) ?></h3>
        </div>
        <div class="ms-3 text-warning">
          <i class="fas fa-exclamation-triangle fa-2x"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Content Row -->
<div class="row g-4">
  <!-- Latest Products -->
  <div class="col-lg-6">
    <div class="card shadow-sm border-0 rounded-3">
      <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom-0">
        <h6 class="fw-bold text-primary mb-0 d-flex align-items-center gap-2">
          <i class="fas fa-box-open"></i> Sản phẩm mới nhất
        </h6>
        <a href="<?php echo Helper::url('admin/product') ?>" class="btn btn-sm btn-outline-primary">
          Xem tất cả
        </a>
      </div>
      <div class="card-body">
        <?php if (!empty($latestProducts)): ?>
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>Sản phẩm</th>
                  <th>Giá</th>
                  <th>Trạng thái</th>
                  <th>Ngày tạo</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($latestProducts as $product): ?>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <?php if ($product['featured_image']): ?>
                          <img src="<?php echo Helper::upload($product['featured_image']) ?>"
                               class="rounded me-2 border"
                               width="40" height="40" style="object-fit: cover;">
                        <?php else: ?>
                          <div class="bg-light d-flex align-items-center justify-content-center rounded me-2"
                               style="height:40px;width:40px;">
                            <i class="fas fa-image text-muted"></i>
                          </div>
                        <?php endif; ?>
                        <div>
                          <div class="fw-semibold"><?php echo Helper::truncate($product['name'], 30) ?></div>
                          <small class="text-muted"><?php echo Helper::e($product['sku']) ?></small>
                        </div>
                      </div>
                    </td>
                    <td class="fw-bold text-dark"><?php echo Helper::formatMoney($product['price']) ?></td>
                    <td>
                      <span class="badge bg-<?php echo $product['status']=='active'?'success':'secondary' ?>">
                        <?php echo ucfirst($product['status']=='active'?'Hoạt động':'Ẩn') ?>
                      </span>
                    </td>
                    <td><small class="text-muted"><?php echo Helper::formatDate($product['created_at'], 'd/m/Y') ?></small></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <p class="text-muted mb-0">Chưa có sản phẩm nào.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Latest Users -->
  <div class="col-lg-6">
    <div class="card shadow-sm border-0 rounded-3">
      <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom-0">
        <h6 class="fw-bold text-primary mb-0 d-flex align-items-center gap-2">
          <i class="fas fa-user-plus"></i> Khách hàng mới nhất
        </h6>
        <a href="<?php echo Helper::url('admin/user/customers') ?>" class="btn btn-sm btn-outline-primary">
          Xem tất cả
        </a>
      </div>
      <div class="card-body">
        <?php if (!empty($latestUsers)): ?>
          <div class="table-responsive text-center">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>Tên</th>
                  <th>Email</th>
                  <th>Trạng thái</th>
                  <th>Ngày đăng ký</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($latestUsers as $user): ?>
                  <tr>
                    <td class="fw-semibold"><?php echo Helper::e($user['name']) ?></td>
                    <td><?php echo Helper::e($user['email']) ?></td>
                    <td>
                      <span class="badge bg-<?php echo $user['status']=='active'?'success':'secondary' ?>">
                        <?php echo ucfirst($user['status']=='active'?'Hoạt động':'Khóa') ?>
                      </span>
                    </td>
                    <td><small class="text-muted"><?php echo Helper::formatDate($user['created_at'], 'd/m/Y') ?></small></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <p class="text-muted mb-0">Chưa có khách hàng nào.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php if (!empty($_SESSION['success'])): ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
  <div id="flashToast" class="toast align-items-center text-bg-success border-0" 
       role="alert" data-bs-autohide="true" data-bs-delay="3000">
    <div class="d-flex">
      <div class="toast-body">
        <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['success']; ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>
<?php unset($_SESSION['success']); ?>
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

<?php include 'views/admin/layouts/footer.php'; ?>