<?php include 'views/client/layouts/header.php'; ?>

<section class="py-5">
  <div class="container">
    <h1 class="mb-4 fw-bold">Chi tiết đơn hàng #<?php echo htmlspecialchars($order['id']); ?></h1>

    <div class="card mb-4">
      <div class="card-body">
        <p><strong>Mã đơn hàng:</strong> <?php echo htmlspecialchars($order['order_number']); ?></p>
        <p><strong>Ngày đặt:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>
        <p><strong>Trạng thái:</strong> <span class="badge bg-info"><?php echo htmlspecialchars($order['status']); ?></span></p>
        <p><strong>Tổng tiền:</strong> <span class="text-danger fw-bold"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> đ</span></p>

        <hr>
        <h5>Thông tin giao hàng</h5>
        <p><strong>Người nhận:</strong> <?php echo htmlspecialchars($order['shipping_name']); ?></p>
        <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?>, <?php echo htmlspecialchars($order['shipping_ward']); ?>, <?php echo htmlspecialchars($order['shipping_district']); ?>, <?php echo htmlspecialchars($order['shipping_province']); ?></p>
        <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['shipping_phone']); ?></p>
      </div>
    </div>

    <h4 class="mb-3">Sản phẩm trong đơn hàng</h4>
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orderItems as $item): ?>
            <tr>
              <td style="width: 80px;">
                <?php if (!empty($item['product_image'])): ?>
                  <img src="<?php echo Helper::asset($item['product_image']); ?>" class="img-fluid rounded" alt="">
                <?php else: ?>
                  <span class="text-muted">Không có ảnh</span>
                <?php endif; ?>
              </td>
              <td><?php echo htmlspecialchars($item['product_name']); ?></td>
              <td><?php echo $item['quantity']; ?></td>
              <td><?php echo number_format($item['unit_price'], 0, ',', '.'); ?> đ</td>
              <td><?php echo number_format($item['total_price'], 0, ',', '.'); ?> đ</td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <a href="<?php echo Helper::url('order/list'); ?>" class="btn btn-secondary mt-3">
      <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách đơn hàng
    </a>
  </div>
</section>

<?php include 'views/client/layouts/footer.php'; ?>
