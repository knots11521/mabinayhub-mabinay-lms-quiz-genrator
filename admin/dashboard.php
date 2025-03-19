<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../public/index.php");
    exit();
}

require_once '../config/database.php';

// Fetch quick counts for dashboard widgets
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalTeachers = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'teacher'")->fetchColumn();
$totalStudents = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
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

<!-- Sidebar (admin_nav.php) -->
<?php include '../includes/admin_nav.php'; ?>

<!-- Main Content -->
<div class="flex-1 flex flex-col">
    <header class="bg-white shadow-md p-4 flex justify-between items-center md:hidden">
        <button id="burger-btn" class="text-gray-600 text-2xl focus:outline-none" onclick="toggleSidebar()">☰</button>
        <h2 class="text-lg font-bold">Admin Dashboard</h2>
    </header>

    <main class="flex-1 p-6 space-y-6">

        <h2 class="text-2xl font-bold text-gray-800">Welcome, Admin</h2>

        <!-- Quick Stats (Summary) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h3 class="text-lg font-semibold">Total Users</h3>
                <p class="text-3xl font-bold mt-2"><?= $totalUsers; ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h3 class="text-lg font-semibold">Teachers</h3>
                <p class="text-3xl font-bold mt-2"><?= $totalTeachers; ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h3 class="text-lg font-semibold">Students</h3>
                <p class="text-3xl font-bold mt-2"><?= $totalStudents; ?></p>
            </div>
        </div>

        <!-- Quick Links (Navigation Shortcuts) -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="manage_users.php" class="bg-blue-500 text-white p-4 rounded-md text-center hover:bg-blue-600">
                    Manage Users
                </a>
                <a href="reports.php" class="bg-green-500 text-white p-4 rounded-md text-center hover:bg-green-600">
                    View Reports
                </a>
                <a href="add_users.php" class="bg-yellow-500 text-white p-4 rounded-md text-center hover:bg-yellow-600">
                    Add New User
                </a>
                <a href="system_settings.php" class="bg-purple-500 text-white p-4 rounded-md text-center hover:bg-purple-600">
                    System Settings
                </a>
            </div>
        </div>

        <!-- Optional Announcement or System Log Section -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold mb-4">System Announcements</h3>
            <p class="text-gray-600">No new announcements at this time.</p>
        </div>

        <!-- System Health (Optional Future Widget) -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold mb-4">System Health</h3>
            <div class="flex space-x-4">
                <div class="flex-1 bg-green-100 p-4 rounded-md">
                    <h4 class="font-medium">Database</h4>
                    <p class="text-green-600">Connected</p>
                </div>
                <div class="flex-1 bg-blue-100 p-4 rounded-md">
                    <h4 class="font-medium">Storage</h4>
                    <p class="text-blue-600">OK</p>
                </div>
                <div class="flex-1 bg-yellow-100 p-4 rounded-md">
                    <h4 class="font-medium">Security Logs</h4>
                    <p class="text-yellow-600">No Issues</p>
                </div>
            </div>
        </div>

    </main>
</div>

</body>
</html>
