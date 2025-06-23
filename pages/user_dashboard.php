<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: user_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        body {
            margin: 0;
            height:100vh;
            width:100%;
            font-family: Arial, sans-serif;
            background-image: url('https://bizflyportal.mediacdn.vn/thumb_wm/1000,100/bizflyportal/images/tieu-chi-danh-gia-website-thuong-mai-dien-tu-bizfly-002-17072097596156.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }


        .navbar {
            background-color: #007bff;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            font-size: 20px;
            color: white;
            font-weight: bold;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .content {
            padding: 40px;
            text-align: center;
        }

        .content h2 {
            color: #333;
        }

        .welcome {
            font-size: 18px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">🛒 MyShop Dashboard</div>
        <div class="menu">
            <a href="user_dashboard.php">Home</a>
            <a href="view_products.php">View Products</a>
            <a href="cart.php">My Cart</a>
            <a href="orders.php">My Orders</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="content">
        <h2>Welcome to Your Dashboard</h2>
        <p class="welcome">Logged in as <strong><?= htmlspecialchars($_SESSION['user_email']) ?></strong></p>
    </div>

</body>
</html>
