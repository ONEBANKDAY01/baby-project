<?php
session_start(); // เริ่มต้น session เพื่อใช้งานตะกร้า
include 'config.php';
include 'includes/header.php';

// ตรวจสอบว่าในตะกร้ามีสินค้าหรือไม่
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $cartEmpty = true;
} else {
    $cartEmpty = false;
    // ดึงข้อมูลสินค้าที่เลือกจากฐานข้อมูล
    $productIds = implode(',', $_SESSION['cart']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($productIds)");
    $stmt->execute();
    $productsInCart = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ลบสินค้าจากตะกร้า
if (isset($_GET['remove_id'])) {
    $removeId = $_GET['remove_id'];
    if (($key = array_search($removeId, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="assets/css/cart.css">
    <script src="assets/js/cart.js" defer></script>
</head>
<body>
    <div class="cart-container">
        <h1 class="cart-title">Your Shopping Cart</h1>

        <?php if ($cartEmpty): ?>
            <p class="cart-empty">Your cart is empty. <a href="shop.php">Shop now</a></p>
        <?php else: ?>
            <div class="cart-items">
                <?php foreach ($productsInCart as $product): ?>
                    <div class="cart-item">
                        <div class="cart-item-image">
                            <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                        </div>
                        <div class="cart-item-info">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="price"><?php echo htmlspecialchars($product['price']); ?> THB</p>
                            <a href="cart.php?remove_id=<?php echo $product['id']; ?>" class="remove-item">Remove</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary">
                <p>Total: <?php
                    $total = 0;
                    foreach ($productsInCart as $product) {
                        $total += $product['price'];
                    }
                    echo $total;
                ?> THB</p>
                <a href="checkout.php" class="checkout-button">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
