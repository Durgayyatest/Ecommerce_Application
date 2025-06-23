<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Delete product if delete_id is sent via GET
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // First fetch the image to delete from folder
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if ($product && $product['image']) {
        $imagePath = 'uploads/' . $product['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete image from folder
        }
    }

    // Now delete from DB
    $deleteStmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $deleteStmt->execute([$id]);

    header("Location: manage_products.php"); // Refresh the page
    exit();
}

// Get all products
$products = $conn->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 40px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        img {
            width: 80px;
            height: auto;
            border-radius: 4px;
        }

        .actions a {
            padding: 6px 10px;
            background: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .actions a:hover {
            background: #c82333;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    <h2>Manage Products</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Price (₹)</th>
            <th>Description</th>
            <th>Action</th>
        </tr>

        <?php foreach ($products as $product): ?>
        <tr>
            <td><?= htmlspecialchars($product['id']) ?></td>
            <td>
                <?php if ($product['image']): ?>
                    <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="Product Image">
                <?php else: ?>
                    No Image
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($product['name']) ?></td>
            <td><?= htmlspecialchars($product['price']) ?></td>
            <td><?= htmlspecialchars($product['description']) ?></td>
            <td class="actions">
                <a href="manage_products.php?delete_id=<?= $product['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
