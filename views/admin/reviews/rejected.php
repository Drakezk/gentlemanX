<?php include_once 'views/admin/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/management.css') ?>">

<div class="review-management container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-gradient bg-secondary text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h3 class="mb-0 fw-bold"><i class="fas fa-times-circle me-2"></i>Đánh giá bị từ chối</h3>
    </div>

    <div class="card-body p-0">
      <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success m-3">
          <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($reviews)): ?>
        <div class="table-responsive">
          <table class="table align-middle table-hover mb-0">
            <thead class="table-light text-center">
              <tr>
                <th>ID</th>
                <th>Sản phẩm</th>
                <th>Người dùng</th>
                <th>Rating</th>
                <th>Tiêu đề</th>
                <th>Nội dung</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($reviews as $review): ?>
                <tr class="text-center">
                  <td class="fw-semibold"><?= $review['id']; ?></td>
                  <td class="fw-bold text-primary"><?= $review['product_name'] ?? 'N/A'; ?></td>
                  <td><?= $review['user_name'] ?? 'Ẩn'; ?></td>
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
                  <td class="text-start"><?= htmlspecialchars($review['title']); ?></td>
                  <td class="text-start"><?= htmlspecialchars($review['comment']); ?></td>
                  <td><?= date('d/m/Y H:i', strtotime($review['created_at'])); ?></td>
                  <td>
                    <a href="<?= Helper::url('admin/review/show/' . $review['id']) ?>" 
                       class="btn btn-sm btn-info rounded-pill px-3 mb-1">Xem</a>

                    <a href="<?= Helper::url('admin/review/approve/' . $review['id']) ?>" 
                       class="btn btn-sm btn-success rounded-pill px-3 mb-1">Duyệt lại</a>

                    <a href="<?= Helper::url('admin/review/delete/' . $review['id']) ?>" 
                       class="btn btn-sm btn-danger rounded-pill px-3 mb-1"
                       onclick="return confirm('Xác nhận xoá đánh giá này?')">Xoá</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="alert alert-warning m-3">Không có đánh giá nào bị từ chối.</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<style>
.btn-sm.rounded-pill:hover {
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
}

.btn-info:hover {
  background-color: #0dcaf0;
  color: #fff;
}

.btn-success:hover {
  background-color: #198754;
  color: #fff;
}

.btn-danger:hover {
  background-color: #dc3545;
  color: #fff;
}
</style>

<?php include_once 'views/admin/layouts/footer.php'; ?>
