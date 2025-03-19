<?php
session_start();
require_once '../config/database.php'; 

if (!isset($_SESSION['preview_data']) || empty($_SESSION['preview_data'])) {
    $_SESSION['error'] = "No data to confirm.";
    header("Location: ../admin/add_users.php");
    exit();
}

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO users (lastname, firstname, username, role, password, created_at) VALUES (?, ?, ?, ?, ?, NOW())");

    $existingUsersStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");

    foreach ($_SESSION['preview_data'] as $user) {
        $existingUsersStmt->execute([$user[2]]);
        if ($existingUsersStmt->fetchColumn()) {
            throw new Exception("Username " . htmlspecialchars($user[2]) . " already exists.");
        }

        if (empty($user[4])) {
            throw new Exception("Missing password for " . htmlspecialchars($user[2]));
        }

        $hashed_password = password_hash($user[4], PASSWORD_DEFAULT);
        $stmt->execute([$user[0], $user[1], $user[2], $user[3], $hashed_password]);
    }

    $pdo->commit();
    unset($_SESSION['preview_data']);
    $_SESSION['success'] = "Users successfully added!";
} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['error'] = "Failed to add users: " . $e->getMessage();
}

header("Location: ../admin/add_users.php");
exit();
?>
