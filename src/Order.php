<?php
require_once __DIR__ . '/../config/db.php';

class Order
{
    private $pdo;

    public $orderid;
    public $orderdate;
    public $customerid;
    public $totalamount;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function load($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM public.orders WHERE orderid = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $this->fill($data);
            return true;
        }
        return false;
    }

    private function fill($data)
    {
        $this->orderid = $data['orderid'];
        $this->orderdate = $data['orderdate'];
        $this->customerid = $data['customerid'];
        $this->totalamount = $data['totalamount'];
    }

    public function create($customerid, $totalamount = 0)
    {
        $stmt = $this->pdo->prepare('INSERT INTO public.orders (customerid, totalamount) VALUES (?, ?) RETURNING orderid');
        $stmt->execute([$customerid, $totalamount]);
        return $stmt->fetchColumn();
    }

    public function updateTotalAmount($orderid, $totalamount)
    {
        $stmt = $this->pdo->prepare('UPDATE public.orders SET totalamount = ? WHERE orderid = ?');
        return $stmt->execute([$totalamount, $orderid]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM public.orders WHERE orderid = ?');
        return $stmt->execute([$id]);
    }

    public function listAll()
    {
        $stmt = $this->pdo->query('
            SELECT o.orderid, o.orderdate, o.totalamount, c.firstname, c.lastname
            FROM public.orders o
            JOIN public.customer c ON o.customerid = c.customerid
            ORDER BY o.orderdate DESC
        ');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderDetails($orderid)
    {
        // Получаем заказ с клиентом
        $stmt = $this->pdo->prepare('
            SELECT o.orderid, o.orderdate, o.totalamount, c.firstname, c.lastname, c.email, c.phone, c.address
            FROM public.orders o
            JOIN public.customer c ON o.customerid = c.customerid
            WHERE o.orderid = ?
        ');
        $stmt->execute([$orderid]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            return null;
        }

        // Получаем позиции заказа с продуктами
        $stmt = $this->pdo->prepare('
            SELECT oi.OrderItemID, oi.Quantity, oi.UnitPrice,
                   p.Name, p.Description
            FROM public.OrderItem oi
            JOIN public.Product p ON oi.ProductID = p.ProductID
            WHERE oi.orderid = ?
        ');
        $stmt->execute([$orderid]);
        $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $order['Items'] = $orderItems;
        return $order;
    }
}
