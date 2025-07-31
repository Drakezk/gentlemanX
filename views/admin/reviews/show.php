<?php include_once 'views/admin/layouts/header.php'; ?>

<div class="container mt-5 review-detail-page">
  <div class="mb-4 d-flex align-items-center gap-2">
    <i class="fas fa-star text-warning fs-3"></i>
    <h3 class="fw-bold mb-0">Chi tiết đánh giá</h3>
  </div>

  <div class="card shadow rounded-4 border-0">
    <div class="card-body p-4">
      <h5 class="card-title fw-semibold text-primary mb-4 border-bottom pb-2">
        <i class="fas fa-box-open me-2"></i> Sản phẩm: <?= $review['product_name'] ?? 'N/A' ?>
      </h5>

      <ul class="list-unstyled fs-6 mb-4">
        <li class="mb-3">
          <strong><i class="fas fa-user me-2 text-muted"></i>Người dùng:</strong>
          <?= $review['user_name'] ?? '<span class="text-muted">Ẩn</span>' ?>
        </li>
        <li class="mb-3">
          <strong><i class="fas fa-star text-warning me-2"></i>Rating:</strong>
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <i class="<?= $i <= $review['rating'] ? 'fas' : 'far' ?> fa-star <?= $i <= $review['rating'] ? 'text-warning' : 'text-secondary' ?>"></i>
          <?php endfor; ?>
          <span class="ms-2 text-muted">(<?= $review['rating'] ?>/5)</span>
        </li>
        <li class="mb-3">
          <strong><i class="fas fa-heading me-2 text-muted"></i>Tiêu đề:</strong>
          <span class="text-dark"><?= htmlspecialchars($review['title']) ?></span>
        </li>
        <li class="mb-3">
          <strong><i class="fas fa-comment me-2 text-muted"></i>Bình luận:</strong>
          <div class="border rounded p-3 bg-light mt-2 fst-italic">
            <?= nl2br(htmlspecialchars($review['comment'])) ?>
          </div>
        </li>
        <li class="mb-3">
          <strong><i class="fas fa-info-circle me-2 text-muted"></i>Trạng thái:</strong>
          <span class="badge bg-<?= $review['status'] === 'approved' ? 'success' : ($review['status'] === 'rejected' ? 'danger' : 'secondary') ?>">
            <?= ucfirst($review['status']) ?>
          </span>
        </li>
        <li class="mb-3">
          <strong><i class="fas fa-calendar-alt me-2 text-muted"></i>Ngày tạo:</strong>
          <span class="text-muted"><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></span>
        </li>
      </ul>

      <?php if (!empty($review['images'])): ?>
        <div class="mb-4">
          <strong><i class="fas fa-image me-2 text-muted"></i>Ảnh đính kèm:</strong>
          <div class="row mt-3">
            <?php foreach (json_decode($review['images'], true) as $img): ?>
              <div class="col-6 col-md-3 mb-3">
                <div class="ratio ratio-1x1 border rounded shadow-sm overflow-hidden hover-zoom">
                  <img src="<?= Helper::upload($img) ?>" class="img-fluid w-100 h-100 object-fit-cover" alt="Ảnh đánh giá">
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <a href="<?= Helper::url('admin/review') ?>" class="btn btn-outline-primary rounded-pill px-4">
        <i class="fas fa-arrow-left me-2"></i>Quay lại
      </a>
    </div>
  </div>
</div>

<!-- Custom CSS cải thiện UI -->
<style>
.review-detail-page .card {
  border-radius: 1rem;
  border: none;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
}

.review-detail-page .card-title {
  font-size: 1.25rem;
  border-bottom: 1px solid #dee2e6;
}

.review-detail-page .list-unstyled li {
  line-height: 1.7;
}

.hover-zoom {
  overflow: hidden;
  border-radius: 0.5rem;
}
.hover-zoom img {
  transition: transform 0.3s ease;
  object-fit: cover;
}
.hover-zoom:hover img {
  transform: scale(1.1);
}

/* Badge màu */
.badge-success { background-color: #28a745; }
.badge-danger { background-color: #dc3545; }
.badge-secondary { background-color: #6c757d; }
</style>

<?php include_once 'views/admin/layouts/footer.php'; ?>
