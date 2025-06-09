<?php
require_once __DIR__ . '/../src/Order.php';
require_once __DIR__ . '/../src/Customer.php';
require_once __DIR__ . '/../config/db.php';

$order = new Order($pdo);
$customer = new Customer($pdo);

$filterCustomerId = $_GET['customer_id'] ?? null;
$orders = [];

if ($filterCustomerId) {
    $stmt = $pdo->prepare("
        SELECT o.orderid, o.orderdate, o.totalamount, c.firstname, c.lastname
        FROM orders o
        JOIN customer c ON o.customerid = c.customerid
        WHERE c.customerid = ?
        ORDER BY o.orderdate DESC
    ");
    $stmt->execute([$filterCustomerId]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $customer->load($filterCustomerId);
} else {
    $orders = $order->listAll();
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <title>Orders</title>
</head>

<body>
    <h1>Orders <?= $filterCustomerId ? "customer: {$customer->firstname} {$customer->lastname}" : '' ?></h1>
    <?php if (!$filterCustomerId): ?>
        <p><a href="orderForm.php">Add order</a></p>
    <?php endif; ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>OrderID</th>
                <th>Date</th>
                <th>Customers</th>
                <th>Sum</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $o): ?>
                <tr>
                    <td><?= htmlspecialchars($o['orderid']) ?></td>
                    <td><?= htmlspecialchars($o['orderdate']) ?></td>
                    <td><?= htmlspecialchars($o['firstname'] . ' ' . $o['lastname']) ?></td>
                    <td><?= htmlspecialchars($o['totalamount']) ?></td>
                    <td>
                        <a href="orderView.php?id=<?= $o['orderid'] ?>">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$orders) echo '<tr><td colspan="5">No orders found</td></tr>'; ?>
        </tbody>
    </table>
    <p><a href="index.php">Return to customers</a></p>
</body>

</html>