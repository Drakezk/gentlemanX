document.addEventListener('DOMContentLoaded', function () {
  // Lưu số lượng ban đầu vào data attribute
  document.querySelectorAll('input[name="quantity"]').forEach(input => {
    input.dataset.original = input.value;
  });

  // Khi bấm nút Tiến hành thanh toán
  document.querySelector('#checkoutBtn').addEventListener('click', function (e) {
    let changed = false;

    document.querySelectorAll('input[name="quantity"]').forEach(input => {
      if (input.value !== input.dataset.original) {
        changed = true;
      }
    });

    if (changed) {
      e.preventDefault(); // Ngăn chuyển trang
      alert("Bạn đã thay đổi số lượng nhưng chưa bấm nút cập nhật. Vui lòng cập nhật giỏ hàng trước khi thanh toán!");
    }
  });
});