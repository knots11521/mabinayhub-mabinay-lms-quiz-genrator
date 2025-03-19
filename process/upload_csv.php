<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csv_file"])) {
    $file = $_FILES["csv_file"]["tmp_name"];

    if (($handle = fopen($file, "r")) !== FALSE) {
        $_SESSION['preview_data'] = []; // Reset session
        fgetcsv($handle); // Skip header row

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($data) < 5) continue; // Ensure all fields exist

            $_SESSION['preview_data'][] = [
                trim($data[0]), // Lastname
                trim($data[1]), // Firstname
                trim($data[2]), // Username
                trim($data[3]), // Role
                trim($data[4])  // Password (Will be hashed later)
            ];
        }
        fclose($handle);
    }
}

header("Location: ../admin/add_users.php");
exit();
?>
