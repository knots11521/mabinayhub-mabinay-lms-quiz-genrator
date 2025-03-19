<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    die("<script>alert('Unauthorized access.'); window.location='index.php';</script>");
}

$teacherId = $_SESSION['id'];
$classId = $_POST['class_id'] ?? null;

if (!$classId) {
    die("<script>alert('Invalid request.'); window.location='manage_class.php?class_id=$classId';</script>");
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    die("<script>alert('No file selected or upload error.'); window.location='manage_class.php?class_id=$classId';</script>");
}

$fileName = $_FILES['file']['name'];
$fileTmp = $_FILES['file']['tmp_name'];
$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$allowedExtensions = ['pdf', 'docx'];

if (!in_array($fileExt, $allowedExtensions)) {
    die("<script>alert('Invalid file type. Only PDF and DOCX are allowed.'); window.location='manage_class.php?class_id=$classId';</script>");
}

$uploadDir = '../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$newFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);
$filePath = $uploadDir . $newFileName;

if (move_uploaded_file($fileTmp, $filePath)) {
    $stmt = $pdo->prepare("INSERT INTO materials (class_id, teacher_id, filename, file_path) VALUES (?, ?, ?, ?)");
    $stmt->execute([$classId, $teacherId, $fileName, $filePath]);

    echo "<script>alert('File uploaded successfully!'); window.location='manage_class.php?class_id=$classId';</script>";
} else {
    echo "<script>alert('File upload failed.'); window.location='manage_class.php?class_id=$classId';</script>";
}
?>
