<?php include 'views/admin/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/create.css'); ?>">

<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <!-- Header -->
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h3 class="mb-0 fw-bold">
        <i class="fas fa-user-plus me-2"></i> Thêm người dùng
      </h3>
      <a href="<?php echo Helper::url('admin/user/index'); ?>" 
         class="btn btn-light btn-sm fw-semibold rounded-pill shadow-sm d-flex align-items-center gap-2">
        <i class="fas fa-arrow-left"></i> Quay lại
      </a>
    </div>

    <!-- Body -->
    <div class="card-body">
      <form method="POST" action="">
        <div class="mb-3">
          <label class="form-label fw-semibold">Họ tên</label>
          <input type="text" name="name" class="form-control rounded-3" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Email</label>
          <input type="email" name="email" class="form-control rounded-3" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Mật khẩu</label>
          <input type="password" name="password" class="form-control rounded-3" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Số điện thoại</label>
          <input type="text" name="phone" class="form-control rounded-3">
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Vai trò</label>
            <select name="role" class="form-select rounded-3">
              <option value="customer">Khách hàng</option>
              <option value="admin">Quản trị viên</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Trạng thái</label>
            <select name="status" class="form-select rounded-3">
              <option value="active">Hoạt động</option>
              <option value="inactive">Khóa</option>
            </select>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-success fw-semibold rounded-pill px-4 shadow-sm">
            <i class="fas fa-save me-1"></i> Lưu
          </button>
          <a href="<?php echo Helper::url('admin/user/index'); ?>" 
             class="btn btn-secondary fw-semibold rounded-pill px-4 shadow-sm">
            <i class="fas fa-times me-1"></i> Hủy
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'views/admin/layouts/footer.php'; ?>
