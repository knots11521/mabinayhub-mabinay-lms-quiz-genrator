<?php
session_start();
if (isset($_SESSION['role'])) {
    header("Location: ../" . $_SESSION['role'] . "/dashboard.php");
    exit();
}

// Handle error messages from authentication
$error = isset($_GET['error']) ? $_GET['error'] : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Skwela Hub Mabinay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const icon = document.getElementById("eye-icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }

        function toggleMenu() {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        }
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 1.5s ease-in-out;
        }
        input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.4);
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">

<!-- Navigation Bar (Fixed) -->
<header class="w-full bg-white shadow-md fixed top-0 left-0 right-0 z-50">
    <div class="max-w-6xl mx-auto flex justify-between items-center p-4">
        <h1 class="text-2xl font-bold">SHM</h1>
        <nav class="hidden md:flex">
            <ul class="flex space-x-6">
                <li><a href="index.php" class="hover:text-blue-500 transition">Home</a></li>
                <li><a href="#" class="hover:text-blue-500 transition">About</a></li>
                <li><a href="login.php" class="hover:text-blue-500 transition">Login</a></li>
            </ul>
        </nav>
        <button class="md:hidden focus:outline-none" onclick="toggleMenu()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>
    <div id="mobile-menu" class="hidden md:hidden bg-white shadow-md">
        <ul class="flex flex-col space-y-4 p-4">
            <li><a href="index.php" class="block hover:text-blue-500 transition">Home</a></li>
            <li><a href="#" class="block hover:text-blue-500 transition">About</a></li>
            <li><a href="login.php" class="block hover:text-blue-500 transition">Login</a></li>
        </ul>
    </div>
</header>

<!-- Main Content (Login Form) -->
<div class="flex items-center justify-center min-h-screen bg-gray-100 transition-all duration-300 pt-20">

    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-full max-w-md mx-4 sm:mx-0 animate-fadeIn">

        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Login</h2>

        <?php if (!empty($error)) : ?>
            <p class="bg-red-100 text-red-600 p-3 rounded-md text-center mb-4">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <form action="../includes/auth.php" method="POST">
            <div class="mb-4">
                <input type="text" name="username" placeholder="Username"
                       class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 transition" required>
            </div>

            <div class="mb-6 relative">
                <input type="password" id="password" name="password" placeholder="Password"
                       class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 transition" required>
                <button type="button" onclick="togglePassword()" class="absolute top-3 right-3 text-gray-500">
                    <i id="eye-icon" class="fas fa-eye"></i>
                </button>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white font-semibold p-3 rounded-md hover:bg-blue-700 transition transform hover:scale-105">
                Login
            </button>
        </form>

        <div class="mt-4 text-center text-gray-600 text-sm">
            <a href="#" class="hover:text-blue-500 transition">Forgot password?</a>
        </div>
    </div>
</div>

</body>
</html>
