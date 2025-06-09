<?php
class Supplier
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function listAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM public.supplier ORDER BY suppliername');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM public.supplier WHERE supplierid = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $contact, $phone)
    {
        $stmt = $this->pdo->prepare('INSERT INTO public.supplier (suppliername, contactname, phone) VALUES (?, ?, ?)');
        $stmt->execute([$name, $contact, $phone]);
        return $this->pdo->lastInsertId();
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM public.supplier WHERE supplierid = ?');
        return $stmt->execute([$id]);
    }
}