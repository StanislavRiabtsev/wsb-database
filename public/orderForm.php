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
    $items = $_POST['items'];

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
                $unitPrice = $prodInfo['Price'];
                $orderItem->create($orderId, $prodId, $qty, $unitPrice);
                $total += $unitPrice * $qty;
            }
            $order->updateTotalAmount($orderId, $total);
            $pdo->commit();
            header("Location: orders.php");
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8" />
    <title>Add order</title>
    <script>
        function addItemRow() {
            const container = document.getElementById('items-container');
            const index = container.children.length;
            const row = document.createElement('div');
            row.innerHTML = `
                <select name="items[${index}][ProductID]" required>
                    <option value="">-- Select a product --</option>
                    <?php foreach ($products as $p): ?>
                    <option value="<?= $p['ProductID'] ?>"><?= htmlspecialchars($p['Name']) ?> (Price: <?= $p['Price'] ?>)</option>
                    <?php endforeach; ?>
                </select>
                Quantity: <input type="number" name="items[${index}][Quantity]" value="1" min="1" required>
                <button type="button" onclick="this.parentElement.remove()">Delete</button>
                <br><br>
            `;
            container.appendChild(row);
        }
    </script>
</head>

<body>
    <h1>Add order</h1>
    <form method="post">
        <label>Customer:
            <select name="customer_id" required>
                <option value="">-- Select a castomer --</option>
                <?php foreach ($customers as $c): ?>
                    <option value="<?= $c['customerid'] ?>"><?= htmlspecialchars($c['firstname'] . ' ' . $c['lastname']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <br><br>
        <div id="items-container"></div>
        <button type="button" onclick="addItemRow()">Add product</button>
        <br><br>
        <button type="submit">Create an order</button>
    </form>
    <p><a href="orders.php">Back to orders</a></p>

    <script>
        addItemRow();
    </script>
</body>

</html>