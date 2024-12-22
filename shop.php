<?php
session_start(); // เริ่มต้น session เพื่อใช้งานการเก็บข้อมูลในตะกร้า
include 'config.php';
include 'includes/header.php';

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // ดึงข้อมูลยอดเงินของผู้ใช้จากฐานข้อมูล
    $stmt = $conn->prepare("SELECT balance FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ถ้าผู้ใช้มีข้อมูลยอดเงิน, ให้เก็บไว้ในตัวแปร
    if ($user) {
        $balance = $user['balance'];
    } else {
        $balance = 0.00;
    }
} else {
    // ถ้าไม่ได้ล็อกอิน, ยอดเงินคือ 0
    $balance = 0.00;
}

// ค้นหาสินค้า
$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE :search OR description LIKE :search");
    $stmt->bindValue(':search', '%' . $search . '%');
} else {
    $stmt = $conn->prepare("SELECT * FROM products");
}
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ตรวจสอบว่าได้รับการเพิ่มสินค้าลงในตะกร้าหรือไม่
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // ตรวจสอบว่าผลิตภัณฑ์นี้อยู่ในตะกร้าแล้วหรือไม่
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // เพิ่มสินค้าลงในตะกร้า
    $_SESSION['cart'][] = $product_id;

    // เปลี่ยนเส้นทางไปยังหน้าชำระเงินหลังจากเพิ่มสินค้าลงตะกร้า
    header("Location: checkout.php");
    exit(); // หลังจาก header(), ต้องใช้ exit() เพื่อหยุดการทำงานของสคริปต์
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game ID Shop</title>
    <link rel="stylesheet" href="assets/css/shop.css">
    <script src="assets/js/shop.js" defer></script>
</head>
<body>
    <div class="shop-container">
        <h1 class="shop-title">Welcome to Game ID Shop</h1>

        <!-- แสดงยอดเงินที่มีในระบบ -->
        <div class="user-balance">
            <p>Balance: <?php echo number_format($balance, 2); ?> THB</p>
        </div>

        <div class="products">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                        </div>
                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="price"><?php echo htmlspecialchars($product['price']); ?> THB</p>
                            <!-- ลิงก์เพิ่มสินค้าไปยังตะกร้า และไปหน้าชำระเงิน -->
                            <a href="shop.php?product_id=<?php echo $product['id']; ?>" class="add-to-cart">Add to Cart</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-products">No products found!</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
