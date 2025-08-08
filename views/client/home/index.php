<?php include 'views/client/layouts/header.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="<?php echo Helper::asset('css/index.css') ?>">

<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">
                  Khẳng định đẳng cấp cùng <span class="brand-highlight">Gentleman-X</span>
                </h1>
                <p class="lead mb-4">
                  BST mới 2025 – Chất liệu cao cấp, thiết kế lịch lãm, ưu đãi độc quyền dành cho quý ông hiện đại.
                </p>
                <a href="<?php echo Helper::url('home/productList') ?>" class="btn btn-light btn-lg rounded-pill">
                  Khám phá ngay
                </a>
            </div>
            <div class="col-lg-6">
                <img src="<?php echo Helper::asset('images/banner.jpg') ?>" 
                     alt="Banner GentlemanX" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>
</section>

<!-- Service Highlights -->
<section class="service-highlights py-4 bg-white">
  <div class="container">
    <div class="row g-3">
      <!-- Item 1 -->
      <div class="col-md-3 col-6 wow animate__animated animate__fadeInUp" data-wow-delay="0.1s">
        <div class="service-box p-3 text-center h-100">
          <i class="fas fa-shipping-fast fa-2x mb-2"></i>
          <p class="mb-0 small">
            Vận chuyển <strong>MIỄN PHÍ</strong><br>
            Trong khu vực <strong>TP. HA NOI</strong>
          </p>
        </div>
      </div>
      <!-- Item 2 -->
      <div class="col-md-3 col-6 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
        <div class="service-box p-3 text-center h-100">
          <i class="fas fa-id-card fa-2x mb-2"></i>
          <p class="mb-0 small">
            Tích điểm Nâng hạng<br>
            <strong>THẺ THÀNH VIÊN</strong>
          </p>
        </div>
      </div>
      <!-- Item 3 -->
      <div class="col-md-3 col-6 wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
        <div class="service-box p-3 text-center h-100">
          <i class="fas fa-credit-card fa-2x mb-2"></i>
          <p class="mb-0 small">
            Tiến hành <strong>THANH TOÁN</strong><br>
            Với nhiều <strong>PHƯƠNG THỨC</strong>
          </p>
        </div>
      </div>
      <!-- Item 4 -->
      <div class="col-md-3 col-6 wow animate__animated animate__fadeInUp" data-wow-delay="0.4s">
        <div class="service-box p-3 text-center h-100">
          <i class="fas fa-undo fa-2x mb-2"></i>
          <p class="mb-0 small">
            <strong>100% HOÀN TIỀN</strong><br>
            nếu sản phẩm lỗi
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Sub Banners -->
<section class="sub-banners py-5 fade-up">
  <div class="container">
    <div class="row g-4">
      <!-- Banner 1 -->
      <div class="col-md-6">
        <div class="banner-item position-relative overflow-hidden rounded-4 shadow-sm">
          <img src="<?php echo Helper::asset('images/banner-phu-1.jpg') ?>" class="img-fluid w-100" alt="BST Thu Đông">
          <div class="banner-overlay d-flex flex-column justify-content-center align-items-start p-4">
            <h3 class="text-white fw-bold mb-2">BST Thu Đông 2025</h3>
            <p class="text-white-50 mb-3">Khám phá phong cách ấm áp & lịch lãm</p>
            <a href="<?php echo Helper::url('home/productList') ?>" class="btn btn-light btn-sm rounded-pill fw-semibold">
              Khám phá ngay
            </a>
          </div>
        </div>
      </div>
      <!-- Banner 2 -->
      <div class="col-md-6">
        <div class="banner-item position-relative overflow-hidden rounded-4 shadow-sm">
          <img src="<?php echo Helper::asset('images/banner-phu-2.jpg') ?>" class="img-fluid w-100" alt="Ưu đãi đặc biệt">
          <div class="banner-overlay d-flex flex-column justify-content-center align-items-start p-4">
            <h3 class="text-white fw-bold mb-2">Xu hướng Xuân Hè 2025</h3>
            <p class="text-white-50 mb-3">Phong cách trẻ trung, năng động</p>
            <a href="<?php echo Helper::url('home/productList') ?>" class="btn btn-light btn-sm rounded-pill fw-semibold">
              Khám phá ngay
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Featured Products -->
<?php if (!empty($featuredProducts)): ?>
<section class="featured-products py-5 bg-light fade-up">
    <div class="container">
        <h2 class="text-center mb-5">Sản phẩm nổi bật</h2>
        <div class="row">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <?php if ($product['featured_image']): ?>
                                <img src="<?php echo Helper::upload($product['featured_image']) ?>" 
                                     class="card-img-top" alt="<?php echo Helper::e($product['name']) ?>"
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
                                <a href="<?php echo Helper::url('product/' . $product['slug']) ?>" 
                                   class="text-decoration-none text-dark">
                                    <?php echo Helper::e($product['name']) ?>
                                </a>
                            </h6>
                            <p class="card-text text-muted small flex-grow-1">
                                <?php echo Helper::truncate($product['short_description'], 60) ?>
                            </p>
                            <div class="price-section mb-2">
                                <span class="h6 fw-bold text-primary"><?php echo Helper::formatMoney($product['price']) ?></span>
                                <?php if ($product['compare_price'] > $product['price']): ?>
                                    <small class="text-muted text-decoration-line-through ms-2">
                                        <?php echo Helper::formatMoney($product['compare_price']) ?>
                                    </small>
                                    <span class="badge bg-danger ms-2">-
                                        <?= round(100 - ($product['price'] / $product['compare_price']) * 100) ?>%
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="d-grid">
                                <a href="<?php echo Helper::url('product/' . $product['slug']) ?>" 
                                   class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo Helper::url('home/productList') ?>" class="btn btn-outline-primary btn-lg">
                Xem tất cả sản phẩm
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Banner Trên Sản Phẩm Mới Nhất -->
<section class="full-banner position-relative my-5 rounded-4 overflow-hidden shadow-lg fade-up">
  <div class="banner-wrapper">
    <img src="<?php echo Helper::asset('images/banner-uu_dai.jpg') ?>" 
         alt="Ưu đãi đặc biệt" class="img-fluid w-100 banner-bg">
    <div class="banner-overlay"></div>
    <div class="banner-content position-absolute top-50 start-50 translate-middle text-center text-white p-4">
      <h2 class="display-5 fw-bold mb-3">✨ Ưu Đãi Đặc Biệt Tháng Này ✨</h2>
      <p class="lead mb-4">
        Sở hữu phong cách quý ông với BST mới nhất, ưu đãi lên tới <strong>-40%</strong>!
      </p>
      <a href="<?php echo Helper::url('home/productList') ?>" class="banner-btn">
        Khám phá ngay <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>
