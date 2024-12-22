<?php
session_start(); // เริ่มต้น session
include 'config.php';
include 'includes/header.php';

// ตรวจสอบว่ามีสินค้าในตะกร้าหรือไม่
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header('Location: shop.php'); // ถ้าไม่มีสินค้าในตะกร้าให้ไปหน้าร้าน
    exit();
}

// ดึงข้อมูลสินค้าที่อยู่ในตะกร้า
$cartProducts = [];
$total = 0; // ตัวแปรสำหรับคำนวณยอดรวม
if (count($_SESSION['cart']) > 0) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id IN (" . implode(',', $_SESSION['cart']) . ")");
    $stmt->execute();
    $cartProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // คำนวณยอดรวม
    foreach ($cartProducts as $product) {
        $total += $product['price'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="assets/css/checkout.css">
</head>
<body>
    <div class="checkout-container">
        <h1>Checkout</h1>

        <!-- แสดงรายการสินค้าที่อยู่ในตะกร้า -->
        <div class="checkout-products">
            <?php foreach ($cartProducts as $product): ?>
                <div class="checkout-product">
                    <div class="checkout-product-image">
                        <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                    </div>
                    <div class="checkout-product-info">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="price"><?php echo number_format($product['price'], 2); ?> THB</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- แสดงยอดรวม -->
        <div class="checkout-summary">
            <p>Total: <?php echo number_format($total, 2); ?> THB</p>
        </div>

        <!-- ฟอร์มยืนยันการสั่งซื้อ -->
        <form action="process_checkout.php" method="POST">
            <button type="submit" class="checkout-button">Confirm Order</button>
        </form>
    </div>
</body>
</html>
