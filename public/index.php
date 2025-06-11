<?php
require_once __DIR__ . '/../src/Customer.php';
require_once __DIR__ . '/../config/db.php';

$customer = new Customer($pdo);
$customers = $customer->listAll();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <title>Customers</title>
</head>

<body>
    <h1>Customers</h1>
    <a href="customerForm.php">Add a customer</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>CustomerID</th>
                <th>FirstName</th>
                <th>LastName</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['customerid']) ?></td>
                <td><?= htmlspecialchars($c['firstname']) ?></td>
                <td><?= htmlspecialchars($c['lastname']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['phone']) ?></td>
                <td><?= htmlspecialchars($c['address']) ?></td>
                <td>
                    <a href="customerForm.php?id=<?= $c['customerid'] ?>">Edit</a> |
                    <a href="orders.php?customer_id=<?= $c['customerid'] ?>">Orders</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p>
        <a href="orders.php">All orders</a>
        <a href="CategoryView.php">Category</a>
        <a href="SupplierView.php">SupplierView</a>
        <a href="ProductView.php">ProductView</a>
    </p>
</body>

</html>