<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Product.php';

$product = new Product($pdo);
$products = $product->listAll();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<h2 class="title">Products</h2>
<div class="link">
    <button type="button" class="btn btn-secondary">
        <a href="productForm.php">Add new product</a>
    </button>
</div>
<table border="1" cellpadding="5" cellspacing="0" id="product-table"
    class="table table-striped table-hover table-bordered">
    <tr>
        <th>Item Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Stock Quantity</th>
        <th>Category ID</th>
        <th>Supplier ID</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($products as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['name'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['description'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['price'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['stockquantity'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['categoryid'] ?? '') ?></td>
            <td><?= htmlspecialchars($p['supplierid'] ?? '') ?></td>
            <td>
                <div class="link">
                    <button class="btn btn-secondary delete-btn"><a
                            href="editProduct.php?id=<?= htmlspecialchars($p['productid'] ?? '') ?>">Edit</a></button>
                    <button class="btn btn-secondary delete-btn"
                        data-id="<?= htmlspecialchars($p['productid'] ?? '') ?>">Delete</button>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="link"> <button type="button" class="btn btn-secondary"><a href="index.php">Return to
            customers</a></button></div>

<script>
    document.querySelectorAll('#product-table .delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (!confirm('Delete?')) return;

            const id = this.getAttribute('data-id');
            fetch('deleteProductAjax.php', {
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
                        alert('Failed to delete product');
                    }
                })
                .catch(() => alert('Error occurred'));
        });
    });
</script>