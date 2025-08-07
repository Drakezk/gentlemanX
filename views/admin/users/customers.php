<?php include 'views/admin/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/create.css'); ?>">

<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <!-- Tiêu đề -->
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h3 class="mb-0 fw-bold">
        <i class="fas fa-users me-2"></i> Danh sách Khách hàng
      </h3>
      <a href="<?php echo Helper::url('admin/user/create'); ?>" 
         class="btn btn-light btn-sm fw-semibold rounded-pill shadow-sm d-flex align-items-center gap-2">
        <i class="fas fa-user-plus"></i> Thêm khách hàng
      </a>
    </div>

    <!-- Bảng danh sách -->
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr class="text-center">
              <th>ID</th>
              <th>Họ tên</th>
              <th>Email</th>
              <th>Số điện thoại</th>
              <th>Trạng thái</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($users as $user): ?>
              <tr>
                <td class="text-center fw-semibold"><?php echo $user['id']; ?></td>
                <td class="text-center fw-bold text-primary"><?php echo Helper::e($user['name']); ?></td>
                <td class="text-center"><?php echo Helper::e($user['email']); ?></td>
                <td class="text-center"><?php echo Helper::e($user['phone'] ?? ''); ?></td>
                <td class="text-center">
                  <span class="badge px-3 py-2 rounded-pill bg-<?php echo $user['status']=='active'?'success':'secondary'; ?>">
                    <?php echo ucfirst($user['status']=='active'?'Hoạt động':'Khóa'); ?>
                  </span>
                </td>
                <td class="text-center">
                  <a href="<?php echo Helper::url('admin/user/edit/'.$user['id']); ?>" 
                     class="btn btn-outline-warning btn-sm rounded-pill me-1">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="<?php echo Helper::url('admin/user/delete/'.$user['id']); ?>" 
                     class="btn btn-outline-danger btn-sm rounded-pill"
                     onclick="return confirm('Xóa người dùng này?');">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include 'views/admin/layouts/footer.php'; ?>
