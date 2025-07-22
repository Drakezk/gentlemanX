<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Không tìm thấy trang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo Helper::asset('css/error.css') ?>">
</head>
<body>
  <div class="error-page">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="error-card">
            <div class="error-code">404</div>
            <h2>Oops! Không tìm thấy trang</h2>
            <p>
              <?php echo isset($message) ? Helper::e($message) : 'Trang bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển.' ?>
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
              <a href="<?php echo Helper::url() ?>" class="btn btn-light btn-lg shadow-sm">
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
