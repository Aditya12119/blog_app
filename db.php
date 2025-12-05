<?php
$host = 'localhost';
$db   = 'blog';         // your database name
$user = 'root';         // default XAMPP MySQL user
$pass = '';             // default XAMPP MySQL password (empty)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // throw errors
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,    // fetch associative arrays
  PDO::ATTR_EMULATE_PREPARES => false,                 // use real prepared statements
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  exit('Database connection failed: ' . $e->getMessage());
}