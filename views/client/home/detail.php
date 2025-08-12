<?php include 'views/client/layouts/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="<?php echo Helper::asset('css/detail.css') ?>">

<?php $isLoggedIn = !empty($_SESSION['user']); ?>

<section class="product-detail py-5 bg-light">
  <div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb bg-body-tertiary p-3 rounded-3 shadow-sm align-items-center">
        <li class="breadcrumb-item"><a href="<?php echo Helper::url(''); ?>">Trang chủ</a></li>
        <?php if (!empty($breadcrumb)): ?>
          <?php foreach ($breadcrumb as $item): ?>
            <li class="breadcrumb-item">
              <a href="<?php echo $categoryName; ?>">
                <?php echo Helper::e($item['name']); ?>
              </a>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
        <li class="breadcrumb-item active fw-semibold text-primary" aria-current="page">
          <?php echo Helper::e($product['name']); ?>
        </li>
      </ol>
    </nav>

    <div class="row g-5">
      <!-- Hình ảnh -->
      <div class="col-md-6">
        <div class="row g-3">
          <!-- Cột trái: Thư viện ảnh -->
          <div class="col-2 d-flex flex-column align-items-start gap-3">
            <?php 
              $galleryImages = !empty($product['gallery']) ? json_decode($product['gallery'], true) : [];
              if (!empty($galleryImages)): 
                $count = 0;
                foreach ($galleryImages as $img):
                  if ($count >= 3) break;
                  $count++;
            ?>
              <div class="thumb-img border rounded-3 overflow-hidden shadow-sm">
                <img src="<?php echo Helper::upload($img); ?>" 
                    class="img-fluid"
                    style="width:60px;height:60px;object-fit:cover;cursor:pointer;"
                    alt="Gallery image"
                    onclick="document.querySelector('.product-main-img').src=this.src">
              </div>
            <?php endforeach; endif; ?>
          </div>

          <!-- Cột phải: Hình ảnh chính -->
          <div class="col-10">
            <div class="main-image border rounded-4 overflow-hidden shadow-sm position-relative mb-4">
              <?php if (!empty($product['featured_image'])): ?>
                <img src="<?php echo Helper::upload($product['featured_image']); ?>" 
                    alt="<?php echo Helper::e($product['name']); ?>" 
                    class="img-fluid w-100 product-main-img">
              <?php else: ?>
                <div class="bg-light d-flex align-items-center justify-content-center" style="height:350px;">
                  <i class="fas fa-image fa-3x text-muted"></i>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>


      <!-- Thông tin sản phẩm -->
      <div class="col-md-6">
        <h1 class="fw-bold mb-3 display-5"><?php echo Helper::e($product['name']); ?></h1>
        <p class="text-muted mb-4 fs-6"><?php echo Helper::e($product['short_description']); ?></p>

        <div class="mb-4 d-flex align-items-center gap-3">
          <span class="h3 fw-bold text-danger"><?php echo Helper::formatMoney($product['price']); ?></span>
          <?php if ($product['compare_price'] > $product['price']): ?>
            <small class="text-muted text-decoration-line-through fs-6">
              <?php echo Helper::formatMoney($product['compare_price']); ?>
            </small>
          <?php endif; ?>
        </div>

        <div class="mb-3">
          <i class="fas fa-box text-muted me-1"></i>
          <?php if ($stockQuantity > 20): ?>
            <span class="px-2 py-1 rounded-pill text-white fw-semibold" style="background: linear-gradient(45deg, #28a745, #5dd39e);">
              Sẵn hàng – giao ngay
            </span>
          <?php elseif ($stockQuantity > 0): ?>
            <span class="px-2 py-1 rounded-pill text-white fw-semibold" style="background: linear-gradient(45deg, #ff6a00, #ff9800);">
              Sắp hết! Chỉ còn <?php echo $stockQuantity; ?> sản phẩm
            </span>
          <?php else: ?>
            <span class="px-2 py-1 rounded-pill text-white fw-semibold" style="background: linear-gradient(45deg, #dc3545, #ff5f6d);">
                Tạm hết hàng – sẽ có lại sớm
            </span>
          <?php endif; ?>
        </div>

        <div class="mb-3">
          <span class="fw-semibold">Danh mục:</span>
          <a href="<?php echo Helper::url('product?category=' . $product['category_slug']); ?>" class="text-decoration-none text-primary fw-medium">
            <?php echo Helper::e($product['category_name']); ?>
          </a>
        </div>

        <?php if (!empty($product['brand_name'])): ?>
          <div class="mb-4">
            <span class="fw-semibold">Thương hiệu:</span>
            <span class="text-dark"><?php echo Helper::e($product['brand_name']); ?></span>
          </div>
        <?php endif; ?>

        <div class="d-grid gap-2">
          <?php if (!empty($_SESSION['user'])): ?>
            <form method="POST" action="<?php echo Helper::url('cart/add'); ?>" class="m-0">
              <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
              <div class="mb-4">
                <label for="quantity" class="form-label fw-semibold">Số lượng</label>
                <div class="input-group" style="max-width: 160px;">
                  <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty()">
                    <i class="bi bi-dash"></i>
                  </button>
                  <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    value="1"
                    min="1"
                    class="form-control text-center fw-bold"
                    style="min-width: 60px;"
                    required
                  >
                  <button type="button" class="btn btn-outline-secondary" onclick="increaseQty()">
                    <i class="bi bi-plus"></i>
                  </button>
                </div>
              </div>
              <button class="btn btn-lg btn-gradient rounded-pill w-100">
                <i class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ hàng
              </button>
            </form>
          <?php else: ?>
            <!-- Chưa login, click sẽ đưa sang login -->
            <a href="<?php echo Helper::url('auth/login'); ?>"
              class="btn btn-lg btn-gradient rounded-pill w-100">
              <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập để mua
            </a>
          <?php endif; ?>
        </div>

        <div class="pt-4 mt-5 border-top">
          <div class="accordion" id="accordionDescription">
            <div class="accordion-item border-0">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-semibold bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDescription" aria-expanded="false" aria-controls="collapseDescription">
                  <i class="bi bi-info-circle me-2 text-primary"></i> Chi tiết sản phẩm
                </button>
              </h2>
              <div id="collapseDescription" class="accordion-collapse collapse" data-bs-parent="#accordionDescription">
                <div class="accordion-body text-secondary" style="line-height: 1.8;">
                  <?php echo nl2br(Helper::e($product['description'])); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Đánh giá sản phẩm -->
    <hr class="my-5">
    <div class="reviews">
      <h3 class="fw-bold mb-4">
        <i class="fas fa-comments text-primary me-2"></i> Đánh giá sản phẩm
      </h3>
        <div class="card shadow-sm mb-5">
          <div class="card-body">
            <h5 class="fw-bold mb-3">Gửi đánh giá của bạn</h5>
            <form action="<?php echo Helper::url('review/submit/' . $product['slug']); ?>" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

              <div class="mb-3">
                <label class="form-label fw-semibold">Tiêu đề</label>
                <input type="text" name="title" class="form-control" placeholder="Tiêu đề ngắn gọn">
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Đánh giá</label>
                <textarea name="comment" class="form-control" rows="4" placeholder="Viết đánh giá của bạn..."></textarea>
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">Số sao</label>
                <div class="star-rating d-flex gap-1">
                  <?php for ($i = 1; $i <= 5; $i++): ?>
                    <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" class="d-none star-input">
                    <label for="star<?= $i ?>" class="star-icon" data-index="<?= $i ?>">
                      <i class="fas fa-star"></i>
                    </label>
                  <?php endfor; ?>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Hình ảnh (tối đa 3)</label>
                <input type="file" name="images[]" multiple class="form-control">
              </div>

              <button type="submit" class="btn btn-primary rounded-pill">
                <i class="fas fa-paper-plane me-2"></i> Gửi đánh giá
              </button>
            </form>
          </div>
        </div>

      <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $review): ?>
          <div class="card mb-3 review-card rounded-4">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-2">
                <div>
                  <strong><?php echo htmlspecialchars($review['user_name']); ?></strong>
                  <span class="text-muted small ms-2"><?php echo date('d/m/Y', strtotime($review['created_at'])); ?></span>
                </div>
                <div class="text-warning">
                  <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="fas fa-star<?php echo $i <= $review['rating'] ? '' : '-o'; ?>"></i>
                  <?php endfor; ?>
                </div>
              </div>
              <h6 class="fw-semibold"><?php echo htmlspecialchars($review['title']); ?></h6>
              <p class="mb-2"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>

              <?php 
                $images = json_decode($review['images'], true) ?? []; 
                if (!empty($images) && is_array($images)):
              ?>
                <div class="d-flex flex-wrap gap-2">
                  <?php foreach ($images as $img): ?>
                    <img src="<?php echo Helper::upload($img); ?>" alt="Ảnh đánh giá" class="rounded shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
      <?php endif; ?>
    </div>

    <!-- Sản phẩm liên quan -->
    <?php if (!empty($relatedProducts)): ?>
      <hr class="my-5">
      <h3 class="fw-bold mb-4">Sản phẩm liên quan</h3>
      <div class="row g-4">
        <?php foreach ($relatedProducts as $item): ?>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card hover-shadow">
              <div class="position-relative">
                <?php if ($item['featured_image']): ?>
                  <img src="<?php echo Helper::upload($item['featured_image']); ?>" 
                       class="card-img-top"
                       alt="<?php echo Helper::e($item['name']); ?>" 
                       style="height:220px;object-fit:cover;">
                <?php else: ?>
                  <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:220px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                  </div>
                <?php endif; ?>
                <?php if ($item['compare_price'] > $item['price']): ?>
                  <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-3 py-2">Sale</span>
                <?php endif; ?>
              </div>
              <div class="card-body d-flex flex-column">
                <h6 class="card-title mb-2">
                  <a href="<?php echo Helper::url('product/' . $item['slug']); ?>" class="text-decoration-none fw-semibold text-dark">
                    <?php echo Helper::e($item['name']); ?>
                  </a>
                </h6>
                <div class="price-section mb-3">
                  <span class="fw-bold text-primary"><?php echo Helper::formatMoney($item['price']); ?></span>
                  <?php if ($item['compare_price'] > $item['price']): ?>
                    <small class="text-muted text-decoration-line-through ms-2">
                      <?php echo Helper::formatMoney($item['compare_price']); ?>
                    </small>
                  <?php endif; ?>
                </div>
                <div class="mt-auto">
                  <a href="<?php echo Helper::url('product/' . $item['slug']); ?>" class="btn btn-outline-primary rounded-pill w-100">
                    Xem chi tiết
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php
$types = ['error' => 'danger', 'success' => 'success'];
foreach ($types as $key => $color):
  if (!empty($_SESSION[$key])):
?>
  <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div class="toast align-items-center text-bg-<?php echo $color; ?> border-0 show shadow" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          <?php if ($key === 'success'): ?>
            <i class="fas fa-check-circle me-2"></i>
          <?php elseif ($key === 'error'): ?>
            <i class="fas fa-exclamation-circle me-2"></i>
          <?php endif; ?>
          <?php echo $_SESSION[$key]; ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
<?php
    unset($_SESSION[$key]);
  endif;
endforeach;
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  window.isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
  window.loginUrl = '<?php echo Helper::url("auth/showLogin"); ?>';
</script>
<script src="<?php echo Helper::asset('js/detail.js'); ?>"></script>
<script>
  function increaseQty() {
    let qty = document.getElementById('quantity');
    qty.value = parseInt(qty.value) + 1;
  }

  function decreaseQty() {
    let qty = document.getElementById('quantity');
    if (parseInt(qty.value) > 1) {
      qty.value = parseInt(qty.value) - 1;
    }
  }
</script>

<?php include 'views/client/layouts/footer.php'; ?>