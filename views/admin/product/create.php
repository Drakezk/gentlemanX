<?php include 'views/admin/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/create.css') ?>">

<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <!-- Header -->
    <div class="card-header bg-gradient-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
      <h3 class="mb-0 fw-bold">
        <i class="fas fa-plus-circle me-2"></i>Thêm sản phẩm mới
      </h3>
      <a href="<?php echo Helper::url('admin/product/index'); ?>" 
         class="btn btn-light btn-sm fw-semibold rounded-pill shadow-sm d-flex align-items-center gap-2">
        <i class="fas fa-arrow-left"></i> Quay lại
      </a>
    </div>

    <!-- Body -->
    <div class="card-body">
      <form method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Tên sản phẩm <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control rounded-3" required>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Slug</label>
            <input type="text" name="slug" class="form-control rounded-3">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Mã SKU</label>
            <input type="text" name="sku" class="form-control rounded-3">
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Danh mục</label>
            <input type="number" name="category_id" class="form-control rounded-3">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Thương hiệu</label>
            <input type="number" name="brand_id" class="form-control rounded-3">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Giá bán</label>
            <input type="number" name="price" class="form-control rounded-3">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Giá gốc</label>
            <input type="number" name="compare_price" class="form-control rounded-3">
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Tồn kho</label>
            <input type="number" name="stock_quantity" class="form-control rounded-3">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Trạng thái</label>
            <select name="status" class="form-select rounded-3">
              <option value="active">Hoạt động</option>
              <option value="inactive">Ẩn</option>
            </select>
          </div>
          <div class="col-md-3 d-flex align-items-center">
            <div class="form-check mt-4">
              <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured">
              <label class="form-check-label fw-semibold" for="is_featured">
                Nổi bật
              </label>
            </div>
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-3">
            <label class="form-label fw-semibold">Ảnh đại diện</label>
            <input type="file" name="featured_image" class="form-control rounded-3">
          </div>
          <div class="col-md-9">
            <label class="form-label fw-semibold">Bộ sưu tập ảnh</label>
            <input type="file" name="gallery[]" class="form-control rounded-3" multiple>
            <small class="text-muted">Giữ Ctrl để chọn nhiều ảnh.</small>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Mô tả ngắn</label>
          <textarea name="short_description" class="form-control rounded-3" rows="2"></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Mô tả chi tiết</label>
          <textarea name="description" class="form-control rounded-3" rows="4"></textarea>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-success fw-semibold rounded-pill px-4 shadow-sm">
            <i class="fas fa-save me-1"></i> Lưu sản phẩm
          </button>
          <a href="<?php echo Helper::url('admin/product/index'); ?>" 
             class="btn btn-secondary fw-semibold rounded-pill px-4 shadow-sm">
            <i class="fas fa-times me-1"></i> Hủy
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php if (!empty($_SESSION['error'])): ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
  <div id="flashToast" class="toast align-items-center text-bg-danger border-0" 
       role="alert" data-bs-autohide="true" data-bs-delay="3000">
    <div class="d-flex">
      <div class="toast-body">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo $_SESSION['error']; ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>
<?php unset($_SESSION['error']); ?>
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

<?php include 'views/admin/layouts/footer.php'; ?>
