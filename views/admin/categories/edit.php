<?php include 'views/admin/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/create.css'); ?>">

<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <!-- Header -->
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h3 class="mb-0 fw-bold">
        <i class="fas fa-folder-open me-2"></i> Sửa danh mục
      </h3>
      <a href="<?php echo Helper::url('admin/category/index'); ?>" 
         class="btn btn-light btn-sm fw-semibold rounded-pill shadow-sm d-flex align-items-center gap-2">
        <i class="fas fa-arrow-left"></i> Quay lại
      </a>
    </div>

    <!-- Body -->
    <div class="card-body">
      <form method="POST" action="">
        <div class="mb-3">
          <label class="form-label fw-semibold">Tên danh mục <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control rounded-3"
                 value="<?= Helper::e($category['name']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Slug</label>
          <input type="text" name="slug" class="form-control rounded-3"
                 value="<?= Helper::e($category['slug']) ?>">
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Mô tả</label>
          <textarea name="description" class="form-control rounded-3" rows="3"><?= Helper::e($category['description']) ?></textarea>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Thứ tự sắp xếp</label>
            <input type="number" name="sort_order" class="form-control rounded-3"
                   value="<?= $category['sort_order'] ?>">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Trạng thái</label>
            <select name="status" class="form-select rounded-3">
              <option value="active" <?= $category['status']=='active'?'selected':'' ?>>Hoạt động</option>
              <option value="inactive" <?= $category['status']=='inactive'?'selected':'' ?>>Ẩn</option>
            </select>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-success fw-semibold rounded-pill px-4 shadow-sm">
            <i class="fas fa-save me-1"></i> Cập nhật
          </button>
          <a href="<?php echo Helper::url('admin/category/index'); ?>" 
             class="btn btn-secondary fw-semibold rounded-pill px-4 shadow-sm">
            <i class="fas fa-times me-1"></i> Hủy
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'views/admin/layouts/footer.php'; ?>
