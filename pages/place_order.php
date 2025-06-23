<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_email']) || empty($_SESSION['cart'])) {
    header("Location: user_login.php");
    exit();
}

$cart = $_SESSION['cart'];
$email = $_SESSION['user_email'];

// Get user ID
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();
$user_id = $user['id'];

// Get product info
$placeholders = implode(',', array_fill(0, count($cart), '?'));
$stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->execute(array_keys($cart));
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Insert into orders
$total = 0;
foreach ($products as $p) {
    $qty = $cart[$p['id']];
    $subtotal = $qty * $p['price'];
    $total += $subtotal;

    $stmt = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $p['id'], $qty, $subtotal]);
}

unset($_SESSION['cart']); // clear cart
?>

<!DOCTYPE html>
<html>
<head><title>Order Placed</title></head>
<body>
    <h2>🎉 Order Placed Successfully!</h2>
    <p>Your order total: ₹<?= $total ?></p>
    <a href="products.php">🛒 Buy More</a> |
    <a href="user_dashboard.php">🏠 Dashboard</a>
</body>
</html>
