<?php include 'views/client/layouts/header.php'; ?>

<section class="contact-form-section py-5 bg-light">
  <div class="container">
    <h2 class="text-center fw-bold mb-4">📬 Liên hệ với GentlemanX</h2>
    <p class="text-center mb-4">Nếu bạn có bất kỳ câu hỏi, góp ý hoặc cần hỗ trợ, hãy gửi tin nhắn cho chúng tôi.</p>

    <form action="#" method="POST" class="row g-3">
      <div class="col-md-6">
        <input type="text" name="name" class="form-control" placeholder="Họ tên của bạn" required>
      </div>
      <div class="col-md-6">
        <input type="email" name="email" class="form-control" placeholder="Email liên hệ" required>
      </div>
      <div class="col-12">
        <input type="text" name="subject" class="form-control" placeholder="Chủ đề" required>
      </div>
      <div class="col-12">
        <textarea name="message" rows="5" class="form-control" placeholder="Nội dung tin nhắn..." required></textarea>
      </div>
      <div class="col-12 text-center">
        <button type="submit" class="btn btn-dark px-5 py-2">Gửi liên hệ</button>
      </div>
    </form>
  </div>
</section>

<?php include 'views/client/layouts/footer.php'; ?>
