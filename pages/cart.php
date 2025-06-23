<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $_SESSION['cart'] = [];
    $orderMessage = "🎉 Order placed successfully!";
}

function fetchProduct($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }
        .cart-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
        }
        .cart-item {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            align-items: center;
        }
        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
        .cart-info {
            flex: 1;
        }
        .cart-info h3 {
            margin: 0;
        }
        .cart-info p {
            margin: 5px 0;
        }
        .remove-btn {
            background-color: red;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .cart-summary {
            text-align: right;
            font-size: 18px;
            margin-top: 20px;
        }
        .place-order {
            width: 100%;
            margin-top: 20px;
            padding: 14px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        .place-order:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="cart-title">🛒 Shopping Cart</h2>

    <?php if (!empty($orderMessage)) echo "<div class='message'>$orderMessage</div>"; ?>

    <?php if (!empty($_SESSION['cart'])): ?>
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $productId => $quantity):
            $product = fetchProduct($conn, $productId);
            if (!$product) continue;
            $subTotal = $product['price'] * $quantity;
            $total += $subTotal;
        ?>
            <div class="cart-item">
                <img src="../admin/uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= $product['name'] ?>">
                <div class="cart-info">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p>Price: ₹<?= $product['price'] ?></p>
                    <p>Quantity: <?= $quantity ?> | Subtotal: ₹<?= $subTotal ?></p>
                </div>
                <form method="GET">
                    <input type="hidden" name="remove" value="<?= $productId ?>">
                    <button class="remove-btn">Remove</button>
                </form>
            </div>
        <?php endforeach; ?>

        <div class="cart-summary">
            <strong>Total: ₹<?= $total ?></strong>
        </div>

        <form method="POST">
            <button type="submit" name="place_order" class="place-order">Place Order</button>
        </form>

    <?php else: ?>
        <p style="text-align:center;">🛒 Your cart is empty.</p>
    <?php endif; ?>
</div>

</body>
</html>
