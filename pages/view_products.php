<?php
session_start();
include '../includes/db.php';

// Initialize cart session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to cart logic
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id'], $_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = max(1, (int)$_POST['quantity']);

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }

    $addedMessage = "✅ Product added to cart!";
}

// Fetch products
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .container {
            padding: 30px;
        }
        .product-card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            width: 250px;
            margin: 10px;
            display: inline-block;
            vertical-align: top;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .product-card h3, .product-card p {
            margin: 8px 0;
        }
        .product-card form {
            margin-top: 10px;
        }
        .product-card input[type="number"] {
            width: 60px;
            padding: 5px;
        }
        .product-card button {
            background: #007bff;
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            margin-left: 10px;
            cursor: pointer;
        }
        .message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🛍️ Browse Products</h2>
    <?php if (!empty($addedMessage)) echo "<div class='message'>$addedMessage</div>"; ?>
    
    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <img src="../admin/uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p>₹<?= $product['price'] ?></p>
            <form method="POST">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <label>Qty:</label>
                <input type="number" name="quantity" value="1" min="1">
                <button type="submit">Add to Cart</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
