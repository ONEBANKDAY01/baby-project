<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// รับข้อมูลผู้ใช้จาก session
$user_id = $_SESSION['user_id'];

// รับการเพิ่มยอดเงินจากฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];

    if (is_numeric($amount) && $amount > 0) {
        // อัปเดตยอดเงินในฐานข้อมูล
        $stmt = $conn->prepare("UPDATE users SET balance = balance + :amount WHERE id = :user_id");
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            $success = "Top-up successful!";
        } else {
            $error = "Error occurred while topping up.";
        }
    } else {
        $error = "Please enter a valid amount.";
    }
}

$stmt = $conn->prepare("SELECT balance FROM users WHERE id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top-up</title>
    <link rel="stylesheet" href="assets/css/topup.css">
</head>
<body>
    <div class="topup-container">
        <h1>Top-up Balance</h1>
        <p>Current Balance: <?php echo number_format($user['balance'], 2); ?> THB</p>

        <form action="topup.php" method="POST" class="topup-form">
            <div class="input-group">
                <label for="amount">Amount to top-up:</label>
                <input type="number" id="amount" name="amount" placeholder="Enter amount" required>
            </div>

            <button type="submit" class="btn">Confirm Top-up</button>
        </form>

        <?php if (!empty($success)): ?>
            <p class="success-message"><?php echo $success; ?></p>
        <?php elseif (!empty($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
