document.addEventListener('DOMContentLoaded', function () {
  // ======= 1. Kiểm tra đăng nhập khi gửi đánh giá =======
  const form = document.querySelector('form[action*="review/submit"]');
  if (!form) return;

  const isLoggedIn = window.isLoggedIn; // Lấy biến toàn cục

  form.addEventListener('submit', function (e) {
    if (!isLoggedIn) {
      e.preventDefault();
      alert('Bạn cần đăng nhập để gửi đánh giá!');
      window.location.href = window.loginUrl;
    }
  });

  // ======= 2. Xử lý rating sao =======
  const stars = document.querySelectorAll('.star-icon');
    const inputs = document.querySelectorAll('.star-input');

    stars.forEach((star, idx) => {
      star.addEventListener('mouseover', () => {
        stars.forEach((s, i) => {
          s.classList.toggle('active', i <= idx);
          s.classList.toggle('hovered', i <= idx);
        });
      });

      star.addEventListener('mouseout', () => {
        const checkedIndex = [...inputs].findIndex(input => input.checked);
        stars.forEach((s, i) => {
          s.classList.toggle('active', i <= checkedIndex);
          s.classList.remove('hovered');
        });
      });

      star.addEventListener('click', () => {
        inputs[idx].checked = true;
        stars.forEach((s, i) => {
          s.classList.toggle('active', i <= idx);
        });
      });
    });

    // ======= 3. Hiển thị toast thông báo =======
    const toastEl = document.querySelector('.toast');
    if (toastEl) {
      const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
      toast.show();
    }
});