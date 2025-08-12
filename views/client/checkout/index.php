<?php include 'views/client/layouts/header.php'; ?>

<section class="checkout-section py-5">
  <div class="container">
    <h1 class="mb-4 fw-bold">Thanh toán</h1>

    <form method="POST" action="<?php echo Helper::url('checkout/placeOrder'); ?>">
      <div class="row">
        <!-- Thông tin khách hàng -->
        <div class="col-lg-7 mb-4">
          <div class="card shadow-sm rounded-4">
            <div class="card-body">
              <h5 class="mb-3">Thông tin khách hàng</h5>
              
              <div class="mb-3">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="customer_name" class="form-control" 
                       value="<?php echo isset($user['name']) ? Helper::e($user['name']) : ''; ?>" readonly>
              </div>

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="customer_email" class="form-control" 
                       value="<?php echo isset($user['email']) ? Helper::e($user['email']) : ''; ?>" readonly>
              </div>

              <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="customer_phone" class="form-control"
                       value="<?php echo isset($user['phone']) ? Helper::e($user['phone']) : ''; ?>" required>
              </div>

              <hr class="my-4">

              <h5 class="mb-3">Địa chỉ giao hàng</h5>

              <div class="mb-3">
                <label class="form-label">Địa chỉ chi tiết</label>
                <input type="text" name="shipping_address" class="form-control" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Mã giảm giá (nếu có)</label>
                <input type="text" name="shipping_postal_code" class="form-control">
              </div>

              <div class="mb-3">
                <label class="form-label">Ghi chú</label>
                <textarea name="notes" class="form-control" rows="3"></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- Tóm tắt đơn hàng -->
        <div class="col-lg-5">
          <div class="card shadow-sm rounded-4">
            <div class="card-body">
              <h5 class="mb-3">Đơn hàng của bạn</h5>
              <ul class="list-group mb-3">
                <?php foreach ($cartItems as $item): ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                      <h6 class="my-0"><?php echo Helper::e($item['name']); ?></h6>
                      <small class="text-muted">SL: <?php echo $item['quantity']; ?></small>
                    </div>
                    <span><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> đ</span>
                  </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between">
                  <span>Tạm tính</span>
                  <strong><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <span>Phí vận chuyển</span>
                  <strong><?php echo number_format($shipping_fee, 0, ',', '.'); ?> đ</strong>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <span>Tổng</span>
                  <strong class="text-danger fs-5">
                    <?php echo number_format($total_amount, 0, ',', '.'); ?> đ
                  </strong>
                </li>
              </ul>

              <!-- Payment Method -->
              <div class="mb-3">
                <label class="form-label">Phương thức thanh toán</label>
                <select name="payment_method" class="form-select">
                  <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                </select>
              </div>

              <!-- Hidden fields -->
              <input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
              <input type="hidden" name="shipping_fee" value="<?php echo $shipping_fee; ?>">
              <input type="hidden" name="tax_amount" value="<?php echo $tax_amount; ?>">
              <input type="hidden" name="discount_amount" value="<?php echo $discount_amount; ?>">
              <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">

              <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill mt-3">
                Đặt hàng ngay
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

<?php include 'views/client/layouts/footer.php'; ?>
