<?php include 'views/client/layouts/header.php'; ?>

<section class="product-detail py-5 bg-light">
  <div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm">
        <li class="breadcrumb-item"><a href="<?php echo Helper::url(''); ?>">Trang chủ</a></li>
        <?php if (!empty($breadcrumb)): ?>
          <?php foreach ($breadcrumb as $item): ?>
            <li class="breadcrumb-item">
              <a href="<?php echo Helper::url('product?category=' . $item['slug']); ?>">
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

        <div class="mb-4 text-secondary" style="line-height:1.8;">
          <?php echo nl2br(Helper::e($product['description'])); ?>
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
              <button class="btn btn-lg btn-primary rounded-pill shadow-sm hover-scale w-100">
                <i class="fas fa-shopping-cart me-2"></i> Thêm vào giỏ hàng
              </button>
            </form>
          <?php else: ?>
            <!-- Chưa login, click sẽ đưa sang login -->
            <a href="<?php echo Helper::url('auth/login'); ?>"
              class="btn btn-lg btn-primary rounded-pill shadow-sm hover-scale w-100 d-flex align-items-center justify-content-center">
              <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập để mua
            </a>
          <?php endif; ?>
        </div>
      </div>
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

<style>
  .product-main-img {
    transition: transform 0.4s ease;
  }
  .product-main-img:hover {
    transform: scale(1.05);
  }
  .hover-scale {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .hover-scale:hover {
    transform: scale(1.03);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
  }
  .hover-shadow:hover {
    transform: translateY(-3px);
    transition: all 0.3s ease;
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
  }
  .thumb-img {
  transition: all 0.3s ease;
  border: 2px solid transparent;
  }

  .thumb-img:hover {
    transform: scale(1.1);    
    box-shadow: 0 0 10px rgba(13,110,253,0.5);
    cursor: pointer;
  }
</style>

<?php include 'views/client/layouts/footer.php'; ?>
