<?php
require_once __DIR__ . '/../config/db.php';

class OrderItem
{
    private $pdo;

    public $OrderItemID;
    public $OrderID;
    public $ProductID;
    public $Quantity;
    public $UnitPrice;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($orderId, $productId, $quantity, $unitPrice)
    {
        $stmt = $this->pdo->prepare("INSERT INTO OrderItem (OrderID, ProductID, Quantity, UnitPrice) VALUES (?, ?, ?, ?)");
        $stmt->execute([$orderId, $productId, $quantity, $unitPrice]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $quantity, $unitPrice)
    {
        $stmt = $this->pdo->prepare("UPDATE OrderItem SET Quantity = ?, UnitPrice = ? WHERE OrderItemID = ?");
        return $stmt->execute([$quantity, $unitPrice, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM OrderItem WHERE OrderItemID = ?");
        return $stmt->execute([$id]);
    }

    public function listByOrder($orderId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM OrderItem WHERE OrderID = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}