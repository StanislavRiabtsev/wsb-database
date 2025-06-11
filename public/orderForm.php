<?php
require_once __DIR__ . '/../src/Customer.php';
require_once __DIR__ . '/../src/Product.php';
require_once __DIR__ . '/../src/Order.php';
require_once __DIR__ . '/../src/OrderItem.php';
require_once __DIR__ . '/../config/db.php';

$customer = new Customer($pdo);
$product = new Product($pdo);
$order = new Order($pdo);
$orderItem = new OrderItem($pdo);

$customers = $customer->listAll();
$products = $product->listAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerId = (int)$_POST['customer_id'];
    $items = $_POST['items'] ?? [];

    if ($customerId && $items && is_array($items)) {
        try {
            $pdo->beginTransaction();
            $orderId = $order->create($customerId);
            $total = 0;
            foreach ($items as $item) {
                $prodId = (int)$item['ProductID'];
                $qty = (int)$item['Quantity'];
                if ($qty <= 0) continue;
                $prodInfo = $product->getById($prodId);
                if (!$prodInfo) continue;
                $unitPrice = $prodInfo['price'];
                $orderItem->create($orderId, $prodId, $qty, $unitPrice);
                $total += $unitPrice * $qty;
            }
            $order->updateTotalAmount($orderId, $total);
            $pdo->commit();
            header("Location: orders.php");
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8" />
    <title>Add order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script>
    function addItemRow() {
        const container = document.getElementById('items-container');
        const index = container.children.length;
        const row = document.createElement('div');
        row.innerHTML = document.getElementById('product-options-template').innerHTML.replaceAll('__INDEX__', index);
        container.appendChild(row);
    }
    </script>
</head>

<body>
    <h1 class="title">Add order</h1>
    <form class="form-order" method="post">
        <label>Customer:
            <select class="form-select" name="customer_id" required>
                <option value="">-- Select a customer --</option>
                <?php foreach ($customers as $c): ?>
                <option value="<?= htmlspecialchars($c['customerid']) ?>">
                    <?= htmlspecialchars($c['firstname'] . ' ' . $c['lastname']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </label>
        <br><br>

        <div id="items-container"></div>
        <button class="btn btn-secondary" type="button" onclick="addItemRow()">Add product</button>
        <br><br>
        <button class="btn btn-secondary" type="submit">Create an order</button>
    </form>
    <div class="link">
        <button type="button" class="btn btn-secondary">
            <a href="orders.php">Back to orders</a>
        </button>
    </div>

    <template id="product-options-template">
        <div class="item-row">
            <select class="form-select" name="items[__INDEX__][ProductID]" required>
                <option value="">-- Select a product --</option>
                <?php foreach ($products as $p): ?>
                <option value="<?= htmlspecialchars($p['productid']) ?>">
                    <?= htmlspecialchars($p['name']) ?> (Price: <?= htmlspecialchars($p['price']) ?>)
                </option>
                <?php endforeach; ?>
            </select>
            <input class="form-control" type="number" name="items[__INDEX__][Quantity]" value="1" min="1" required>
            <div class="link">
                <button class="btn btn-danger btn-order" type="button"
                    onclick="this.parentElement.remove()">Delete</button>
            </div>
        </div>
    </template>


    <script>
    addItemRow();
    </script>
</body>

</html>