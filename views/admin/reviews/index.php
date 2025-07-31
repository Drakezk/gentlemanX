<?php include_once 'views/admin/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/management.css') ?>">

<div class="review-management container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h3 class="mb-0 fw-bold"><i class="fas fa-star me-2"></i>Quản lý đánh giá</h3>
    </div>

    <div class="card-body p-0">
      <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success m-3">
          <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table align-middle table-hover mb-0">
          <thead class="table-light text-center">
            <tr>
              <th>ID</th>
              <th>Sản phẩm</th>
              <th>Người dùng</th>
              <th>Rating</th>
              <th>Tiêu đề</th>
              <th>Trạng thái</th>
              <th>Ngày tạo</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($reviews as $review): ?>
              <tr class="text-center">
                <td class="fw-semibold"><?php echo $review['id']; ?></td>
                <td class="fw-bold text-primary"><?php echo $review['product_name'] ?? 'N/A'; ?></td>
                <td><?php echo $review['user_name'] ?? 'Ẩn'; ?></td>
                <td>
                  <?php
                    $rating = (int)$review['rating'];
                    for ($i = 1; $i <= 5; $i++) {
                      echo $i <= $rating
                        ? '<i class="fas fa-star text-warning"></i>'
                        : '<i class="far fa-star text-muted"></i>';
                    }
                  ?>
                </td>
                <td class="text-start"><?php echo htmlspecialchars($review['title']); ?></td>
                <td>
                  <?php if ($review['status'] == 'pending'): ?>
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Chờ duyệt</span>
                  <?php elseif ($review['status'] == 'approved'): ?>
                    <span class="badge bg-success rounded-pill px-3 py-2">Đã duyệt</span>
                  <?php else: ?>
                    <span class="badge bg-secondary rounded-pill px-3 py-2">Đã từ chối</span>
                  <?php endif; ?>
                </td>
                <td><?php echo date('d/m/Y H:i', strtotime($review['created_at'])); ?></td>
                <td>
                  <a href="<?= Helper::url('admin/review/show/' . $review['id']) ?>" class="btn btn-sm btn-info rounded-pill px-3 mb-1">Xem</a>

                  <?php if ($review['status'] == 'pending'): ?>
                    <a href="<?= Helper::url('admin/review/approve/' . $review['id']) ?>" class="btn btn-sm btn-success rounded-pill px-3 mb-1">Duyệt</a>
                    <a href="<?= Helper::url('admin/review/rejected/' . $review['id']) ?>" class="btn btn-sm btn-warning rounded-pill px-3 mb-1">Từ chối</a>
                  <?php endif; ?>

                  <?php if (in_array($review['status'], ['approved', 'rejected'])): ?>
                    <a href="<?= Helper::url('admin/review/delete/' . $review['id']) ?>" 
                       class="btn btn-sm btn-danger rounded-pill px-3 mb-1"
                       onclick="return confirm('Xác nhận xoá?')">Xoá</a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<style>
/* Hiệu ứng hover cho các nút hành động review */
.btn-sm.rounded-pill:hover {
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
}

/* Tùy chỉnh màu sắc hover riêng nếu muốn */
.btn-info:hover {
  background-color: #0dcaf0;
  color: #fff;
}

.btn-success:hover {
  background-color: #198754;
  color: #fff;
}

.btn-warning:hover {
  background-color: #ffc107;
  color: #fff;
}

.btn-danger:hover {
  background-color: #dc3545;
  color: #fff;
}
</style>
<?php include_once 'views/admin/layouts/footer.php'; ?>
