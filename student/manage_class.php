<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/index.php");
    exit();
}

$studentId = $_SESSION['id'] ?? null;
$classId = $_GET['class_id'] ?? null;

if (!$classId) {
    die("Error: No class ID provided.");
}

// Initialize default values
$classSubject = "Unknown Subject";
$teacherName = "Unknown Teacher";
$materials = [];

// Fetch class details and materials
$stmt = $pdo->prepare("
    SELECT classrooms.subject, users.firstname AS teacher_firstname, users.lastname AS teacher_lastname, 
           materials.id, materials.filename, materials.file_path, materials.uploaded_at
    FROM classrooms
    JOIN enrollments ON classrooms.id = enrollments.classroom_id
    JOIN users ON classrooms.teacher_id = users.id
    LEFT JOIN materials ON classrooms.id = materials.class_id
    WHERE enrollments.student_id = ? AND classrooms.id = ?
    ORDER BY materials.uploaded_at DESC
");
$stmt->execute([$studentId, $classId]);
$materials = $stmt->fetchAll();

// If any records exist, update class subject and teacher name
if (!empty($materials)) {
    $classSubject = $materials[0]['subject'] ?? "Unknown Subject";
    $teacherName = trim(($materials[0]['teacher_firstname'] ?? '') . ' ' . ($materials[0]['teacher_lastname'] ?? ''));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($classSubject); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex bg-gray-100 text-gray-900">

    <!-- Sidebar Navigation -->
    <?php include '../includes/student_nav.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <div class="max-w-5xl mx-auto bg-white p-8 shadow-xl rounded-lg">

            <!-- Header Section -->
            <div class="flex justify-between items-center border-b pb-4">
                <h1 class="text-2xl font-semibold"><?php echo htmlspecialchars($classSubject); ?></h1>
                <p class="text-gray-600">Instructor: <strong><?php echo htmlspecialchars($teacherName); ?></strong></p>
            </div>

            <!-- Materials Section -->
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-4">Class Materials</h2>

                <?php if (!empty($materials) && !empty($materials[0]['filename'])): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($materials as $material): ?>
                            <div class="relative bg-gray-50 shadow-sm rounded-lg p-4 border flex items-center justify-between">
                                <div class="flex items-center gap-3 truncate">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 19.5V4.5A2.5 2.5 0 0 1 6.5 2H14l6 6v11.5A2.5 2.5 0 0 1 17.5 22h-11A2.5 2.5 0 0 1 4 19.5Z"></path>
                                    </svg>
                                    <a href="<?php echo htmlspecialchars($material['file_path']); ?>" target="_blank" class="text-blue-600 hover:underline truncate">
                                        <?php echo htmlspecialchars($material['filename']); ?>
                                    </a>
                                </div>
                                <p class="text-sm text-gray-600">Uploaded on: <?php echo htmlspecialchars($material['uploaded_at']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-center">No materials uploaded yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
