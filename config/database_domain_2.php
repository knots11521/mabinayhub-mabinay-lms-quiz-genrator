<?php
$host = "sql204.infinityfree.com"; 
$dbname = "if0_38415544_shmopdb"; // Your actual database name
$username = "if0_38415544"; 
$password = "4cQxAA9L50o0"; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
