<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Supplier.php';

$supplier = new Supplier($pdo);
$suppliers = $supplier->listAll();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<h2 class="title">Suppliers</h2>
<div class="link">
    <button type="button" class="btn btn-secondary">
        <a href="SupplierForm.php">Add supplier</a>
    </button>
</div>
<table border="1" cellpadding="5" cellspacing="0" id="supplier-table"
    class="table table-striped table-hover table-bordered">
    <tr>
        <th>Name</th>
        <th>Contact</th>
        <th>Phone</th>
    </tr>
    <?php foreach ($suppliers as $s): ?>
    <tr>
        <td><?= htmlspecialchars($s['suppliername']) ?></td>
        <td><?= htmlspecialchars($s['contactname']) ?></td>
        <td><?= htmlspecialchars($s['phone']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<div class="link"> <button type="button" class="btn btn-secondary"><a href="index.php">Return to
            customers</a></button></div>

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