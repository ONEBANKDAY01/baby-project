document.addEventListener("DOMContentLoaded", function () {
  const addToCartButtons = document.querySelectorAll(".add-to-cart");

  addToCartButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
      const productId = this.getAttribute("href").split("=")[1];

      // เพิ่มสินค้าไปยังตะกร้า
      if (productId) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        if (!cart.includes(productId)) {
          cart.push(productId);
          localStorage.setItem("cart", JSON.stringify(cart));
          alert("Item added to cart!");
        } else {
          alert("This item is already in your cart!");
        }
      }

      event.preventDefault();
    });
  });
});
