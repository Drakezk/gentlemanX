<?php include 'views/admin/layouts/header.php'; ?>

<?php
$totalOrderCount = array_sum(array_column($orderByStatus, 'count'));
?>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            <i class="fas fa-chart-line me-2 text-primary"></i>Thống kê doanh thu
        </h3>
    </div>

    <!-- Tổng quan -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-light h-100">
                <div class="card-body text-center">
                    <i class="fas fa-coins fa-2x text-success mb-2"></i>
                    <h6 class="text-muted">Tổng doanh thu</h6>
                    <h3 class="text-success fw-bold"><?= number_format($totalRevenue) ?> đ</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-cart fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted">Tổng đơn hàng</h6>
                    <h4 class="fw-bold"><?= $totalOrders ?? 0 ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-info mb-2"></i>
                    <h6 class="text-muted">Đơn hàng thành công</h6>
                    <h4 class="fw-bold"><?= $successfulOrders ?? 0 ?></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Bộ lọc thống kê -->
    <form method="GET" id="filterForm" class="mb-4">
        <label class="me-2 fw-bold">Xem theo:</label>
        <select name="filter" class="form-select d-inline-block w-auto" onchange="document.getElementById('filterForm').submit()">
            <option value="week" <?= $filter === 'week' ? 'selected' : '' ?>>Tuần</option>
            <option value="month" <?= $filter === 'month' ? 'selected' : '' ?>>Tháng</option>
            <option value="year" <?= $filter === 'year' ? 'selected' : '' ?>>Năm</option>
        </select>
    </form>

    <!-- Biểu đồ doanh thu -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5>Biểu đồ doanh thu theo <?= $filter === 'week' ? 'tuần' : ($filter === 'year' ? 'năm' : 'tháng') ?></h5>
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>

    <!-- Biểu đồ trạng thái đơn hàng -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">
                    <i class="bi bi-bar-chart-line-fill text-primary me-2"></i>
                    Biểu đồ đơn hàng theo trạng thái
                </h5>
                <span class="badge bg-light text-secondary fw-normal">
                    Cập nhật: <?= date('d/m/Y') ?>
                </span>
            </div>
            <p class="text-muted small mb-3">
                Thống kê tỷ lệ đơn hàng theo từng trạng thái: đã giao, đang xử lý, hủy bỏ.
            </p>
            <div class="row align-items-center">
                <div class="col-md-6 text-center">
                    <canvas id="orderStatusChart" style="width: 100%; height: 300px;"></canvas>
                </div>

                <div class="col-md-6">
                    <ul class="list-group list-group-flush small">
                        <?php
                        $statusColors = [
                            'delivered' => 'primary',
                            'processing' => 'secondary',
                            'cancelled' => 'danger',
                            'confirmed' => 'success',
                            'pending' => 'warning'
                        ];

                        foreach ($orderByStatus as $status) {
                            $label = ucfirst($status['status']); // Viết hoa chữ cái đầu
                            $count = $status['count'];
                            $percentage = $totalOrderCount > 0 ? round(($count / $totalOrderCount) * 100) : 0;

                            // Gán class màu
                            $colorClass = $statusColors[$status['status']] ?? 'secondary';
                            ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="bi bi-circle-fill text-<?= $colorClass ?> me-2"></i><?= $label ?>
                                </span>
                                <span class="fw-bold text-<?= $colorClass ?>"><?= $percentage ?>%</span>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = <?= json_encode(array_column($monthlyRevenue, 'label')) ?>;
    const data = <?= json_encode(array_column($monthlyRevenue, 'revenue')) ?>;

    const statusLabels = <?= json_encode(array_column($orderByStatus, 'status')) ?>;
    const statusCounts = <?= json_encode(array_column($orderByStatus, 'count')) ?>;

    // Biểu đồ doanh thu
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (đ)',
                data: data,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y.toLocaleString('vi-VN') + ' đ';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => value.toLocaleString('vi-VN') + ' đ'
                    }
                }
            }
        }
    });

    // Biểu đồ đơn hàng theo trạng thái
    const ctxStatus = document.getElementById('orderStatusChart').getContext('2d');
    
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: statusLabels.map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                data: statusCounts,
                backgroundColor: ['#ffc107', '#198754', '#dc3545', '#0d6efd', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
</script>

<?php include 'views/admin/layouts/footer.php'; ?>