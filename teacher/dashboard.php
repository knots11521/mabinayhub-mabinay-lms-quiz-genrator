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
    <title>Teacher Dashboard</title>
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

    <!-- Overlay (for mobile) -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden md:hidden transition-opacity duration-300" onclick="toggleSidebar()"></div>

    <!-- Include Sidebar -->
    <?php include '../includes/teacher_nav.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-md p-4 flex justify-between items-center md:hidden">
            <button id="burger-btn" class="text-gray-600 text-2xl focus:outline-none" onclick="toggleSidebar()">☰</button>
            <h2 class="text-lg font-bold">Teacher Dashboard</h2>
        </header>

        <main class="flex-1 p-6">
            <h2 class="text-3xl font-bold text-gray-700">Welcome, Teacher!</h2>

            <!-- Dashboard Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-white p-5 shadow-md rounded-lg text-center">
                    <h2 class="text-xl font-bold text-gray-700">Uploaded Materials</h2>
                    <p class="text-3xl font-semibold text-green-600 mt-2">12</p>
                </div>

                <div class="bg-white p-5 shadow-md rounded-lg text-center">
                    <h2 class="text-xl font-bold text-gray-700">Quizzes Created</h2>
                    <p class="text-3xl font-semibold text-red-600 mt-2">8</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-700 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="upload_materials.php" class="bg-green-500 text-white py-3 px-6 rounded-lg shadow-md text-center hover:bg-green-600 transition">
                        📁 Upload Materials
                    </a>
                    <a href="generate_quiz.php" class="bg-yellow-500 text-white py-3 px-6 rounded-lg shadow-md text-center hover:bg-yellow-600 transition">
                        📝 Generate Quiz
                    </a>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
