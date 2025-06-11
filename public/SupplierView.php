<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Supplier.php';

$supplier = new Supplier($pdo);
$suppliers = $supplier->listAll();
?>

<h2>Suppliers</h2>
<a href="SupplierForm.php">Add supplier</a>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Name</th>
        <th>Contact</th>
        <th>Phone</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($suppliers as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['suppliername']) ?></td>
            <td><?= htmlspecialchars($s['contactname']) ?></td>
            <td><?= htmlspecialchars($s['phone']) ?></td>
            <td>
                <a href="deleteSupplier.php?id=<?= $s['supplierid'] ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<p><a href="index.php">Return to customers</a></p>