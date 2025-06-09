<?php
// productForm.php
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
<h2><?= $id ? 'Edit' : 'Add' ?> Product</h2>
<form method="post">
    Name: <input name="names" value="<?= htmlspecialchars($data['names']) ?>"><br>
    Description: <input name="descriptions" value="<?= htmlspecialchars($data['descriptions']) ?>"><br>
    Price: <input name="price" value="<?= htmlspecialchars($data['price']) ?>"><br>
    Stock: <input name="stockquantity" value="<?= htmlspecialchars($data['stockquantity']) ?>"><br>
    Category:
    <select name="categoryid">
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['categoryid'] ?>" <?= $cat['categoryid'] == $data['categoryid'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['categoryname']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    Supplier:
    <select name="supplierid">
        <?php foreach ($suppliers as $sup): ?>
            <option value="<?= $sup['supplierid'] ?>" <?= $sup['supplierid'] == $data['supplierid'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($sup['suppliername']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">Save</button>
</form>
<a href="ProductView.php">Back to products</a>