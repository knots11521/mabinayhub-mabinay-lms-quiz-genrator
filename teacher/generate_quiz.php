<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Generate Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function checkScreenSize() {
            if (window.innerWidth >= 768) {
                document.getElementById('sidebar').classList.remove('-translate-x-full');
                document.getElementById('overlay').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                document.getElementById('sidebar').classList.add('-translate-x-full');
            }
        }

        window.addEventListener('resize', checkScreenSize);
    </script>
</head>
<body class="h-screen flex bg-gray-100">

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden md:hidden transition-opacity duration-300" onclick="toggleSidebar()"></div>

    <!-- Include Sidebar -->
    <?php include '../includes/teacher_nav.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-md p-4 flex justify-between items-center md:hidden">
            <button id="burger-btn" class="text-gray-600 text-2xl focus:outline-none" onclick="toggleSidebar()">☰</button>
            <h2 class="text-lg font-bold">Generate Quiz</h2>
        </header>

        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold text-gray-700">Generate a Quiz</h1>

            <form method="POST" class="mt-5 bg-white p-6 shadow-md rounded-lg">
                <label class="block text-gray-700">Quiz Title:</label>
                <input type="text" name="quiz_title" class="w-full p-2 border rounded mt-2" required>
                <button type="submit" class="mt-3 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">Generate</button>
            </form>
        </main>
    </div>

</body>
</html>
