<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Product.php';

$product = new Product($pdo);
$products = $product->listAll();
?>

<h2>Products</h2>
<a href="productForm.php">Add new product</a>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Item Name</th>
        <th>Descriptions</th>
        <th>Price</th>
        <th>Stock Quantity</th>
        <th>Category ID</th>
        <th>Supplier ID</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($products as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= htmlspecialchars($p['description']) ?></td>
            <td><?= htmlspecialchars($p['price']) ?></td>
            <td><?= htmlspecialchars($p['stockquantity']) ?></td>
            <td><?= htmlspecialchars($p['categoryid']) ?></td>
            <td><?= htmlspecialchars($p['supplierid']) ?></td>
            <td>
                <a href="editProduct.php?id=<?= $p['productid'] ?>">Edit</a>
                <a href="deleteProduct.php?id=<?= $p['productid'] ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<p><a href="index.php">Return</a></p>