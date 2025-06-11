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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1 class="title">Customers</h1>
    <div class="link">
        <button type="button" class="btn btn-secondary">
            <a href="customerForm.php">Add a customer</a>
        </button>
    </div>
    <table border="1" cellpadding="5" cellspacing="0" class="table table-striped table-hover table-bordered">
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
                        <div class="link">
                            <button type="button" class="btn btn-secondary">
                                <a href="customerForm.php?id=<?= $c['customerid'] ?>">Edit</a>
                            </button>
                            <button type="button" class="btn btn-secondary">
                                <a href="orders.php?customer_id=<?= $c['customerid'] ?>">Orders</a>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="link">
        <button type="button" class="btn btn-secondary"><a href="orders.php">All orders</a></button>
        <button type="button" class="btn btn-secondary"><a href="CategoryView.php">Category</a></button>
        <button type="button" class="btn btn-secondary"><a href="SupplierView.php">Supplier</a></button>
        <button type="button" class="btn btn-secondary"><a href="ProductView.php">Product</a></button>
    </div>
</body>

</html>