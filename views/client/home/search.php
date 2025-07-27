<?php include 'views/client/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/list.css') ?>">

<section class="product-search py-5">
  <div class="container">
    <h1 class="text-center mb-4 fw-bold">
      Kết quả tìm kiếm cho: 
      <span class="text-primary">"<?php echo Helper::e($keyword); ?>"</span>
    </h1>

    <?php if (!empty($products)): ?>
      <div class="row">
        <?php foreach ($products as $product): ?>
          <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card product-card h-100">
              <div class="position-relative">
                <?php if ($product['featured_image']): ?>
                  <img src="<?php echo Helper::upload($product['featured_image']); ?>" 
                       class="card-img-top" alt="<?php echo Helper::e($product['name']); ?>" 
                       style="height: 200px; object-fit: cover;">
                <?php else: ?>
                  <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                       style="height: 200px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                  </div>
                <?php endif; ?>

                <?php if ($product['compare_price'] > $product['price']): ?>
                  <span class="badge bg-danger position-absolute top-0 start-0 m-2">Sale</span>
                <?php endif; ?>

                <?php if (isset($_SESSION['user'])): ?>
                  <a href="<?php echo Helper::url('wishlist/add/' . $product['id']); ?>" 
                    class="wishlist-btn position-absolute top-0 end-0 m-2"
                    title="Thêm vào yêu thích">
                    <i class="fas fa-heart"></i>
                  </a>
                <?php endif; ?>
              </div>
              <div class="card-body d-flex flex-column">
                <h6 class="card-title">
                  <a href="<?php echo Helper::url('product/' . $product['slug']); ?>" 
                     class="text-decoration-none text-dark">
                    <?php echo Helper::e($product['name']); ?>
                  </a>
                </h6>
                <p class="card-text text-muted small flex-grow-1">
                  <?php echo Helper::truncate($product['short_description'], 60); ?>
                </p>
                <div class="price-section mb-2">
                  <span class="h6 fw-bold text-primary">
                    <?php echo Helper::formatMoney($product['price']); ?>
                  </span>
                  <?php if ($product['compare_price'] > $product['price']): ?>
                    <small class="text-muted text-decoration-line-through ms-2">
                      <?php echo Helper::formatMoney($product['compare_price']); ?>
                    </small>
                  <?php endif; ?>
                </div>
                <div class="d-grid">
                  <a href="<?php echo Helper::url('product/' . $product['slug']); ?>" 
                     class="btn btn-primary">Xem chi tiết</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    <?php else: ?>
      <div class="alert alert-warning text-center">
        Không tìm thấy sản phẩm nào phù hợp với từ khóa 
        <strong>"<?php echo Helper::e($keyword); ?>"</strong>.
      </div>
    <?php endif; ?>

  </div>
</section>

<?php include 'views/client/layouts/footer.php'; ?>
