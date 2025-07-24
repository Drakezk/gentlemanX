<?php include 'views/admin/layouts/header.php'; ?>
<div class="container py-4">
    <h1 class="mb-3">Danh sách Khách hàng</h1>
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo Helper::e($user['name']); ?></td>
                    <td><?php echo Helper::e($user['email']); ?></td>
                    <td>
                        <span class="badge bg-<?php echo $user['status']=='active'?'success':'secondary'; ?>">
                            <?php echo $user['status']; ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?php echo Helper::url('admin/user/edit/'.$user['id']); ?>" class="btn btn-warning btn-sm">Sửa</a>
                        <a href="<?php echo Helper::url('admin/user/delete/'.$user['id']); ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Xóa người dùng này?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'views/admin/layouts/footer.php'; ?>
