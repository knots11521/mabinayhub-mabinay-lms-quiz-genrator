<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    $file = $_FILES["csv_file"]["tmp_name"];

    if (!$file || !file_exists($file)) {
        $_SESSION['error'] = "Error: No file uploaded.";
        header("Location: ../admin/add_users.php");
        exit();
    }

    $preview_data = [];
    if (($handle = fopen($file, "r")) !== FALSE) {
        fgetcsv($handle); // Skip header row

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($data) < 5) {
                continue; // Ensure all fields exist
            }

            $preview_data[] = [
                trim($data[0]), // Lastname
                trim($data[1]), // Firstname
                trim($data[2]), // Username
                trim($data[3]), // Role
                trim($data[4])  // Password
            ];
        }
        fclose($handle);
    }

    if (empty($preview_data)) {
        $_SESSION['error'] = "Error: CSV file is empty or has invalid data.";
    } else {
        $_SESSION['preview_data'] = $preview_data;
        $_SESSION['success'] = "File uploaded successfully. Please review and confirm.";
    }
}

header("Location: ../admin/add_users.php");
exit();
?>
