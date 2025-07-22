<?php include 'views/client/layouts/header.php'; ?>

<section class="cart-section py-5">
  <div class="container">
    <h1 class="fw-bold mb-4">Giỏ hàng của bạn</h1>

    <?php if (!empty($items)): ?>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead class="table-light">
            <tr>
              <th>Sản phẩm</th>
              <th width="150">Số lượng</th>
              <th width="150">Giá</th>
              <th width="100">Xóa</th>
            </tr>
          </thead>
          <tbody>
            <?php $total = 0; foreach ($items as $item): ?>
              <?php $total += $item['price'] * $item['quantity']; ?>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="<?php echo Helper::upload($item['featured_image']); ?>" alt="<?php echo Helper::e($item['name']); ?>" style="width:60px;height:60px;object-fit:cover;" class="me-3 rounded">
                    <a href="<?php echo Helper::url('product/'.$item['slug']); ?>" class="text-decoration-none">
                      <?php echo Helper::e($item['name']); ?>
                    </a>
                  </div>
                </td>
                <td>
                  <form method="POST" action="<?php echo Helper::url('cart/update'); ?>" class="d-flex align-items-center">
                    <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control form-control-sm me-2" style="width:70px;">
                    <button class="btn btn-sm btn-outline-primary"><i class="fas fa-sync"></i></button>
                  </form>
                </td>
                <td>
                  <strong class="text-danger"><?php echo Helper::formatMoney($item['price'] * $item['quantity']); ?></strong>
                </td>
                <td>
                  <a href="<?php echo Helper::url('cart/remove/'.$item['id']); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa sản phẩm này khỏi giỏ?');">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2" class="text-end fw-bold">Tổng tiền:</td>
              <td class="fw-bold text-danger h5"><?php echo Helper::formatMoney($total); ?></td>             
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="d-flex justify-content-end mt-4">
        <a href="<?php echo Helper::url('checkout'); ?>" class="btn btn-lg btn-success">
          <i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán
        </a>
      </div>

    <?php else: ?>
      <div class="text-center py-5">
        <img src="<?php echo Helper::asset('images/empty-shopping-cart.jpg'); ?>" alt="Empty" class="mb-4" style="max-width:500px;">
        <h4 class="fw-semibold mb-3">Giỏ hàng của bạn đang trống</h4>
        <p class="text-muted mb-4">Hãy tìm kiếm và thêm sản phẩm để mua sắm nhé!</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php include 'views/client/layouts/footer.php'; ?>
