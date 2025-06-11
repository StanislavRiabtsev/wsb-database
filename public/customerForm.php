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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1 class="title"><?= $editing ? 'Edit customer' : 'Add a customer' ?></h1>
    <form class="forms" method="post">
        <?php if ($editing): ?>
        <input type="hidden" class="form-control" name="id" value="<?= (int)$_GET['id'] ?>">
        <?php endif; ?>
        <label>First Name:<br>
            <input type="text" class="form-control" name="FirstName" required
                value="<?= htmlspecialchars($data['FirstName']) ?>">
        </label><br><br>
        <label>Last Name:<br>
            <input type="text" class="form-control" name="LastName" required
                value="<?= htmlspecialchars($data['LastName']) ?>">
        </label><br><br>
        <label>Email:<br>
            <input type="email" class="form-control" name="Email" required
                value="<?= htmlspecialchars($data['Email']) ?>">
        </label><br><br>
        <label>Phone:<br>
            <input type="text" class="form-control" name="Phone" value="<?= htmlspecialchars($data['Phone']) ?>">
        </label><br><br>
        <label>Address:<br>
            <textarea class="form-control" name="Address"><?= htmlspecialchars($data['Address']) ?></textarea>
        </label><br><br>
        <button type="submit" class="btn btn-secondary">Save</button>
    </form>
    <div class="link">
        <button type="button" class="btn btn-secondary">
            <a href="index.php">Back to customer list</a>
        </button>
    </div>
</body>

</html>