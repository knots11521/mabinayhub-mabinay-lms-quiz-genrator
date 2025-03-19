<?php
session_start();
require_once '../config/database.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../public/index.php");
    exit();
}

// Redirect if no ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Invalid user ID.";
    header("Location: manage_users.php");
    exit();
}

$id = $_GET['id'];

// Fetch user from database
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['error'] = "User not found.";
    header("Location: manage_users.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $username = $_POST['username'];

    $stmt = $pdo->prepare("UPDATE users SET lastname = ?, firstname = ?, username = ? WHERE id = ?");
    $stmt->execute([$lastname, $firstname, $username, $id]);

    $_SESSION['success'] = "User updated successfully!";
    header("Location: manage_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center h-screen bg-gray-100">

    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-xl font-bold mb-4">Edit User</h2>
        <form method="POST">
            <label>Last Name:</label>
            <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']); ?>" class="border p-2 w-full mb-2" required>

            <label>First Name:</label>
            <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']); ?>" class="border p-2 w-full mb-2" required>

            <label>Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']); ?>" class="border p-2 w-full mb-2" required>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            <a href="manage_users.php" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>

</body>
</html>
