<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $suppliername = $_POST['suppliername'] ?? '';
    $contactname = $_POST['contactname'] ?? '';
    $phone = $_POST['phone'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO supplier (suppliername, contactname, phone) VALUES (?, ?, ?)");
    $stmt->execute([$suppliername, $contactname, $phone]);

    header("Location: supplierView.php"); // или другой файл, куда должен перейти пользователь
    exit;
}
?>

<h2>Add New Supplier</h2>
<form method="POST">
    <label for="suppliername">Supplier Name:</label><br>
    <input type="text" id="suppliername" name="suppliername" required><br><br>

    <label for="contactname">Contact Name:</label><br>
    <input type="text" id="contactname" name="contactname"><br><br>

    <label for="phone">Phone:</label><br>
    <input type="text" id="phone" name="phone"><br><br>

    <input type="submit" value="Save">
</form>