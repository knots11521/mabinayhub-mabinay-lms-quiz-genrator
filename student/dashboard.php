<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/index.php");
    exit();
}

require_once '../config/database.php';

$studentFirstName = $_SESSION['firstname'] ?? 'Student';
$studentLastName = $_SESSION['lastname'] ?? '';
$studentFullName = trim($studentFirstName . ' ' . $studentLastName);

$studentId = $_SESSION['id'] ?? null;

$classCount = 0;
if ($studentId) {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS class_count FROM enrollments WHERE student_id = ?");
    $stmt->execute([$studentId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $classCount = $result['class_count'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('overlay').classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        function checkScreenSize() {
            if (window.innerWidth >= 768) {
                document.getElementById('sidebar').classList.remove('-translate-x-full');
                document.getElementById('overlay').classList.add('hidden');
            } else {
                document.getElementById('sidebar').classList.add('-translate-x-full');
            }
        }

        window.addEventListener('resize', checkScreenSize);
        document.addEventListener('DOMContentLoaded', checkScreenSize);
    </script>
</head>

<body class="h-screen flex bg-gray-100">

    <!-- Overlay for mobile sidebar -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden md:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar (student_nav.php can be included if desired) -->
    <?php include '../includes/student_nav.php'; ?>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Top Bar (Mobile) -->
        <header class="bg-white shadow p-4 md:hidden flex justify-between items-center">
            <button onclick="toggleSidebar()" class="text-gray-600 text-2xl">☰</button>
            <h2 class="text-lg font-bold">Dashboard</h2>
        </header>

        <!-- Dashboard Content -->
        <main class="p-6 space-y-6">

            <!-- Welcome Message -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold">Welcome back, <?php echo htmlspecialchars($studentFullName); ?>!</h1>
                <p class="text-gray-600 mt-2">Here's an overview of your student portal.</p>
            </div>

            <!-- Quick Links Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="join_classroom.php" class="bg-blue-500 text-white p-5 rounded-lg shadow hover:bg-blue-600 transition">
                    <h3 class="font-bold text-lg">Join Classroom</h3>
                    <p class="text-sm mt-2">Use a class code to join.</p>
                </a>
                <a href="view_classrooms.php" class="bg-green-500 text-white p-5 rounded-lg shadow hover:bg-green-600 transition">
                    <h3 class="font-bold text-lg">View Classrooms</h3>
                    <p class="text-sm mt-2">See all enrolled classes.</p>
                </a>
                <a href="manage_class.php?class_id=1" class="bg-yellow-500 text-white p-5 rounded-lg shadow hover:bg-yellow-600 transition">
                    <h3 class="font-bold text-lg">Manage Class</h3>
                    <p class="text-sm mt-2">View materials for a class.</p>
                </a>
                <a href="../public/index.php" class="bg-red-500 text-white p-5 rounded-lg shadow hover:bg-red-600 transition">
                    <h3 class="font-bold text-lg">Log Out</h3>
                    <p class="text-sm mt-2">Sign out of your account.</p>
                </a>
            </div>

            <!-- Quick Stats (You can enhance with DB data if needed) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white p-6 shadow rounded-lg">
                    <h3 class="text-gray-600">Total Enrolled Classes</h3>
                    <p class="text-3xl font-bold"><?php echo $classCount; ?></p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg">
                    <h3 class="text-gray-600">Pending Assignments</h3>
                    <p class="text-3xl font-bold">Not Working</p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg">
                    <h3 class="text-gray-600">Notifications</h3>
                    <p class="text-3xl font-bold">Not Working</p>
                </div>
            </div>

        </main>
    </div>

</body>

</html>