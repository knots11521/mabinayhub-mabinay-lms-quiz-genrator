<?php
require_once 'config/database.php';
if ($conn) {
    echo "Database connection is working!";
} else {
    echo "Database connection failed!";
}
?>
