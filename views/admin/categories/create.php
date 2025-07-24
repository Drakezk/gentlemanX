<?php include 'views/admin/layouts/header.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Thêm danh mục</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Tên danh mục</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control">
        </div>
        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Thứ tự sắp xếp</label>
            <input type="number" name="sort_order" class="form-control" value="1">
        </div>
        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="<?php echo Helper::url('admin/category/index'); ?>" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<?php include 'views/admin/layouts/footer.php'; ?>
