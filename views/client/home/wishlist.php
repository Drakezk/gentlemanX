<?php include 'views/client/layouts/header.php'; ?>

<section class="py-5 bg-light">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h1 class="fw-bold display-6 mb-1">Danh sách yêu thích</h1>
        <p class="text-muted mb-0">Theo dõi những sản phẩm bạn quan tâm nhất</p>
      </div>
    </div>

    <?php if (!empty($items)): ?>
      <div class="row g-4">
        <?php foreach ($items as $item): ?>
          <div class="col-6 col-md-4 col-lg-3">
            <div class="card wishlist-card border-0 shadow-sm h-100 rounded-4 overflow-hidden position-relative">
              
              <!-- Nút Xóa nhanh overlay -->
              <a href="<?php echo Helper::url('wishlist/remove/' . $item['product_id']); ?>" 
                 class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-2 shadow-sm remove-btn"
                 title="Xóa khỏi yêu thích">
                <i class="fas fa-times text-danger"></i>
              </a>

              <!-- Ảnh sản phẩm -->
              <?php if (!empty($item['featured_image'])): ?>
                <div class="ratio ratio-4x3 bg-light">
                  <img src="<?php echo Helper::upload($item['featured_image']); ?>" 
                       class="card-img-top object-fit-cover transition-scale"
                       alt="<?php echo htmlspecialchars($item['name']); ?>">
                </div>
              <?php endif; ?>

              <!-- Nội dung -->
              <div class="card-body d-flex flex-column">
                <h6 class="card-title mb-2 fw-semibold text-truncate">
                  <a href="<?php echo Helper::url('product/detail/' . $item['product_id']); ?>" 
                     class="text-decoration-none text-dark hover-primary">
                    <?php echo htmlspecialchars($item['name']); ?>
                  </a>
                </h6>
                <p class="text-danger fw-bold fs-5 mb-3">
                  <?php echo number_format($item['price'], 0, ',', '.'); ?> đ
                </p>
              </div>

              <!-- Footer action: Xóa & Thêm giỏ -->
              <div class="card-footer bg-white border-top-0 pt-0 pb-3 px-3">
                <div class="d-flex justify-content-between gap-2">
                  <a href="<?php echo Helper::url('wishlist/remove/' . $item['product_id']); ?>" 
                     class="btn btn-outline-danger btn-sm rounded-pill flex-fill">
                    <i class="fas fa-trash me-1"></i> Xóa
                  </a>
                  <a href="<?php echo Helper::url('cart/add/' . $item['product_id']); ?>" 
                     class="btn btn-primary btn-sm rounded-pill flex-fill">
                    <i class="fas fa-shopping-cart me-1"></i> Thêm
                  </a>
                </div>
              </div>

            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="text-center py-5">
        <img src="<?php echo Helper::asset('images/empty-state.jpg'); ?>" alt="Empty" class="mb-4" style="max-width:300px;">
        <h4 class="fw-semibold mb-3">Danh sách yêu thích trống</h4>
        <p class="text-muted mb-4">Hãy tìm kiếm và thêm sản phẩm để theo dõi nhé!</p>
        <a href="<?php echo Helper::url('home/productList'); ?>" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">
          <i class="fas fa-store me-2"></i> Xem sản phẩm
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>

<style>
.wishlist-card {
  background: #fff;
  transition: all 0.3s ease;
  border-radius: 1rem;
}
.wishlist-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 1rem 2rem rgba(0,0,0,.08);
}
.wishlist-card .transition-scale {
  transition: transform .4s ease;
}
.wishlist-card:hover .transition-scale {
  transform: scale(1.05);
}
.remove-btn {
  background: rgba(255,255,255,0.9);
  border: none;
}
.hover-primary:hover {
  color: #0d6efd !important;
}
.object-fit-cover {
  object-fit: cover;
}
</style>

<?php include 'views/client/layouts/footer.php'; ?>
