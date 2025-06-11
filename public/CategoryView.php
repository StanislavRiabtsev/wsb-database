<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Category.php';

$category = new Category($pdo);
$categories = $category->listAll();
?>

<h2>Categories</h2>
<a href="categoryForm.php">Add category</a>
<table border="1" cellpadding="5" cellspacing="0" id="category-table">
    <tr>
        <th>CategoryID</th>
        <th>CategoryName</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($categories as $c): ?>
    <tr>
        <td><?= $c['categoryid'] ?></td>
        <td><?= htmlspecialchars($c['categoryname']) ?></td>
        <td>
            <button class="delete-btn" data-id="<?= $c['categoryid'] ?>">Delete</button>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<p><a href="index.php">Return</a></p>

<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        if (!confirm('Delete?')) return;

        const id = this.getAttribute('data-id');
        fetch('deleteCategoryAjax.php', {
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
                    alert('Failed to delete category');
                }
            })
            .catch(() => alert('Error occurred'));
    });
});
</script>