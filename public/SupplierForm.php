<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $suppliername = $_POST['suppliername'] ?? '';
    $contactname = $_POST['contactname'] ?? '';
    $phone = $_POST['phone'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO supplier (suppliername, contactname, phone) VALUES (?, ?, ?)");
    $stmt->execute([$suppliername, $contactname, $phone]);

    header("Location: supplierView.php");
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<h2 class="title">Add New Supplier</h2>
<form class="forms " method="POST">
    <label for="suppliername">Supplier Name:</label><br>
    <input type="text" class="form-control" id="suppliername" name="suppliername" required><br><br>

    <label for="contactname">Contact Name:</label><br>
    <input type="text" class="form-control" id="contactname" name="contactname"><br><br>

    <label for="phone">Phone:</label><br>
    <input type="text" class="form-control" id="phone" name="phone"><br><br>

    <input type="submit" class="btn btn-secondary" value="Save">
</form>