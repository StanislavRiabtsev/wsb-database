<?php
require_once __DIR__ . '/config/db.php';
require_once 'src/Customer.php';
require_once 'src/Product.php';
require_once 'src/Order.php';
require_once 'src/OrderItem.php';

$dsn = "pgsql:host=localhost;dbname=store";
$username = "postgres";
$password = "password";

$pdo = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$customer = new Customer($pdo);
$customerId = $customer->create('Jan', 'Kowalski', 'jan@mail.com', '123456789', 'Warsaw, Poland');

$order = new Order($pdo);
$orderId = $order->create($customerId);

$orderItem = new OrderItem($pdo);
$orderItem->create($orderId, 1, 2, 10.99);
$orderItem->create($orderId, 2, 1, 5.49);

$total = 2 * 10.99 + 1 * 5.49;
$order->updateTotalAmount($orderId, $total);

$orderDetails = $order->getOrderDetails($orderId);
echo "<pre>" . print_r($orderDetails, true) . "</pre>";