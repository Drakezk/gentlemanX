<?php include 'views/client/layouts/header.php'; ?>

<section class="py-5 text-center">
  <div class="container">
    <h1 class="mb-4 text-success fw-bold">Đặt hàng thành công!</h1>
    <p class="mb-3">
      Cảm ơn bạn đã mua hàng. Mã đơn hàng của bạn là: 
      <span class="fw-bold text-primary">
        #<?php echo isset($order['id']) ? htmlspecialchars($order['id']) : 'N/A'; ?>
      </span>
    </p>
    <a href="<?php echo Helper::url('home'); ?>" class="btn btn-primary rounded-pill mt-3">
      Tiếp tục mua sắm
    </a>
  </div>
</section>

<?php include 'views/client/layouts/footer.php'; ?>
