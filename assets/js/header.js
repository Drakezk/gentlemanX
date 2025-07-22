document.addEventListener('DOMContentLoaded', function() {
  let lastScrollTop = 0;
  const header = document.getElementById("mainHeader");

  window.addEventListener("scroll", function () {
    const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

    // Kiểm tra khi cuộn để ẩn/hiện
    if (currentScroll > lastScrollTop && currentScroll > 100) {
      // Cuộn xuống và vượt 100px thì ẩn header
      header.style.transform = "translateY(-100%)";
    } else {
      // Cuộn lên thì hiện header
      header.style.transform = "translateY(0)";
    }

    // Khi cuộn vượt 50px thì thêm class sticky-active
    if (currentScroll > 50) {
      header.classList.add('sticky-active');
    } else {
      header.classList.remove('sticky-active');
    }

    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // tránh lỗi âm
  });
});