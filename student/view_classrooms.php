<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/index.php");
    exit();
}

// ✅ Include your database connection
require_once '../config/database.php';  // Make sure this points to your correct database config file

$studentId = $_SESSION['id'] ?? null;

// Fetch enrolled classrooms with teacher names
$classrooms = [];
if ($studentId) {
    $stmt = $pdo->prepare("
        SELECT c.subject, u.firstname, u.lastname 
        FROM enrollments e
        JOIN classrooms c ON e.classroom_id = c.id
        JOIN users u ON c.teacher_id = u.id
        WHERE e.student_id = ?
    ");
    $stmt->execute([$studentId]);
    $classrooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Classrooms</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex bg-gray-100">

    <!-- Include Sidebar -->
    <?php include '../includes/student_nav.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <h1 class="text-2xl font-bold text-gray-700">Your Enrolled Classrooms</h1>

        <div class="mt-5 p-5 bg-white shadow-md rounded-lg">
            <?php if (count($classrooms) > 0): ?>
                <div class="divide-y divide-gray-200">
                    <?php foreach ($classrooms as $classroom): ?>
                        <div class="p-4">
                            <h2 class="text-lg font-semibold"><?= htmlspecialchars($classroom['subject']) ?></h2>
                            <p class="text-gray-600">Teacher: <?= htmlspecialchars($classroom['firstname'] . ' ' . $classroom['lastname']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-600">You are not enrolled in any classrooms yet.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
