<?php
$dbHost = 'localhost';
$dbName = 'vintage_store_db';
$dbUser = 'root';
$dbPassword = '';

try {
    $pdoConnection = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPassword);
    $pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}