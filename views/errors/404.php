<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy trang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .error-content {
            text-align: center;
            color: white;
        }
        .error-code {
            font-size: 8rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="error-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="error-content">
                        <div class="error-code">404</div>
                        <h2 class="mb-4">Oops! Không tìm thấy trang</h2>
                        <p class="lead mb-4">
                            <?php echo isset($message) ? Helper::e($message) : 'Trang bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển.' ?>
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="<?php echo Helper::url() ?>" class="btn btn-light btn-lg">
                                <i class="fas fa-home me-2"></i>Về trang chủ
                            </a>
                            <button onclick="history.back()" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>
