<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/index.php");
    exit();
}

// Get class ID from URL
$classroomId = $_GET['class_id'] ?? null;

if (!$classroomId) {
    die("Invalid classroom ID.");
}

// Fetch classroom details
$stmt = $pdo->prepare("SELECT subject FROM classrooms WHERE id = ? AND teacher_id = ?");
$stmt->execute([$classroomId, $_SESSION['id']]);
$classroom = $stmt->fetch();

if (!$classroom) {
    die("You are not authorized to view this classroom.");
}

// Fetch enrolled students
$stmt = $pdo->prepare("
    SELECT users.firstname, users.lastname, users.username
    FROM enrollments
    INNER JOIN users ON enrollments.student_id = users.id
    WHERE enrollments.classroom_id = ?
");
$stmt->execute([$classroomId]);
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Enrolled Students</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex bg-gray-100">

    <!-- Include Sidebar -->
    <?php include '../includes/teacher_nav.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <h1 class="text-2xl font-bold text-gray-700">Enrolled Students in <?php echo htmlspecialchars($classroom['subject']); ?></h1>

        <div class="mt-6 bg-white shadow-md rounded-lg p-4">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-3 text-left">#</th>
                        <th class="p-3 text-left">Full Name</th>
                        <th class="p-3 text-left">Username (LRN)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($students)): ?>
                        <?php foreach ($students as $index => $student): ?>
                            <tr class="border-b">
                                <td class="p-3"><?php echo $index + 1; ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($student['firstname'] . ' ' . $student['lastname']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($student['username']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="p-3 text-center text-gray-500">No students enrolled yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
