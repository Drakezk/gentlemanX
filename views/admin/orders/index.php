<?php include 'views/admin/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/management.css') ?>">

<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h3 class="mb-0 fw-bold"><i class="fas fa-box me-2"></i>Quản lý đơn hàng</h3>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table align-middle table-hover mb-0">
          <thead class="table-light">
            <tr class="text-center">
              <th>ID</th>
              <th>Mã đơn hàng</th>
              <th>Khách hàng</th>
              <th>Tổng tiền</th>
              <th>Trạng thái</th>
              <th>Thanh toán</th>
              <th>PT Thanh toán</th>
              <th>Địa chỉ</th>
              <th>Ngày tạo</th>
              <th>Cập nhật</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($orders as $order): ?>
              <tr>
                <td class="text-center fw-semibold"><?php echo $order['id']; ?></td>
                <td class="text-center text-primary fw-bold"><?php echo $order['order_number']; ?></td>
                <td class="text-center"><?php echo $order['user_id']; ?></td>
                <td class="text-end pe-3 fw-semibold text-success"><?php echo number_format($order['total_amount'],0,',','.'); ?> đ</td>
                <td class="text-center">
                  <?php if ($order['status'] == 'confirmed'): ?>
                    <span class="badge bg-success px-3 py-2 rounded-pill">Đã xác nhận</span>
                  <?php elseif ($order['status'] == 'cancelled'): ?>
                    <span class="badge bg-danger px-3 py-2 rounded-pill">Đã hủy</span>
                  <?php else: ?>
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Đang xử lý</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <span class="badge bg-<?php echo $order['payment_status']=='paid'?'info':'secondary'; ?> px-3 py-2 rounded-pill">
                    <?php echo ucfirst($order['payment_status']); ?>
                  </span>
                </td>
                <td class="text-center"><?php echo $order['payment_method']; ?></td>
                <td class="text-truncate" style="max-width:180px;"><?php echo !empty($order['shipping_address']) ? $order['shipping_address'] : '<i class="text-muted">Chưa có</i>'; ?></td>
                <td class="text-center small text-muted"><?php echo $order['created_at']; ?></td>
                <td class="text-center small text-muted"><?php echo $order['updated_at']; ?></td>
                <td class="text-center">
                  <?php if (!in_array($order['status'], ['confirmed','cancelled'])): ?>
                    <a href="<?php echo Helper::url('admin/order/edit/' . $order['id']); ?>" 
                      class="btn btn-sm btn-outline-warning rounded-pill me-1 px-3">
                      <i class="fas fa-edit"></i>
                    </a>
                  <?php endif; ?>                 
                  <a href="<?php echo Helper::url('admin/order/delete/' . $order['id']); ?>" 
                     class="btn btn-sm btn-outline-danger rounded-pill px-3"
                     onclick="return confirm('Xác nhận xóa?');">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include 'views/admin/layouts/footer.php'; ?>
