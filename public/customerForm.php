<?php
require_once __DIR__ . '/../src/Customer.php';
require_once __DIR__ . '/../config/db.php';

$customer = new Customer($pdo);
$editing = false;
$data = [
    'FirstName' => '',
    'LastName' => '',
    'Email' => '',
    'Phone' => '',
    'Address' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $editing = true;
    $id = (int)$_GET['id'];
    if ($customer->load($id)) {
        $data = [
            'FirstName' => $customer->firstname,
            'LastName' => $customer->lastname,
            'Email' => $customer->email,
            'Phone' => $customer->phone,
            'Address' => $customer->address,
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['FirstName'] ?? '';
    $lastName = $_POST['LastName'] ?? '';
    $email = $_POST['Email'] ?? '';
    $phone = $_POST['Phone'] ?? '';
    $address = $_POST['Address'] ?? '';

    if (isset($_POST['id']) && $_POST['id']) {
        $customer->update((int)$_POST['id'], $firstName, $lastName, $email, $phone, $address);
    } else {
        $customer->create($firstName, $lastName, $email, $phone, $address);
    }
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <title><?= $editing ? 'Edit customer' : 'Add a customer' ?></title>
</head>

<body>
    <h1><?= $editing ? 'Edit customer' : 'Add a customer' ?></h1>
    <form method="post">
        <?php if ($editing): ?>
            <input type="hidden" name="id" value="<?= (int)$_GET['id'] ?>">
        <?php endif; ?>
        <label>Name:<br>
            <input type="text" name="FirstName" required value="<?= htmlspecialchars($data['FirstName']) ?>">
        </label><br><br>
        <label>Surname:<br>
            <input type="text" name="LastName" required value="<?= htmlspecialchars($data['LastName']) ?>">
        </label><br><br>
        <label>Email:<br>
            <input type="email" name="Email" required value="<?= htmlspecialchars($data['Email']) ?>">
        </label><br><br>
        <label>Phone:<br>
            <input type="text" name="Phone" value="<?= htmlspecialchars($data['Phone']) ?>">
        </label><br><br>
        <label>Address:<br>
            <textarea name="Address"><?= htmlspecialchars($data['Address']) ?></textarea>
        </label><br><br>
        <button type="submit">Save</button>
    </form>
    <p><a href="index.php">Back to customer list</a></p>
</body>

</html>