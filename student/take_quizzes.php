<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Take Quizzes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex bg-gray-100">

    <!-- Include Sidebar -->
    <?php include '../includes/student_nav.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <h1 class="text-2xl font-bold text-gray-700">Available Quizzes</h1>

        <div class="mt-5 p-5 bg-white shadow-md rounded-lg">
            <?php
            $quizzes = ["Math Quiz 1", "Science Quiz 2", "History Quiz 3"];
            if (count($quizzes) > 0) {
                foreach ($quizzes as $quiz) {
                    echo "<div class='p-4 border-b flex justify-between'>
                            <span>$quiz</span>
                            <a href='start_quiz.php?quiz=$quiz' class='text-blue-500'>Take Quiz</a>
                          </div>";
                }
            } else {
                echo "<p class='text-gray-600'>No quizzes available.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>
