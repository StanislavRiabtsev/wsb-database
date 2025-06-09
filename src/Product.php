<?php
require_once __DIR__ . '/../config/db.php';

class Product
{
    private $pdo;

    public $productid;
    public $name;
    public $description;
    public $price;
    public $stockquantity;
    public $categoryid;
    public $supplierid;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function load($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE productid = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $this->fill($data);
            return true;
        }
        return false;
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE productid = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function fill($data)
    {
        $this->productid = $data['productid'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->price = $data['price'];
        $this->stockquantity = $data['stockquantity'];
        $this->categoryid = $data['categoryid'];
        $this->supplierid = $data['supplierid'];
    }

    public function create($name, $description, $price, $stockquantity, $categoryid, $supplierid)
    {
        $stmt = $this->pdo->prepare("INSERT INTO public.product (name, description, price, stockquantity, categoryid, supplierid) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $stockquantity, $categoryid, $supplierid]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $name, $description, $price, $stockquantity, $categoryid, $supplierid)
    {
        $stmt = $this->pdo->prepare("UPDATE public.product SET name = ?, description = ?, price = ?, stockquantity = ?, categoryid = ?, supplierid = ? WHERE productid = ?");
        return $stmt->execute([$name, $description, $price, $stockquantity, $categoryid, $supplierid, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM public.product WHERE productid = ?");
        return $stmt->execute([$id]);
    }

    public function listAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM public.product ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}