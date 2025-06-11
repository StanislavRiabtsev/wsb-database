<?php
require_once __DIR__ . '/../config/db.php';

class OrderItem
{
    private $pdo;

    public $orderitemid;
    public $orderid;
    public $productid;
    public $quantity;
    public $unitprice;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($orderid, $productid, $quantity, $unitprice)
    {
        $stmt = $this->pdo->prepare("INSERT INTO public.orderitem (orderid, productid, quantity, unitprice) VALUES (?, ?, ?, ?)");
        $stmt->execute([$orderid, $productid, $quantity, $unitprice]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $quantity, $unitprice)
    {
        $stmt = $this->pdo->prepare("UPDATE public.orderitem SET quantity = ?, unitprice = ? WHERE orderitemid = ?");
        return $stmt->execute([$quantity, $unitprice, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM public.orderitem WHERE orderitemid = ?");
        return $stmt->execute([$id]);
    }

    public function listByOrder($orderid)
    {
        $stmt = $this->pdo->prepare("
    SELECT oi.*, p.name as product_name
    FROM public.orderitem oi
    JOIN public.product p ON oi.productid = p.productid
    WHERE oi.orderid = ?
");
        $stmt->execute([$orderid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
