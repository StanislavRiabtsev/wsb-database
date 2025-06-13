<?php
require_once __DIR__ . '/../src/Product.php';
require_once __DIR__ . '/../src/Category.php';
require_once __DIR__ . '/../src/Supplier.php';
require_once __DIR__ . '/../config/db.php';

$product = new Product($pdo);
$category = new Category($pdo);
$supplier = new Supplier($pdo);

$categories = $category->listAll();
$suppliers = $supplier->listAll();

$id = $_GET['id'] ?? null;
$data = ["names" => "", "descriptions" => "", "price" => "", "stockquantity" => "", "categoryid" => "", "supplierid" => ""];

if ($id && $product->load($id)) {
    $data = get_object_vars($product);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($id) {
        $product->update($id, ...array_values($_POST));
    } else {
        $product->create(...array_values($_POST));
    }
    header('Location: ProductView.php');
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<h2 class="title"><?= $id ? 'Edit' : 'Add' ?> Product</h2>
<form class="forms" method="post">
    <label for="suppliername"> Name:</label>
    <input name="names" class="form-control" value="<?= htmlspecialchars($data['names']) ?>"><br>
    <label for="suppliername"> Description:</label>
    <input name="descriptions" class="form-control" value="<?= htmlspecialchars($data['descriptions']) ?>"><br>
    <label for="suppliername"> Price:</label>
    <input name="price" class="form-control" value="<?= htmlspecialchars($data['price']) ?>"><br>
    <label for="suppliername"> Stock:</label>
    <input name="stockquantity" class="form-control" value="<?= htmlspecialchars($data['stockquantity']) ?>"><br>
    <label for="suppliername"> Category:</label>
    <select class="form-select" name="categoryid">
        <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['categoryid'] ?>" <?= $cat['categoryid'] == $data['categoryid'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['categoryname']) ?>
        </option>
        <?php endforeach; ?>
    </select><br>
    Supplier:
    <select class="form-select" name="supplierid">
        <?php foreach ($suppliers as $sup): ?>
        <option value="<?= $sup['supplierid'] ?>" <?= $sup['supplierid'] == $data['supplierid'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($sup['suppliername']) ?>
        </option>
        <?php endforeach; ?>
    </select><br>
    <button class="btn btn-secondary" type="submit">Save</button>
</form>
<div class="link">
    <button type="button" class="btn btn-secondary">
        <a href="ProductView.php">Back to products</a>
    </button>
</div>