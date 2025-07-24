<?php include 'views/admin/layouts/header.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Quản lý danh mục</h1>
    <a href="<?php echo Helper::url('admin/category/create'); ?>" class="btn btn-success mb-3">Thêm danh mục</a>
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Tên</th>
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
                    <td><?= $c['id'] ?></td>
                    <td><?= Helper::e($c['name']) ?></td>
                    <td><?= Helper::e($c['slug']) ?></td>
                    <td><?= Helper::e($c['description']) ?></td>
                    <td><?= $c['sort_order'] ?></td>
                    <td>
                        <span class="badge bg-<?= $c['status']=='active'?'success':'secondary'; ?>">
                            <?= $c['status'] ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= Helper::url('admin/category/edit/'.$c['id']); ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="<?= Helper::url('admin/category/delete/'.$c['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa danh mục?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'views/admin/layouts/footer.php'; ?>
