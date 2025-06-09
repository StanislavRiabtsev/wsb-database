<?php
require_once __DIR__ . '/../config/db.php';

class Customer
{
    private $pdo;

    public $customerid;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
    public $address;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function load($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM public.customer WHERE customerid = ?');
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
        $this->customerid = $data['customerid'];
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->address = $data['address'];
    }

    public function create($firstName, $lastName, $email, $phone, $address)
    {
        $stmt = $this->pdo->prepare('INSERT INTO public.customer (firstname, lastname, email, phone, address) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$firstName, $lastName, $email, $phone, $address]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $firstName, $lastName, $email, $phone, $address)
    {
        $stmt = $this->pdo->prepare('UPDATE public.customer SET firstname = ?, lastname = ?, email = ?, phone = ?, address = ? WHERE customerid = ?');
        return $stmt->execute([$firstName, $lastName, $email, $phone, $address, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM public.customer WHERE customerid = ?');
        return $stmt->execute([$id]);
    }

    public function listAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM public.customer ORDER BY lastname, firstname');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}