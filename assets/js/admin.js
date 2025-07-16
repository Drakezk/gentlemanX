// JavaScript cho Admin area
document.addEventListener("DOMContentLoaded", () => {
  console.log("Admin area loaded")

  // Sidebar toggle
  const sidebar = document.getElementById("sidebar")
  const content = document.getElementById("content")
  const sidebarCollapse = document.getElementById("sidebarCollapse")

  if (sidebarCollapse) {
    sidebarCollapse.addEventListener("click", () => {
      sidebar.classList.toggle("active")
      content.classList.toggle("active")
    })
  }

  // Xác nhận trước khi xóa
  document.querySelectorAll(".btn-delete").forEach((button) => {
    button.addEventListener("click", (e) => {
      if (!confirm("Bạn có chắc chắn muốn xóa? Hành động này không thể hoàn tác!")) {
        e.preventDefault()
      }
    })
  })

  // Auto-hide flash messages after 5 seconds
  const alerts = document.querySelectorAll(".alert")
  const bootstrap = window.bootstrap // Declare the bootstrap variable
  alerts.forEach((alert) => {
    setTimeout(() => {
      const bsAlert = new bootstrap.Alert(alert)
      bsAlert.close()
    }, 5000) // 5 seconds
  })
})
