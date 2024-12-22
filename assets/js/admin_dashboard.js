// สำหรับยืนยันการลบสินค้า
document.querySelectorAll(".delete-btn").forEach(function (deleteButton) {
  deleteButton.addEventListener("click", function (event) {
    event.preventDefault();

    // ยืนยันการลบด้วย SweetAlert2 (การใช้แอพพลิเคชันแสดงผลสวยๆ)
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = deleteButton.href; // ทำการลบจริง ๆ เมื่อยืนยัน
      }
    });
  });
});

// ฟีเจอร์ Toggle ตารางสินค้าหรือปุ่มอื่น ๆ
document
  .querySelector(".toggle-table-btn")
  .addEventListener("click", function () {
    let table = document.querySelector(".product-table");
    let isHidden = table.style.display === "none";

    if (isHidden) {
      table.style.display = "block";
      this.innerText = "Hide Products"; // เปลี่ยนข้อความเป็น 'Hide Products'
    } else {
      table.style.display = "none";
      this.innerText = "Show Products"; // เปลี่ยนข้อความเป็น 'Show Products'
    }
  });

// ฟีเจอร์การทำปุ่ม Add Product มีแอนิเมชันนิดหน่อย
const addProductButton = document.querySelector(".add-product-btn");
addProductButton.addEventListener("mouseenter", function () {
  addProductButton.style.transform = "scale(1.05)";
  addProductButton.style.transition = "transform 0.3s ease";
});

addProductButton.addEventListener("mouseleave", function () {
  addProductButton.style.transform = "scale(1)";
});
