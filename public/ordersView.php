<?php
require_once __DIR__ . '/../src/Order.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/OrderItem.php';

if (!isset($_GET['id'])) {
    die("Order ID not specified");
}

$order = new Order($pdo);
$orderDetails = $order->getOrderDetails((int)$_GET['id']);

if (!$orderDetails) {
    die("Order not found");
}
?>
<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8" />
    <title>Order details</title>
</head>

<body>
    <h1>Order #<?= $orderDetails['orderid'] ?></h1>
    <p><strong>Date:</strong> <?= htmlspecialchars($orderDetails['orderdate']) ?></p>
    <p><strong>Customer:</strong> <?= htmlspecialchars($orderDetails['firstname'] . ' ' . $orderDetails['lastname']) ?>
    </p>
    <p><strong>Sum:</strong> <?= htmlspecialchars($orderDetails['totalamount']) ?></p>

    <h2>Order items</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price per unit</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderDetails['Items'] as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['productname']) ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td><?= htmlspecialchars($item['unitprice']) ?></td>
                    <td><?= htmlspecialchars($item['quantity'] * $item['unitprice']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><a href="orders.php">Back to order list</a></p>
</body>

</html>