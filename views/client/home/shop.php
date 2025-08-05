<?php include 'views/client/layouts/header.php'; ?>

<!-- Hiệu ứng fade -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="container my-5">
  <div class="card shadow border-0 rounded-4 overflow-hidden">
    <div class="row g-0">

      <!-- Bản đồ -->
      <div class="col-md-6">
        <div class="ratio ratio-4x3 h-100">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7446.815143447568!2d105.7205906510353!3d21.05637778902096!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3134545727940001%3A0x4b580ae120df941d!2zQVRJTk8gLSAxMTAgUGjhu5EgTmjhu5Vu!5e0!3m2!1svi!2s!4v1754346534679!5m2!1svi!2s" 
            style="border:0; border-right: 2px solid #eee;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>

      <!-- Thông tin liên hệ -->
      <div class="col-md-6 d-flex align-items-center gradient-bg text-white">
        <div class="p-5 animate__animated animate__fadeInRight">
          <h4 class="mb-4 fw-bold fs-4 text-uppercase text-white-shadow">
            <i class="bi bi-geo-alt-fill me-2 text-white"></i>
            Địa chỉ cửa hàng
          </h4>

          <ul class="list-unstyled fs-6 lh-lg">
            <li>
              <i class="bi bi-geo-alt me-2 fs-5 text-white contact-icon"></i>
              <span class="fw-semibold">123 Phố Văn Trì</span>, Bắc Từ Liêm, Hà Nội
            </li>
            <li>
              <i class="bi bi-envelope me-2 fs-5 text-white contact-icon"></i>
              <a href="mailto:support@gentlemanx.com" class="text-white fw-semibold contact-link">support@gentlemanx.com</a>
            </li>
            <li>
              <i class="bi bi-telephone me-2 fs-5 text-white contact-icon"></i>
              <a href="tel:0123456789" class="text-white fw-semibold contact-link">0123 456 789</a>
            </li>
            <li>
              <i class="bi bi-clock me-2 fs-5 text-white contact-icon"></i>
              Thứ 2 – Thứ 7: <span class="fw-semibold">9:00 – 21:00</span>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</div>

<style>
  /* Hiệu ứng hover icon */
  .contact-icon:hover {
    transform: scale(1.15);
    transition: 0.3s ease;
  }

  /* Hiệu ứng hover link */
  .contact-link:hover {
    color: #ffc107 !important;
    text-decoration: none;
  }

  /* Gradient nền động */
  .gradient-bg {
    background: linear-gradient(270deg, #0d6efd, #6610f2, #0d6efd);
    background-size: 600% 600%;
    animation: gradientFlow 8s ease infinite;
  }

  @keyframes gradientFlow {
    0% {background-position: 0% 50%;}
    50% {background-position: 100% 50%;}
    100% {background-position: 0% 50%;}
  }

  /* Text đổ bóng nhẹ */
  .text-white-shadow {
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.4);
  }
</style>

<?php include 'views/client/layouts/footer.php'; ?>