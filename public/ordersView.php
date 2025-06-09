<?php
require_once __DIR__ . '/../src/Order.php';
require_once __DIR__ . '/../config/db.php';

if (!isset($_GET['id'])) {
    die("Не указан ID заказа");
}

$order = new Order($pdo);
$orderDetails = $order->getOrderDetails((int)$_GET['id']);

if (!$orderDetails) {
    die("Заказ не найден");
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <title>Детали заказа</title>
</head>

<body>
    <h1>Заказ #<?= $orderDetails['OrderID'] ?></h1>
    <p><strong>Дата:</strong> <?= htmlspecialchars($orderDetails['OrderDate']) ?></p>
    <p><strong>Клиент:</strong> <?= htmlspecialchars($orderDetails['CustomerName']) ?></p>
    <p><strong>Сумма:</strong> <?= htmlspecialchars($orderDetails['TotalAmount']) ?></p>

    <h2>Позиции заказа</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Продукт</th>
                <th>Количество</th>
                <th>Цена за единицу</th>
                <th>Сумма</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderDetails['Items'] as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['ProductName']) ?></td>
                <td><?= htmlspecialchars($item['Quantity']) ?></td>
                <td><?= htmlspecialchars($item['UnitPrice']) ?></td>
                <td><?= htmlspecialchars($item['Quantity'] * $item['UnitPrice']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><a href="orders.php">Вернуться к списку заказов</a></p>
</body>

</html>