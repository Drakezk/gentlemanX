<?php include 'views/client/layouts/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">
                    Khẳng định đẳng cấp cùng <span class="text-warning">Gentleman-X</span>
                </h1>
                <p class="lead mb-4">
                    BST mới 2024 – Chất liệu cao cấp, thiết kế lịch lãm, ưu đãi độc quyền dành cho quý ông hiện đại.
                </p>
                <a href="<?php echo Helper::url('product') ?>" 
                    class="btn btn-light btn-lg px-4 py-2 rounded-pill fw-semibold shadow-sm d-inline-flex align-items-center gap-2 border border-dark text-dark text-decoration-none"
                    style="transition: all 0.3s ease;" 
                    onmouseover="this.style.boxShadow='0 6px 14px rgba(0,0,0,0.1)'; this.style.transform='translateY(-2px)'"
                    onmouseout="this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)'; this.style.transform='none'">
                    Khám phá ngay <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="col-lg-6">
                <img src="<?php echo Helper::asset('images/banner.jpg') ?>" 
                     alt="Banner GentlemanX" class="img-fluid rounded-4 shadow">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<?php if (!empty($categories)): ?>
<section class="categories-section py-5">
    <div class="container">
        <h2 class="text-center mb-2 fw-bold">Danh mục sản phẩm</h2>
        <p class="text-center text-muted mb-4">Khám phá phong cách quý ông từ những sản phẩm chủ đạo</p>
        <div class="row">
            <?php foreach ($categories as $category): ?>
                <div class="col-md-3 mb-4">
                    <div class="card category-card h-100 text-center">
                        <div class="card-body">
                            <?php if ($category['image']): ?>
                                <img src="<?php echo Helper::upload($category['image']) ?>" 
                                     alt="<?php echo Helper::e($category['name']) ?>" 
                                     class="img-fluid mb-3" style="height: 80px; object-fit: contain;">
                            <?php else: ?>
                                <i class="fas fa-folder fa-3x text-primary mb-3"></i>
                            <?php endif; ?>
                            <h5 class="card-title"><?php echo Helper::e($category['name']) ?></h5>
                            <p class="card-text text-muted">
                                <?php echo Helper::truncate($category['description'], 80) ?>
                            </p>
                            <a href="<?php echo Helper::url('category/' . $category['slug']) ?>" 
                               class="btn btn-outline-primary">
                                Xem sản phẩm
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Featured Products -->
<?php if (!empty($featuredProducts)): ?>
<section class="featured-products py-5 bg-light">
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
            <a href="<?php echo Helper::url('product') ?>" class="btn btn-outline-primary btn-lg">
                Xem tất cả sản phẩm
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Latest Products -->
<?php if (!empty($latestProducts)): ?>
<section class="latest-products py-5">
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

<?php include 'views/client/layouts/footer.php'; ?>
