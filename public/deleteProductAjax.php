<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Product.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    if ($id) {
        $product = new Product($pdo);
        if ($product->delete($id)) {
            echo json_encode(['success' => true]);
            exit;
        }
    }
}

http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Invalid request or ID']);