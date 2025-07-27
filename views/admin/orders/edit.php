<?php include 'views/admin/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/create.css'); ?>">

<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <!-- Header -->
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h3 class="mb-0 fw-bold">
        <i class="fas fa-clipboard-list me-2"></i> Cập nhật đơn hàng #<?php echo $order['id']; ?>
      </h3>
      <a href="<?php echo Helper::url('admin/order/index'); ?>" 
         class="btn btn-light btn-sm fw-semibold rounded-pill shadow-sm d-flex align-items-center gap-2">
        <i class="fas fa-arrow-left"></i> Quay lại
      </a>
    </div>

    <!-- Body -->
    <div class="card-body">
      <form method="post">
        <div class="mb-3">
          <label class="form-label fw-semibold">Trạng thái đơn hàng</label>
          <select name="status" class="form-select rounded-3">
            <option value="pending"   <?php echo $order['status']=='pending'?'selected':''; ?>>Chờ xác nhận</option>
            <option value="confirmed" <?php echo $order['status']=='confirmed'?'selected':''; ?>>Đã xác nhận</option>
            <!-- <option value="shipped"   <?php echo $order['status']=='shipped'?'selected':''; ?>>Đang giao</option>
            <option value="completed" <?php echo $order['status']=='completed'?'selected':''; ?>>Hoàn thành</option> -->
            <option value="cancelled" <?php echo $order['status']=='cancelled'?'selected':''; ?>>Đã hủy</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Trạng thái thanh toán</label>
          <select name="payment_status" class="form-select rounded-3">
            <option value="pending"  <?php echo $order['payment_status']=='pending'?'selected':''; ?>>Chưa thanh toán</option>
            <option value="paid"     <?php echo $order['payment_status']=='paid'?'selected':''; ?>>Đã thanh toán</option>
            <option value="refunded" <?php echo $order['payment_status']=='refunded'?'selected':''; ?>>Đã hoàn tiền</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Địa chỉ giao hàng</label>
          <input type="text" name="shipping_address" 
                 class="form-control rounded-3" 
                 value="<?php echo Helper::e($order['shipping_address']); ?>">
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-success fw-semibold rounded-pill px-4 shadow-sm">
            <i class="fas fa-save me-1"></i> Cập nhật
          </button>
          <a href="<?php echo Helper::url('admin/order/index'); ?>" 
             class="btn btn-secondary fw-semibold rounded-pill px-4 shadow-sm">
            <i class="fas fa-times me-1"></i> Hủy
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'views/admin/layouts/footer.php'; ?>
