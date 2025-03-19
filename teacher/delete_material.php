<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/index.php");
    exit();
}

$teacherId = $_SESSION['id'] ?? null;
$materialId = $_GET['id'] ?? null;
$classId = $_GET['class_id'] ?? null;

if (!$materialId || !$classId) {
    die("<script>alert('Invalid request.'); window.location='manage_classroom.php?class_id={$classId}';</script>");
}

// Validate that the teacher owns this classroom
$stmt = $pdo->prepare("SELECT * FROM classrooms WHERE id = ? AND teacher_id = ?");
$stmt->execute([$classId, $teacherId]);
$classroom = $stmt->fetch();

if (!$classroom) {
    die("<script>alert('Unauthorized action.'); window.location='manage_classroom.php?class_id={$classId}';</script>");
}

// Get file path
$materialStmt = $pdo->prepare("SELECT file_path FROM materials WHERE id = ? AND class_id = ?");
$materialStmt->execute([$materialId, $classId]);
$material = $materialStmt->fetch();

if ($material) {
    $filePath = '../uploads/' . basename($material['file_path']); // Ensure correct path
    if (file_exists($filePath)) {
        unlink($filePath); // Delete file from server
    }

    // Remove from database
    $deleteStmt = $pdo->prepare("DELETE FROM materials WHERE id = ? AND class_id = ?");
    $deleteStmt->execute([$materialId, $classId]);

    echo "<script>alert('Material deleted successfully.'); window.location='manage_class.php?class_id={$classId}';</script>";
} else {
    echo "<script>alert('Material not found.'); window.location='manage_classroom.php?class_id={$classId}';</script>";
}
?>
