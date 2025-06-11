<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryname = $_POST['categoryname'] ?? '';

    if (!empty($categoryname)) {
        $stmt = $pdo->prepare("INSERT INTO category (categoryname) VALUES (?)");
        $stmt->execute([$categoryname]);

        header("Location: CategoryView.php");
        exit;
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<h2 class="link">Add New Category</h2>
<form class="forms" method="POST">
    <label for="categoryname">Category Name:</label><br>
    <input type="text" class="form-control" id="categoryname" name="categoryname" required><br><br>

    <input type="submit" class="btn btn-secondary" value="Save">
</form>