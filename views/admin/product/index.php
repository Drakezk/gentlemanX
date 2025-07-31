<?php include 'views/admin/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo Helper::asset('css/management.css') ?>">

<div class="product-management container py-4">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
      <h3 class="mb-0 fw-bold"><i class="fas fa-box-open me-2"></i>Quản lý sản phẩm</h3>
      <a href="<?php echo Helper::url('admin/product/create'); ?>" class="btn btn-light btn-sm fw-semibold rounded-pill shadow-sm">
        <i class="fas fa-plus me-1"></i> Thêm sản phẩm
      </a>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table align-middle table-hover mb-0">
          <thead class="table-light">
            <tr class="text-center">
              <th>ID</th>
              <th>Tên</th>
              <th>Giá</th>
              <th>SL kho</th>
              <th>Ảnh chính</th>
              <th>Gallery</th>
              <th>Trạng thái</th>
              <th>Nổi bật</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $p): ?>
            <tr>
              <td class="text-center fw-semibold"><?php echo $p['id']; ?></td>
              <td class="fw-bold text-primary"><?php echo Helper::e($p['name']); ?></td>
              <td class="text-end pe-3 text-success fw-semibold"><?php echo Helper::formatMoney($p['price']); ?></td>
              <td class="text-center"><?php echo $p['stock_quantity']; ?></td>
              <td class="text-center">
                <?php if($p['featured_image']): ?>
                  <img src="<?php echo Helper::upload($p['featured_image']); ?>" alt="" class="rounded-3 shadow-sm" style="height:50px;width:auto;">
                <?php else: ?>
                  <span class="text-muted fst-italic">Chưa có</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if($p['gallery']): ?>
                  <?php 
                    $galleryArr = json_decode($p['gallery'], true);
                    if(is_array($galleryArr)) {
                      foreach($galleryArr as $g) {
                        echo '<img src="'.Helper::upload($g).'" class="rounded-3 shadow-sm me-1 mb-1" style="height:40px;width:auto;">';
                      }
                    }
                  ?>
                <?php else: ?>
                  <span class="text-muted fst-italic">Không</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <span class="badge bg-<?php echo $p['status']=='active'?'success':'secondary'; ?> px-3 py-2 rounded-pill">
                  <?php echo $p['status']=='active'?'Hoạt động':'Ẩn'; ?>
                </span>
              </td>
              <td class="text-center">
                <?php if($p['is_featured']): ?>
                  <span class="text-success fs-5">★</span>
                <?php else: ?>
                  <span class="text-muted fs-5">☆</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <a href="<?php echo Helper::url('admin/product/edit/'.$p['id']); ?>" class="btn btn-sm btn-outline-warning rounded-pill me-1 px-3">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="<?php echo Helper::url('admin/product/delete/'.$p['id']); ?>" 
                   class="btn btn-sm btn-outline-danger rounded-pill px-3"
                   onclick="return confirm('Bạn chắc chắn muốn xóa?');">
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
