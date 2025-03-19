<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/index.php");
    exit();
}

$teacherId = $_SESSION['id'] ?? null;
$classId = $_GET['class_id'] ?? null;

// Validate class ownership
$stmt = $pdo->prepare("SELECT * FROM classrooms WHERE id = ? AND teacher_id = ?");
$stmt->execute([$classId, $teacherId]);
$classroom = $stmt->fetch();

if (!$classroom) {
    die("<script>alert('Unauthorized or class not found.'); window.location='create_classroom.php';</script>");
}

// Fetch uploaded materials
$materialsStmt = $pdo->prepare("SELECT * FROM materials WHERE class_id = ?");
$materialsStmt->execute([$classId]);
$materials = $materialsStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Classroom</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex bg-gray-100 text-gray-900">

    <!-- Sidebar -->
    <?php include '../includes/teacher_nav.php'; ?>

    <div class="flex-1 flex flex-col items-center p-10">
        <div class="w-full max-w-5xl bg-white p-8 shadow-xl rounded-lg">

            <!-- Header Section -->
            <div class="flex justify-between items-center border-b pb-4">
                <div>
                    <h1 class="text-2xl font-semibold"><?php echo htmlspecialchars($classroom['subject']); ?></h1>
                    <p class="text-gray-500 text-sm">Class Code: <strong><?php echo htmlspecialchars($classroom['class_code']); ?></strong></p>
                </div>
                <a href="view_students.php?class_id=<?php echo $classId; ?>" class="flex items-center gap-2 text-gray-600 hover:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21V19C16 17.8954 15.1046 17 14 17H10C8.89543 17 8 17.8954 8 19V21"></path>
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M3 9C5.5 3 18.5 3 21 9"></path>
                    </svg>
                    Enrolled Students
                </a>
            </div>

            <!-- Material List -->
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-4">Class Materials</h2>

                <?php if (count($materials) > 0): ?>
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

                                <div class="flex items-center gap-3">
                                    <!-- Delete Icon -->
                                    <form method="POST" id="deleteForm-<?php echo $material['id']; ?>" action="delete_material.php?class_id=<?php echo $classId; ?>&id=<?php echo $material['id']; ?>" class="inline">
                                        <button type="button" onclick="confirmDelete(<?php echo $material['id']; ?>)" class="text-red-600 hover:text-red-800 transition duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6L18.1 20.1A2 2 0 0 1 16.1 22H7.9A2 2 0 0 1 5.9 20.1L5 6M10 11v6M14 11v6M8 6V3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v3"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-center">No materials uploaded yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Floating Upload Button -->
        <div class="fixed bottom-6 right-6">
            <form action="upload_material.php" method="POST" enctype="multipart/form-data" class="relative">
                <input type="hidden" name="class_id" value="<?php echo $classId; ?>">
                <label class="cursor-pointer flex items-center gap-3 bg-green-600 text-white px-6 py-3 text-lg rounded-full shadow-lg hover:bg-green-700 transition">
                    ➕ Upload File
                    <input type="file" name="file" required class="hidden" id="fileInput">
                </label>
                <button type="submit" id="uploadBtn" class="hidden"></button>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('fileInput').addEventListener('change', function() {
        document.getElementById('uploadBtn').click();
    });

    function confirmDelete(materialId) {
        if (confirm("Are you sure you want to delete this file?")) {
            document.getElementById('deleteForm-' + materialId).submit();
        }
    }
    </script>

</body>
</html>
