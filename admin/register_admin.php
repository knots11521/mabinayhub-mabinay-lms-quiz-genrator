<?php
require '../config/database.php';

$check = $pdo->query("SELECT COUNT(*) FROM users WHERE role='admin'")->fetchColumn();
$message = "";

if ($check > 0) {
    $message = "<p class='text-red-500 text-center'>An admin account already exists.</p>";
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $message = "<p class='text-red-500 text-center'>All fields are required.</p>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
        $stmt->execute([$username, $hashedPassword]);
        $message = "<p class='text-green-500 text-center'>Admin registered successfully.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100 px-4">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-4">Register Admin</h2>
        
        <?php if (!empty($message)) echo "<div class='mb-4'>$message</div>"; ?>

        <?php if ($check == 0): ?>
            <form action="" method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-600 mb-1">Username</label>
                    <input type="text" name="username" placeholder="Enter username"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="block text-gray-600 mb-1">Password</label>
                    <input type="password" name="password" placeholder="Enter password"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 text-white p-3 rounded-lg font-semibold hover:bg-blue-600 transition duration-300">
                    Register
                </button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
