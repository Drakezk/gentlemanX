<?php include 'views/admin/layouts/header.php'; ?>

<div class="container py-4">
    <h1 class="mb-4">Cập nhật đơn hàng #<?php echo $order['id']; ?></h1>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Trạng thái đơn hàng</label>
            <select name="status" class="form-select">
                <option value="pending" <?php echo $order['status']=='pending'?'selected':''; ?>>Pending</option>
                <option value="confirmed" <?php echo $order['status']=='confirmed'?'selected':''; ?>>Confirmed</option>
                <option value="shipped" <?php echo $order['status']=='shipped'?'selected':''; ?>>Shipped</option>
                <option value="completed" <?php echo $order['status']=='completed'?'selected':''; ?>>Completed</option>
                <option value="cancelled" <?php echo $order['status']=='cancelled'?'selected':''; ?>>Cancelled</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Trạng thái thanh toán</label>
            <select name="payment_status" class="form-select">
                <option value="pending" <?php echo $order['payment_status']=='pending'?'selected':''; ?>>Pending</option>
                <option value="paid" <?php echo $order['payment_status']=='paid'?'selected':''; ?>>Paid</option>
                <option value="refunded" <?php echo $order['payment_status']=='refunded'?'selected':''; ?>>Refunded</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ giao hàng</label>
            <input type="text" name="shipping_address" class="form-control" value="<?php echo $order['shipping_address']; ?>">
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="<?php echo Helper::url('admin/order/index'); ?>" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<?php include 'views/admin/layouts/footer.php'; ?>
