<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: admin_login.php');
    exit;
}

include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the product to edit
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Product not found.");
    }
} else {
    header('Location: admin_dashboard.php');
    exit;
}

// Handle form submission to update product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    // Update product in the database
    $stmt = $conn->prepare("UPDATE products SET name = :name, description = :description, price = :price, image = :image WHERE id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header('Location: admin_dashboard.php?success=1');
        exit;
    } else {
        $error = "Error updating product.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Link to the CSS file -->
    <link rel="stylesheet" href="assets/css/admin_edit_product.css">
    <!-- Link to the JS file -->
    <script src="assets/js/admin_edit_product.js" defer></script>
</head>
<body>
    <div class="dashboard-container">
        <h1 class="dashboard-title">Edit Product</h1>
        <form action="admin_edit_product.php?id=<?php echo $product['id']; ?>" method="POST" class="edit-product-form">
            <div class="input-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required placeholder="Enter product name">
            </div>

            <div class="input-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required placeholder="Enter product description"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

            <div class="input-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required placeholder="Enter price">
            </div>

            <div class="input-group">
                <label for="image">Image Filename:</label>
                <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($product['image']); ?>" required placeholder="Enter image filename">
            </div>

            <button type="submit" class="btn update-btn">Update Product</button>
        </form>

        <p class="error-message" style="opacity: 0;"></p> 
    </div>
</body>
</html>