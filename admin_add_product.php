<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: admin_login.php');
    exit;
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image']; // For now, storing just the image filename.

    // Prepare SQL statement to insert the product into the database
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (:name, :description, :price, :image)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);

    // Execute the query and handle success or failure
    if ($stmt->execute()) {
        header('Location: admin_dashboard.php?success=1');
        exit;
    } else {
        $error = "Error occurred while adding the product!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ6H16u5S3yW9BfHqg9nAdxT71MBfD0zJ2eGh2z4ESaJuxo24Pxp4ehxz9pr" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/admin_add_product.css">
    <script src="assets/js/admin_add_product.js" defer></script>
</head>
<body>
    <div class="container">
        <div class="dashboard-container">
            <h1 class="dashboard-title">Add Product</h1>
            <form action="admin_add_product.php" method="POST" class="add-product-form">
                <!-- Product Name -->
                <div class="input-group">
                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" required placeholder="Enter product name">
                </div>

                <!-- Product Description -->
                <div class="input-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required placeholder="Enter product description"></textarea>
                </div>

                <!-- Product Price -->
                <div class="input-group">
                    <label for="price">Price (THB):</label>
                    <input type="number" step="0.01" id="price" name="price" required placeholder="Enter product price">
                </div>

                <!-- Product Image -->
                <div class="input-group">
                    <label for="image">Image Filename:</label>
                    <input type="text" id="image" name="image" required placeholder="Enter image filename">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn add-btn">Add Product</button>
            </form>

            <!-- Error Message -->
            <?php if (!empty($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
