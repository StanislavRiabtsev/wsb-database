<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Category.php';

$category = new Category($pdo);
$categories = $category->listAll();
?>

<h2>Categories</h2>
<a href="categoryForm.php">Add category</a>
<table border="1" cellpadding="5" cellspacing="0">
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
                <a href="deleteCategory.php?id=<?= $c['categoryid'] ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<p><a href="index.php">Return</a></p>