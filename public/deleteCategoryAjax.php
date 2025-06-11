<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Category.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    if ($id) {
        $category = new Category($pdo);
        if ($category->delete($id)) {
            echo json_encode(['success' => true]);
            exit;
        }
    }
}

http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Invalid request or ID']);
