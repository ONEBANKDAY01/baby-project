// ทำให้ฟอร์มมีแอนิเมชันเมื่อกรอกข้อมูลเสร็จ
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".add-product-form");
  const inputFields = form.querySelectorAll("input, textarea");
  const submitButton = form.querySelector('button[type="submit"]');

  // ตรวจสอบเมื่อผู้ใช้กรอกข้อมูลเสร็จแล้ว
  inputFields.forEach((input) => {
    input.addEventListener("focus", function () {
      this.closest(".input-group").classList.add("focused");
    });

    input.addEventListener("blur", function () {
      if (this.value === "") {
        this.closest(".input-group").classList.remove("focused");
      }
    });
  });

  // เพิ่มแอนิเมชันให้ปุ่มเมื่อมีการ hover
  submitButton.addEventListener("mouseover", function () {
    this.style.transform = "scale(1.05)";
    this.style.transition = "transform 0.3s ease";
  });

  submitButton.addEventListener("mouseout", function () {
    this.style.transform = "scale(1)";
  });

  // เมื่อฟอร์มถูกส่ง
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    // การตรวจสอบข้อมูลก่อนส่ง
    let isValid = true;
    inputFields.forEach((input) => {
      if (!input.value) {
        input.closest(".input-group").classList.add("error");
        isValid = false;
      } else {
        input.closest(".input-group").classList.remove("error");
      }
    });

    // ถ้าทุกอย่างถูกต้อง ให้ส่งฟอร์ม
    if (isValid) {
      // เพิ่มการแอนิเมชันการโหลด
      submitButton.innerHTML = "Adding Product...";
      submitButton.disabled = true;

      setTimeout(() => {
        form.submit();
      }, 1000); // ส่งฟอร์มหลังจากการโหลด 1 วินาที
    } else {
      alert("Please fill out all fields correctly.");
    }
  });
});
