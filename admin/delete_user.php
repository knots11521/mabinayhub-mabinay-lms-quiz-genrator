<?php
session_start();
require_once '../config/database.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../public/index.php");
    exit();
}

// Check if 'id' is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Invalid user ID.";
    header("Location: manage_users.php");
    exit();
}

$id = $_GET['id'];

// Ensure admin users cannot be deleted
$stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['error'] = "User not found.";
    header("Location: manage_users.php");
    exit();
}

if ($user['role'] === 'admin') {
    $_SESSION['error'] = "Admin users cannot be deleted.";
    header("Location: manage_users.php");
    exit();
}

// Delete user
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);

$_SESSION['success'] = "User deleted successfully!";
header("Location: manage_users.php");
exit();
?>
