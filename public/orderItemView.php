<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/OrderItem.php';

$orderItem = new OrderItem($pdo);
$orderId = $_GET['order_id'] ?? null;

if (!$orderId) {
    die('Order ID is required');
}

$items = $orderItem->listByOrder($orderId);
?>

<h2>Order Items for Order #<?= htmlspecialchars($orderId) ?></h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Product ID</th>
        <th>Quantity</th>
        <th>Unit Price</th>
    </tr>
    <?php foreach ($items as $item): ?>
    <tr>
        <td><?= $item['orderitemid'] ?></td>
        <td><?= $item['productid'] ?></td>
        <td><?= $item['quantity'] ?></td>
        <td><?= $item['unitprice'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="orders.php">Back to orders</a>