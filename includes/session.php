<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../public/index.php");
    exit();
}

// Function to check role-based access
function checkRole($requiredRole) {
    if ($_SESSION['role'] !== $requiredRole) {
        header("Location: ../public/index.php");
        exit();
    }
}
?>
