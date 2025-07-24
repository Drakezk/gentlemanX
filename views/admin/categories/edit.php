<?php include 'views/admin/layouts/header.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Sửa danh mục</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Tên danh mục</label>
            <input type="text" name="name" class="form-control" value="<?= Helper::e($category['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="<?= Helper::e($category['slug']) ?>">
        </div>
        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control"><?= Helper::e($category['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Thứ tự sắp xếp</label>
            <input type="number" name="sort_order" class="form-control" value="<?= $category['sort_order'] ?>">
        </div>
        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-select">
                <option value="active" <?= $category['status']=='active'?'selected':'' ?>>Active</option>
                <option value="inactive" <?= $category['status']=='inactive'?'selected':'' ?>>Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="<?php echo Helper::url('admin/category/index'); ?>" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<?php include 'views/admin/layouts/footer.php'; ?>
