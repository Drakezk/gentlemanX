<?php include 'views/admin/layouts/header.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Quản lý sản phẩm</h1>
    <br>
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>SL kho</th>
                <th>Ảnh</th>
                <th>Trạng thái</th>
                <th>Nổi bật</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><?php echo $p['id']; ?></td>
                <td><?php echo Helper::e($p['name']); ?></td>
                <td><?php echo Helper::formatMoney($p['price']); ?></td>
                <td><?php echo $p['stock_quantity']; ?></td>
                <td>
                    <?php if($p['featured_image']): ?>
                        <img src="<?php echo Helper::upload($p['featured_image']); ?>" alt="" style="height:50px;">
                    <?php endif; ?>
                </td>
                <td><span class="badge bg-<?php echo $p['status']=='active'?'success':'secondary'; ?>">
                    <?php echo $p['status']; ?>
                </span></td>
                <td><?php echo $p['is_featured'] ? '✅' : '❌'; ?></td>
                <td>
                    <a href="<?php echo Helper::url('admin/product/edit/'.$p['id']); ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="<?php echo Helper::url('admin/product/delete/'.$p['id']); ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Bạn chắc chắn muốn xóa?');">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'views/admin/layouts/footer.php'; ?>
