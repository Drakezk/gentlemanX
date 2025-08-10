<?php include_once 'views/admin/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/management.css') ?>">
<link rel="stylesheet" href="<?php echo Helper::asset('css/search.css') ?>">

<div class="container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-gradient-primary d-flex justify-content-between align-items-center rounded-top-4">
      <h3 class="mb-0 fw-bold text-white"><i class="fas fa-envelope me-2"></i>Quản lý liên hệ</h3>
      <form method="GET" class="d-flex">
        <input type="text" name="q" value="<?= htmlspecialchars($keyword ?? '') ?>" 
              class="form-control form-control-sm me-2 rounded-pill" placeholder="Tìm theo tên, email hoặc tiêu đề...">
        <select name="status" class="form-select form-select-sm me-2 rounded-pill">
            <option value="">Tất cả trạng thái</option>
            <option value="pending" <?= ($status ?? '') === 'pending' ? 'selected' : '' ?>>Chưa phản hồi</option>
            <option value="replied" <?= ($status ?? '') === 'replied' ? 'selected' : '' ?>>Đã phản hồi</option>
        </select>
        <button type="submit" class="btn btn-light btn-sm fw-semibold rounded-pill shadow-sm">
            <i class="fas fa-search"></i>
        </button>
      </form>
    </div>

    <div class="card-body p-0">
      <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success m-3">
          <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0 text-center">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Người gửi</th>
              <th>Email</th>
              <th>Chủ đề</th>
              <th>Trạng thái</th>
              <th>Ngày gửi</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($messages as $msg): ?>
              <tr>
                <td class="fw-semibold"><?= $msg['id'] ?></td>
                <td class="fw-bold text-primary"><?= htmlspecialchars($msg['name']) ?></td>
                <td><?= htmlspecialchars($msg['email']) ?></td>
                <td class="text-start"><?= htmlspecialchars($msg['subject']) ?></td>
                <td>
                  <?php
                    if ($msg['status'] === 'pending') {
                      echo '<span class="badge bg-warning text-dark badge-status">Chờ phản hồi</span>';
                    } elseif ($msg['status'] === 'replied') {
                      echo '<span class="badge bg-success badge-status">Đã phản hồi</span>';
                    } else {
                      echo '<span class="badge bg-secondary badge-status">Không xác định</span>';
                    }
                  ?>
                </td>
                <td><?= date('d/m/Y H:i', strtotime($msg['created_at'])) ?></td>
                <td>
                  <a href="/admin/contact/detail/<?= $msg['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill btn-view px-3">
                    <i class="fas fa-eye me-1"></i> Chi tiết
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

<?php include_once 'views/admin/layouts/footer.php'; ?>