</section>


<!-- Latest Products -->
<?php if (!empty($latestProducts)): ?>
<section class="latest-products py-5 fade-up">
    <div class="container">
        <h2 class="text-center mb-5">Sản phẩm mới nhất</h2>
        <div class="row">
            <?php foreach ($latestProducts as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <?php if ($product['featured_image']): ?>
                                <img src="<?php echo Helper::upload($product['featured_image']) ?>" 
                                     class="card-img-top" alt="<?php echo Helper::e($product['name']) ?>"
                                     style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['user'])): ?>
                                <a href="<?php echo Helper::url('wishlist/add/' . $product['id']); ?>" 
                                class="wishlist-btn position-absolute top-0 end-0 m-2"
                                title="Thêm vào yêu thích">
                                    <i class="fas fa-heart"></i>
                                </a>
                            <?php endif; ?>
                            <span class="badge bg-success position-absolute top-0 start-0 m-2">Mới</span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">
                                <a href="<?php echo Helper::url('product/' . $product['slug']) ?>" 
                                   class="text-decoration-none text-dark">
                                    <?php echo Helper::e($product['name']) ?>
                                </a>
                            </h6>
                            <p class="card-text text-muted small flex-grow-1">
                                <?php echo Helper::truncate($product['short_description'], 60) ?>
                            </p>
                            <div class="price-section mb-3">
                                <span class="h6 text-primary fw-bold">
                                    <?php echo Helper::formatMoney($product['price']) ?>
                                </span>
                            </div>
                            <div class="d-grid">
                                <a href="<?php echo Helper::url('product/' . $product['slug']) ?>" 
                                   class="btn btn-primary">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
  <div id="flashToast" class="toast align-items-center text-bg-success border-0" 
       role="alert" data-bs-autohide="true" data-bs-delay="3000">
    <div class="d-flex">
      <div class="toast-body">
        <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['success']; ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var toastEl = document.getElementById('flashToast');
    if (toastEl) {
      var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
      toast.show(); // Hiển thị toast và tự ẩn sau delay
    }
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
  new WOW().init();
</script>
<script src="<?php echo Helper::asset('js/index.js'); ?>"></script>

<?php include 'views/client/layouts/footer.php'; ?>
