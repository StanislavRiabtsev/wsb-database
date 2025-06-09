<?php
require_once __DIR__ . '/../config/db.php';

class Category
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function listAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM public.category ORDER BY categoryname");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM public.category WHERE categoryid = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($categoryName)
    {
        $stmt = $this->pdo->prepare("INSERT INTO public.category (categoryname) VALUES (?)");
        $stmt->execute([$categoryName]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $categoryName)
    {
        $stmt = $this->pdo->prepare("UPDATE public.category SET categoryname = ? WHERE categoryid = ?");
        return $stmt->execute([$categoryName, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM public.category WHERE categoryid = ?");
        return $stmt->execute([$id]);
    }
}