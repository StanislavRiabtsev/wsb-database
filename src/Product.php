<?php
require_once __DIR__ . '/../config/db.php';

class Product
{
    private $pdo;

    public $productid;
    public $names;
    public $descriptions;
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
        $this->names = $data['names'];
        $this->descriptions = $data['descriptions'];
        $this->price = $data['price'];
        $this->stockquantity = $data['stockquantity'];
        $this->categoryid = $data['categoryid'];
        $this->supplierid = $data['supplierid'];
    }

    public function create($name, $desc, $price, $stockQty, $categoryId, $supplierId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO product (names, descriptions, price, stockquantity, categoryid, supplierid) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $desc, $price, $stockQty, $categoryId, $supplierId]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $name, $desc, $price, $stockQty, $categoryId, $supplierId)
    {
        $stmt = $this->pdo->prepare("UPDATE product SET names = ?, descriptions = ?, price = ?, stockquantity = ?, categoryid = ?, supplierid = ? WHERE productid = ?");
        return $stmt->execute([$name, $desc, $price, $stockQty, $categoryId, $supplierId, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM product WHERE productid = ?");
        return $stmt->execute([$id]);
    }

    public function listAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM product ORDER BY names");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}