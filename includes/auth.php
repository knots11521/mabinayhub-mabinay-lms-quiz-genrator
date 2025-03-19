<?php
session_start();
require_once __DIR__ . '/../config/database.php'; // Ensure database.php is included

if (!isset($pdo)) {
    die("Database connection failed: \$pdo is not set.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query the user from the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id']; // ✅ Store the user's ID
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect user based on role
        switch ($user['role']) {
            case 'admin':
                header("Location: ../admin/dashboard.php");
                break;
            case 'student':
                header("Location: ../student/dashboard.php");
                break;
            case 'teacher':
                header("Location: ../teacher/dashboard.php");
                break;
        }
        exit();
    } else {
        echo "<script>alert('Invalid credentials'); window.location='../public/login.php';</script>";
    }
}
?>
