document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".edit-product-form");
  const inputs = form.querySelectorAll("input, textarea");
  const submitButton = form.querySelector("button");
  const errorMessageElement = document.querySelector(".error-message");

  // Validate the form before submission
  form.addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent form from submitting to handle validation

    // Reset error state
    errorMessageElement.textContent = "";

    // Collect form data
    const name = form.querySelector("#name").value.trim();
    const description = form.querySelector("#description").value.trim();
    const price = form.querySelector("#price").value.trim();
    const image = form.querySelector("#image").value.trim();

    // Simple validation
    if (name === "" || description === "" || price === "" || image === "") {
      displayErrorMessage("Please fill in all fields.");
      return;
    }

    // Price validation (ensure it's a valid number)
    if (isNaN(price) || parseFloat(price) <= 0) {
      displayErrorMessage("Please enter a valid price.");
      return;
    }

    // If validation is successful, submit the form (simulate for now)
    displaySuccessMessage("Product successfully updated!");

    // Uncomment below line to actually submit the form if it's ready for backend processing
    // form.submit();
  });

  // Input field animations on focus and blur
  inputs.forEach((input) => {
    input.addEventListener("focus", function () {
      input.style.transform = "scale(1.05)";
      input.style.boxShadow = "0 0 10px rgba(37, 117, 252, 0.8)";
    });

    input.addEventListener("blur", function () {
      input.style.transform = "scale(1)";
      input.style.boxShadow = "none";
    });
  });

  // Hover effect on submit button
  submitButton.addEventListener("mouseover", function () {
    submitButton.style.transform = "translateY(-3px)";
    submitButton.style.transition = "transform 0.3s ease";
  });

  submitButton.addEventListener("mouseout", function () {
    submitButton.style.transform = "translateY(0)";
    submitButton.style.transition = "transform 0.3s ease";
  });

  submitButton.addEventListener("click", function () {
    submitButton.style.transform = "translateY(3px)";
    submitButton.style.transition = "transform 0.1s ease";
  });

  // Function to display error messages
  function displayErrorMessage(message) {
    errorMessageElement.textContent = message;
    errorMessageElement.style.color = "#ff61a6"; // Pink for error
    errorMessageElement.style.opacity = "1";
    errorMessageElement.style.transition = "opacity 0.3s ease-out";
  }

  // Function to display success message
  function displaySuccessMessage(message) {
    errorMessageElement.textContent = message;
    errorMessageElement.style.color = "#4CAF50"; // Green for success
    errorMessageElement.style.opacity = "1";
    errorMessageElement.style.transition = "opacity 0.3s ease-out";

    // Optionally reset form after success (if needed)
    setTimeout(() => {
      form.reset();
      errorMessageElement.style.opacity = "0";
    }, 2000);
  }
});
