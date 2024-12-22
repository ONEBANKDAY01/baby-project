<?php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
} else {
    header('Location: shop.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Success</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h1>Order Success!</h1>
    <p>Thank you for your purchase. Your order ID is <strong><?php echo htmlspecialchars($order_id); ?></strong>.</p>
    <a href="shop.php">Back to Shop</a>
</body>
</html>
