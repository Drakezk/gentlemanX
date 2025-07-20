<?php include 'views/client/layouts/header.php'; ?>

<section class="product-listing py-5">
  <div class="container">
    <h1 class="text-center mb-4 fw-bold">Tất cả sản phẩm</h1>

    <!-- Bộ lọc & sắp xếp (tùy chọn) -->
    <div class="row mb-4">
      <div class="col-md-3">
        <!-- Bộ lọc theo danh mục -->
        <form method="GET" action="">
          <div class="mb-3">
            <label class="form-label fw-semibold">Danh mục</label>
            <select name="category" class="form-select" onchange="this.form.submit()">
              <option value="">Tất cả</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['slug']; ?>" 
                  <?php echo (isset($_GET['category']) && $_GET['category']==$category['slug']) ? 'selected' : ''; ?>>
                  <?php echo Helper::e($category['name']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
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

<style>
  .wishlist-btn {
    width: 42px;
    height: 42px;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(4px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
    text-decoration: none;
    color: #dc3545; /* màu đỏ mặc định */
}

.wishlist-btn:hover {
    background: #dc3545;
    color: #fff;
    transform: scale(1.1);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

/* Nếu muốn trạng thái đã yêu thích thì thêm class active */
.wishlist-btn.active {
    background: #dc3545;
    color: #fff;
}
.wishlist-btn.active:hover {
    background: #b52d3a;
}
</style>
<?php include 'views/client/layouts/footer.php'; ?>
