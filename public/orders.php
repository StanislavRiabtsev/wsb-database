<?php
require_once __DIR__ . '/../config/db.php'; // Подключение к базе
require_once __DIR__ . '/../src/Order.php';
require_once __DIR__ . '/../src/Customer.php';

$order = new Order($pdo);
$customer = new Customer($pdo);

$filterCustomerId = $_GET['customer_id'] ?? null;
$orders = [];

if ($filterCustomerId) {
    $stmt = $pdo->prepare("
        SELECT o.orderid, o.orderdate, o.totalamount, c.firstname, c.lastname
        FROM public.orders o
        JOIN public.customer c ON o.customerid = c.customerid
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1 class="title">Orders <?= $filterCustomerId ? "customer: {$customer->firstname} {$customer->lastname}" : '' ?>
    </h1>

    <?php if (!$filterCustomerId): ?>
        <div class="link">
            <button type="button" class="btn btn-secondary">
                <a href="orderForm.php">Add order</a>
            </button>
        </div>
    <?php endif; ?>

    <table border="1" cellpadding="5" cellspacing="0" class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>OrderID</th>
                <th>OrderDate</th>
                <th>Customers</th>
                <th>TotalAmount</th>
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
                        <div class="link">
                            <button type="button" class="btn btn-secondary"><a
                                    href="ordersView.php?id=<?= $o['orderid'] ?>">View</a></button>
                            <button type="button" class="btn btn-secondary"><a
                                    href="orderItemView.php?order_id=<?= $o['orderid'] ?>">Items</a></button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if (!$orders): ?>
                <tr>
                    <td colspan="5">No orders found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="link">
        <button type="button" class="btn btn-secondary">
            <a href="index.php">Return tocustomers</a>
        </button>
    </div>
</body>

</html>