<?php include 'views/client/layouts/header.php'; ?>

<section class="py-5">
  <div class="container">
    <!-- Tiêu đề -->
    <h1 class="mb-4 fw-bold">Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($keyword); ?>"</h1>

    <div class="row">
      <!-- Cột bộ lọc -->
      <div class="col-md-3 mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title fw-semibold mb-3">Bộ lọc</h5>
            <form method="GET" action="">
              <input type="hidden" name="q" value="<?php echo htmlspecialchars($keyword); ?>">

              <!-- Lọc theo danh mục -->
              <div class="mb-3">
                <label class="form-label">Danh mục</label>
                <select name="category" class="form-select" onchange="this.form.submit()">
                  <option value="">Tất cả</option>
                  <?php foreach($this->categoryModel->all() as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>"
                      <?php echo (isset($filters['category_id']) && $filters['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Lọc theo thương hiệu -->
              <div class="mb-3">
                <label class="form-label">Thương hiệu</label>
                <select name="brand" class="form-select" onchange="this.form.submit()">
                  <option value="">Tất cả</option>
                  <?php foreach($this->brandModel->all() as $brand): ?>
                    <option value="<?php echo $brand['id']; ?>"
                      <?php echo (isset($filters['brand_id']) && $filters['brand_id'] == $brand['id']) ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars($brand['name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Nút áp dụng nếu muốn -->
              <button type="submit" class="btn btn-primary w-100">Áp dụng</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Cột sản phẩm -->
      <div class="col-md-9">
        <?php if (!empty($products)): ?>
          <div class="row g-3">
            <?php foreach($products as $product): ?>
              <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                  <img src="<?php echo Helper::asset('uploads/'.$product['thumbnail']); ?>"
                       class="card-img-top"
                       alt="<?php echo htmlspecialchars($product['name']); ?>">
                  <div class="card-body d-flex flex-column">
                    <h6 class="card-title fw-semibold mb-2">
                      <?php echo htmlspecialchars($product['name']); ?>
                    </h6>
                    <p class="card-text text-muted small mb-2">
                      <?php echo htmlspecialchars($product['short_description']); ?>
                    </p>
                    <div class="mt-auto">
                      <p class="fw-bold text-danger mb-2">
                        <?php echo number_format($product['price']); ?> đ
                      </p>
                      <a href="<?php echo Helper::url('product/detail/'.$product['id']); ?>"
                         class="btn btn-outline-primary btn-sm w-100">
                        Xem chi tiết
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- Phân trang -->
          <?php if ($pagination['last_page'] > 1): ?>
            <nav class="mt-4">
              <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $pagination['last_page']; $i++): ?>
                  <li class="page-item <?php echo ($i == $pagination['current_page']) ? 'active' : ''; ?>">
                    <a class="page-link"
                       href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>">
                       <?php echo $i; ?>
                    </a>
                  </li>
                <?php endfor; ?>
              </ul>
            </nav>
          <?php endif; ?>

        <?php else: ?>
          <div class="alert alert-warning">
            Không tìm thấy sản phẩm nào phù hợp.
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php include 'views/client/layouts/footer.php'; ?>
