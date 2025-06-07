<?php
require_once __DIR__ . '/../src/Order.php';

$customerId = 1;
$items = [
    ["ProductID" => 1, "Quantity" => 2],
    ["ProductID" => 2, "Quantity" => 1],
];

addOrderWithItems($customerId, $items);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <H1>SSS</H1>
</body>

</html>