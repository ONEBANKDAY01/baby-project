<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: admin_login.php');
    exit;
}

include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ลบคำสั่งซื้อที่เกี่ยวข้องก่อน
    $stmt = $conn->prepare("DELETE FROM orders WHERE product_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // ลบสินค้า
    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header('Location: admin_dashboard.php?success=1');
    } else {
        echo "Error deleting product.";
    }
} else {
    header('Location: admin_dashboard.php');
    exit;
}
?>
