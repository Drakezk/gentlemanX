<?php include 'views/client/layouts/header.php'; ?>

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="<?php echo Helper::asset('css/account.css') ?>">

<section class="py-5">
  <div class="container">
    <!-- Tiêu đề trang -->
    <div class="d-flex align-items-center mb-4 animate__animated animate__fadeInDown">
      <i class="fas fa-box-open fs-1 text-primary me-3"></i>
      <div>
        <h1 class="fw-bold text-dark mb-1">Chi tiết đơn hàng #<?php echo htmlspecialchars($order['id']); ?></h1>
        <p class="text-muted mb-0">Xem thông tin chi tiết và trạng thái đơn hàng của bạn</p>
      </div>
    </div>

    <!-- Thông tin đơn hàng -->
    <div class="card shadow-lg border-0 rounded-4 mb-5 animate__animated animate__fadeInUp overflow-hidden">
      <div class="card-header bg-gradient-primary text-white py-3 px-4">
        <h5 class="mb-0 fw-bold"><i class="fas fa-receipt me-2"></i>Thông tin đơn hàng</h5>
      </div>
      <div class="card-body p-4 bg-light">
        <div class="row g-3">
          <div class="col-md-6">
            <p><strong>Mã đơn hàng:</strong> <?php echo htmlspecialchars($order['order_number']); ?></p>
            <p><strong>Ngày đặt:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>
            <p><strong>Trạng thái:</strong>
              <?php
                $status = $order['status'];
                $badgeClass = match($status) {
                  'pending'    => 'bg-warning text-dark',
                  'processing' => 'bg-info text-white',
                  'shipped'    => 'bg-primary',
                  'completed'  => 'bg-success',
                  'cancelled'  => 'bg-danger',
                  default      => 'bg-secondary'
                };
              ?>
              <span class="badge rounded-pill <?php echo $badgeClass; ?> px-3 py-2 text-capitalize">
                <?php echo htmlspecialchars($order['status']); ?>
              </span>
            </p>
            <p><strong>Tổng tiền:</strong>
              <span class="text-danger fw-bold fs-5">
                <?php echo number_format($order['total_amount'], 0, ',', '.'); ?> đ
              </span>
            </p>
          </div>
          <div class="col-md-6">
            <h6 class="fw-bold mb-3"><i class="fas fa-truck me-2 text-primary"></i>Thông tin giao hàng</h6>
            <p><strong>Người nhận:</strong> <?php echo htmlspecialchars($order['user_name']); ?></p>
            <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
            <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['shipping_phone']); ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Sản phẩm trong đơn -->
    <h4 class="mb-3 fw-bold text-success d-flex align-items-center">
      <i class="fas fa-box me-2 fs-3"></i>Sản phẩm trong đơn hàng
    </h4>
    <div class="table-responsive rounded-4 shadow-sm overflow-hidden animate__animated animate__fadeInUp">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr class="text-center">
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orderItems as $item): ?>
            <tr class="text-center">
              <td style="width: 90px;">
                <?php if (!empty($item['product_image'])): ?>
                  <img src="<?php echo Helper::upload($item['product_image']); ?>"
                       class="img-fluid rounded shadow-sm" alt=""
                       style="max-height:70px; object-fit:cover;">
                <?php else: ?>
                  <span class="text-muted fst-italic">Không có ảnh</span>
                <?php endif; ?>
              </td>
              <td class="fw-semibold"><?php echo htmlspecialchars($item['product_name']); ?></td>
              <td><?php echo $item['quantity']; ?></td>
              <td class="text-primary fw-medium"><?php echo number_format($item['unit_price'], 0, ',', '.'); ?> đ</td>
              <td class="text-danger fw-bold"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> đ</td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Nút quay lại -->
    <div class="mt-4">
      <a href="<?php echo Helper::url('auth/account'); ?>"
         class="btn btn-outline-secondary rounded-pill px-4 py-2 btn-action">
        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách đơn hàng
      </a>

      <?php if ($order['status'] === 'pending'): ?>
        <form method="POST" action="<?php echo Helper::url('checkout/cancel/' . $order['id']); ?>" onsubmit="return confirm('Bạn có chắc muốn hủy đơn này?');" class="d-inline">
          <button type="submit" class="btn btn-danger rounded-pill px-4 py-2 ms-2 btn-action">
            <i class="fas fa-times me-2"></i>Hủy đơn hàng
          </button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</section>

<style>
.bg-gradient-primary {
  background: linear-gradient(135deg, #0d6efd, #6610f2);
}

.btn-action {
  transition: all 0.3s ease;
}
.btn-action:hover {
  transform: translateY(-2px);
  box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
}

.table-hover tbody tr:hover {
  background-color: #f8f9fa;
}

.badge {
  font-size: 0.9rem;
}

h1, h4, h5, h6 {
  letter-spacing: 0.5px;
}
</style>

<?php include 'views/client/layouts/footer.php'; ?>