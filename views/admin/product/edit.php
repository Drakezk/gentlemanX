<?php include 'views/admin/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/create.css') ?>">

<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <!-- Header -->
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h3 class="mb-0 fw-bold">
        <i class="fas fa-pen-to-square me-2"></i> Sửa sản phẩm
      </h3>
      <a href="<?php echo Helper::url('admin/product/index'); ?>" 
         class="btn btn-light btn-sm fw-semibold rounded-pill shadow-sm d-flex align-items-center gap-2">
        <i class="fas fa-arrow-left"></i> Quay lại
      </a>
    </div>

    <!-- Body -->
    <div class="card-body">
      <form method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Tên sản phẩm <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control rounded-3" value="<?php echo Helper::e($product['name']); ?>" required>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Slug</label>
            <input type="text" name="slug" class="form-control rounded-3" value="<?php echo Helper::e($product['slug']); ?>">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Mã SKU</label>
            <input type="text" name="sku" class="form-control rounded-3" value="<?php echo Helper::e($product['sku']); ?>">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Danh mục (category_id)</label>
            <input type="number" name="category_id" class="form-control rounded-3" value="<?php echo $product['category_id']; ?>">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Thương hiệu (brand_id)</label>
            <input type="number" name="brand_id" class="form-control rounded-3" value="<?php echo $product['brand_id']; ?>">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Giá bán</label>
            <input type="number" name="price" class="form-control rounded-3" value="<?php echo $product['price']; ?>">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Giá gốc</label>
            <input type="number" name="compare_price" class="form-control rounded-3" value="<?php echo $product['compare_price']; ?>">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Tồn kho</label>
            <input type="number" name="stock_quantity" class="form-control rounded-3" value="<?php echo $product['stock_quantity']; ?>">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Trạng thái</label>
            <select name="status" class="form-select rounded-3">
              <option value="active" <?php echo $product['status']=='active'?'selected':''; ?>>Hoạt động</option>
              <option value="inactive" <?php echo $product['status']=='inactive'?'selected':''; ?>>Ẩn</option>
            </select>
          </div>
          <div class="col-md-3 d-flex align-items-center">
            <div class="form-check mt-4">
              <input class="form-check-input" type="checkbox" name="is_featured" value="1" <?php echo $product['is_featured'] ? 'checked' : ''; ?>>
              <label class="form-check-label fw-semibold">Nổi bật</label>
            </div>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Ảnh đại diện hiện tại</label><br>
            <?php if ($product['featured_image']): ?>
              <img src="<?php echo UPLOAD_URL . $product['featured_image']; ?>" class="rounded shadow-sm mb-2" style="height:60px;">
            <?php else: ?>
              <p class="text-muted fst-italic">Chưa có ảnh</p>
            <?php endif; ?>
            <input type="file" name="featured_image" class="form-control mt-2 rounded-3">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Gallery hiện tại</label><br>
          <?php $gallery = json_decode($product['gallery'], true); ?>
          <?php if (!empty($gallery)): ?>
            <?php foreach ($gallery as $img): ?>
              <img src="<?php echo UPLOAD_URL . $img; ?>" class="rounded shadow-sm me-1 mb-1" style="height:60px;">
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-muted fst-italic">Chưa có gallery</p>
          <?php endif; ?>
          <input type="file" name="gallery[]" class="form-control mt-2 rounded-3" multiple>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Mô tả ngắn</label>
          <textarea name="short_description" class="form-control rounded-3" rows="2"><?php echo Helper::e($product['short_description']); ?></textarea>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Mô tả chi tiết</label>
          <textarea name="description" class="form-control rounded-3" rows="4"><?php echo Helper::e($product['description']); ?></textarea>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-success fw-semibold rounded-pill px-4 shadow-sm">
            <i class="fas fa-save me-1"></i> Cập nhật
          </button>
          <a href="<?php echo Helper::url('admin/product/index'); ?>" class="btn btn-secondary fw-semibold rounded-pill px-4 shadow-sm">
            <i class="fas fa-times me-1"></i> Hủy
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'views/admin/layouts/footer.php'; ?>
