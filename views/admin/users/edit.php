<?php include 'views/admin/layouts/header.php'; ?>
<div class="container py-4">
    <h1 class="mb-4">Sửa người dùng</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input type="text" name="name" class="form-control" value="<?php echo Helper::e($user['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo Helper::e($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="<?php echo Helper::e($user['phone']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Vai trò</label>
            <select name="role" class="form-select">
                <option value="customer" <?php echo ($user['role']=='customer')?'selected':''; ?>>Customer</option>
                <option value="admin" <?php echo ($user['role']=='admin')?'selected':''; ?>>Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <option value="active" <?php echo ($user['status']=='active')?'selected':''; ?>>Active</option>
                <option value="inactive" <?php echo ($user['status']=='inactive')?'selected':''; ?>>Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="<?php echo Helper::url('admin/user/customers'); ?>" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<?php include 'views/admin/layouts/footer.php'; ?>
