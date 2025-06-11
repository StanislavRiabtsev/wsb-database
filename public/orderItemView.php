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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<h2 class="title">Order Items for Order #<?= htmlspecialchars($orderId) ?></h2>
<table border="1" class="table table-striped table-hover table-bordered">
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
<div class="link">
    <button type="button" class="btn btn-secondary">
        <a href="orders.php">Back to orders</a>
    </button>
</div>