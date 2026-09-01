<?php
try {
    $pdoConnection = new PDO("mysql:host=localhost;dbname=vintage_store_db;charset=utf8mb4", "root", "");
} catch (PDOException $e) {
    die($e->getMessage());
}