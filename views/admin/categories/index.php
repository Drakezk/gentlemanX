<?php include 'views/admin/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/management.css') ?>">

<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <!-- Header -->
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h3 class="mb-0 fw-bold">
        <i class="fas fa-list-alt me-2"></i>Quản lý danh mục
      </h3>
      <a href="<?php echo Helper::url('admin/category/create'); ?>" 
         class="btn btn-light btn-sm fw-semibold rounded-pill shadow-sm">
        <i class="fas fa-plus me-1"></i> Thêm danh mục
      </a>
    </div>

    <!-- Body -->
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table align-middle table-hover mb-0">
          <thead class="table-light">
            <tr class="text-center">
              <th>ID</th>
              <th>Tên</th>
              <th>Danh mục cha</th>
              <th>Slug</th>
              <th>Mô tả</th>
              <th>Thứ tự</th>
              <th>Trạng thái</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($categories as $c): ?>
              <tr>
                <td class="text-center fw-semibold"><?= $c['id'] ?></td>
                <td class="fw-bold text-primary"><?= Helper::e($c['name']) ?></td>
                <td class="text-muted text-center">
                  <?php if ($c['parent_id']): ?>
                    <?php echo isset($parentNames[$c['parent_id']]) ? Helper::e($parentNames[$c['parent_id']]) : '---'; ?>
                  <?php else: ?>
                    <span class="text-secondary">-- (Cha) --</span>
                  <?php endif; ?>
                </td>
                <td class="text-muted"><?= Helper::e($c['slug']) ?></td>
                <td class="text-wrap"><?= Helper::e($c['description']) ?></td>
                <td class="text-center"><?= $c['sort_order'] ?></td>
                <td class="text-center">
                  <span class="badge px-3 py-2 rounded-pill bg-<?= $c['status']=='active'?'success':'secondary'; ?>">
                    <?= $c['status']=='active'?'Hoạt động':'Ẩn'; ?>
                  </span>
                </td>
                <td class="text-center">
                  <a href="<?= Helper::url('admin/category/edit/'.$c['id']); ?>" 
                     class="btn btn-sm btn-outline-warning rounded-pill me-1 px-3">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="<?= Helper::url('admin/category/delete/'.$c['id']); ?>" 
                     class="btn btn-sm btn-outline-danger rounded-pill px-3"
                     onclick="return confirm('Xóa danh mục?');">
                    <i class="fas fa-trash"></i>
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
