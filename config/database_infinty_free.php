<?php
$host = "sql308.infinityfree.com"; 
$dbname = "if0_38328599_shmopdb"; // Your actual database name
$username = "if0_38328599"; 
$password = "dC2AXHLcoYbwH"; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
