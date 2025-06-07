<?php
require_once __DIR__ . '/../config/db.php';

function addOrderWithItems($customerId, $items)
{
    global $pdo;

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("
            SELECT add_order_with_items(
                CAST(:customer_id AS INT),
                CAST(:items AS JSON)
            )
        ");
        $stmt = $pdo->prepare("SELECT add_order_with_items(:customer_id, :items::json)");
        $stmt->bindValue(':customer_id', $customerId, PDO::PARAM_INT);
        $stmt->bindValue(':items', json_encode($items), PDO::PARAM_STR);


        $pdo->commit();
        echo "Zamówienie zostało złożone.";
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Błąd: " . $e->getMessage();
    }
}