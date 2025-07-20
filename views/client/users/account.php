<?php include 'views/client/layouts/header.php'; ?>

<div class="container py-5">
    <h1 class="mb-4 fw-bold text-primary"><i class="fas fa-user-circle me-2"></i>Thông tin tài khoản</h1>

    <?php if (isset($user)): ?>
        <div class="card shadow-sm border-0 rounded-4 mb-5">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="mb-2"><i class="fas fa-user me-2 text-secondary"></i><strong>Tên:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                        <p class="mb-2"><i class="fas fa-envelope me-2 text-secondary"></i><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><i class="fas fa-user-tag me-2 text-secondary"></i><strong>Vai trò:</strong> 
                            <span class="badge bg-dark"><?php echo htmlspecialchars($user['role']); ?></span>
                        </p>
                        <p class="mb-2"><i class="fas fa-calendar-alt me-2 text-secondary"></i><strong>Ngày tạo:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>
                    </div>
                </div>

                <div class="mt-4 d-flex flex-wrap">
                    <a href="<?php echo Helper::url('auth/logout'); ?>" class="btn btn-outline-danger me-2">
                        <i class="fas fa-sign-out-alt me-1"></i> Đăng xuất
                    </a>
                    <?php if ($user['role'] === 'admin'): ?>
                        <a href="<?php echo Helper::url('admin'); ?>" class="btn btn-warning">
                            <i class="fas fa-cogs me-1"></i> Vào trang Quản Trị
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <h2 class="mb-3 fw-semibold text-success"><i class="fas fa-box-open me-2"></i>Đơn hàng của bạn</h2>
        <?php if (!empty($orders)): ?>
            <div class="table-responsive">
                <table class="table align-middle table-hover shadow-sm border rounded-4 overflow-hidden">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th class="py-3">Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr class="text-center">
                                <td class="fw-bold text-primary">#<?php echo $order['id']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                <td class="text-danger fw-semibold"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> đ</td>
                                <td>
                                    <?php
                                        $status = $order['status'];
                                        $badgeClass = match($status) {
                                            'pending'    => 'bg-warning text-dark',
                                            'processing' => 'bg-info',
                                            'shipped'    => 'bg-primary',
                                            'completed'  => 'bg-success',
                                            'cancelled'  => 'bg-danger',
                                            default      => 'bg-secondary'
                                        };
                                    ?>
                                    <span class="badge rounded-pill <?php echo $badgeClass; ?> px-3 py-2 text-capitalize">
                                        <?php echo $status; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo Helper::url('checkout/detail/' . $order['id']); ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="fas fa-eye me-1"></i> Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info rounded-3 shadow-sm">
                <i class="fas fa-info-circle me-2"></i>Bạn chưa có đơn hàng nào.
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-danger rounded-3 shadow-sm">
            <i class="fas fa-exclamation-circle me-2"></i>Không tìm thấy thông tin tài khoản.
        </div>
    <?php endif; ?>
</div>

<?php include 'views/client/layouts/footer.php'; ?>
