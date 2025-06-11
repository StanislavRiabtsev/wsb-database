<?php
$host = 'postgres';
$db   = 'store';
$user = 'postgres';
$pass = 'postgres';
$dsn  = "pgsql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $pdo->exec("SET search_path TO public");
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
