<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Supplier.php';

$supplier = new Supplier($pdo);
$suppliers = $supplier->listAll();
?>

<h2>Suppliers</h2>
<a href="SupplierForm.php">Add supplier</a>
<table border="1" cellpadding="5" cellspacing="0" id="supplier-table">
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
            <button class="delete-btn" data-id="<?= $s['supplierid'] ?>">Delete</button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<p><a href="index.php">Return to customers</a></p>

<script>
document.querySelectorAll('#supplier-table .delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        if (!confirm('Delete?')) return;

        const id = this.getAttribute('data-id');
        fetch('deleteSupplierAjax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(id)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.closest('tr').remove();
                } else {
                    alert('Failed to delete supplier');
                }
            })
            .catch(() => alert('Error occurred'));
    });
});
</script>