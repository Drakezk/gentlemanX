<?php include 'views/client/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/list.css') ?>">

<section class="product-listing py-5">
  <div class="container">
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb justify-content-center bg-body-tertiary p-2 rounded-3 shadow-sm align-items-center">
        <li class="breadcrumb-item">
          <a href="<?php echo Helper::url(); ?>" class="text-decoration-none text-dark fw-medium">
            <i class="bi bi-house-door-fill me-1"></i>Trang chủ
          </a>
        </li>
        <li class="breadcrumb-item active fw-semibold text-primary" aria-current="page">
          <?php echo $categoryName; ?>
        </li>
      </ol>
    </nav>

    <!-- Bộ lọc & sắp xếp (tùy chọn) -->
    <div class="row mb-4">
      <div class="col-md-3">
        <!-- Bộ lọc theo khoảng giá -->
        <form method="GET" action="" class="mb-3">
          <?php if(isset($_GET['category'])): ?>
            <input type="hidden" name="category" value="<?php echo $_GET['category']; ?>">
          <?php endif; ?>
          <?php if(isset($_GET['sort'])): ?>
            <input type="hidden" name="sort" value="<?php echo $_GET['sort']; ?>">
          <?php endif; ?>

          <label class="form-label fw-semibold">Khoảng giá</label>
          <select name="price_range" class="form-select" onchange="this.form.submit()">
            <option value="">Tất cả</option>
            <option value="under_500" <?php if(@$_GET['price_range']=='under_500') echo 'selected'; ?>>Dưới 500k</option>
            <option value="500_1000" <?php if(@$_GET['price_range']=='500_1000') echo 'selected'; ?>>500k - 1tr</option>
            <option value="1000_2000" <?php if(@$_GET['price_range']=='1000_2000') echo 'selected'; ?>>1tr - 2tr</option>
            <option value="above_2000" <?php if(@$_GET['price_range']=='above_2000') echo 'selected'; ?>>Trên 2tr</option>
          </select>
        </form>

      </div>

      <div class="col-md-9 d-flex justify-content-end">
        <!-- Sắp xếp -->
        <form method="GET" class="d-flex align-items-center">
          <?php if(isset($_GET['category'])): ?>
            <input type="hidden" name="category" value="<?php echo $_GET['category']; ?>">
          <?php endif; ?>
          <label class="me-2">Sắp xếp:</label>
          <select name="sort" class="form-select w-auto" onchange="this.form.submit()">
            <option value="">Mặc định</option>
            <option value="price_asc" <?php if(@$_GET['sort']=='price_asc') echo 'selected'; ?>>Giá tăng dần</option>
            <option value="price_desc" <?php if(@$_GET['sort']=='price_desc') echo 'selected'; ?>>Giá giảm dần</option>
            <option value="newest" <?php if(@$_GET['sort']=='newest') echo 'selected'; ?>>Mới nhất</option>
          </select>
        </form>
      </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="row">
      <?php if (!empty($products)): ?>
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
                  <span class="h6 fw-bold text-primary"><?php echo Helper::formatMoney($product['price']); ?></span>
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
      <?php else: ?>
        <div class="col-12">
          <p class="text-center text-muted">Chưa có sản phẩm nào phù hợp.</p>
        </div>
      <?php endif; ?>
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center mt-4">
      <?php echo $pagination ?? ''; ?>
    </div>
  </div>
</section>

<?php include 'views/client/layouts/footer.php'; ?>
