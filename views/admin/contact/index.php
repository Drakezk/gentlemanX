<?php include_once 'views/admin/layouts/header.php'; ?>

<table class="table table-bordered">
    <thead><tr><th>#</th><th>Người gửi</th><th>Email</th><th>Chủ đề</th><th>Trạng thái</th><th>Ngày gửi</th><th></th></tr></thead>
    <tbody>
        <?php foreach ($messages as $msg): ?>
        <tr>
            <td><?= $msg['id'] ?></td>
            <td><?= $msg['name'] ?></td>
            <td><?= $msg['email'] ?></td>
            <td><?= $msg['subject'] ?></td>
            <td><?= $msg['status'] ?></td>
            <td><?= $msg['created_at'] ?></td>
            <td><a href="/admin/contact/detail/<?= $msg['id'] ?>">Chi tiết</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include_once 'views/admin/layouts/footer.php'; ?>