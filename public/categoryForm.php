<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryname = $_POST['categoryname'] ?? '';

    if (!empty($categoryname)) {
        $stmt = $pdo->prepare("INSERT INTO category (categoryname) VALUES (?)");
        $stmt->execute([$categoryname]);

        header("Location: CategoryView.php"); // можно изменить на нужный файл
        exit;
    }
}
?>

<h2>Add New Category</h2>
<form method="POST">
    <label for="categoryname">Category Name:</label><br>
    <input type="text" id="categoryname" name="categoryname" required><br><br>

    <input type="submit" value="Save">
</form>