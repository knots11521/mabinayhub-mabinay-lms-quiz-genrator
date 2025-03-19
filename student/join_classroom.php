<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/index.php");
    exit();
}

$studentId = $_SESSION['id'] ?? null;
$studentFirstName = $_SESSION['firstname'] ?? 'Unknown';
$studentLastName = $_SESSION['lastname'] ?? 'Student';
$studentName = $studentFirstName . ' ' . $studentLastName;

$successMessage = $errorMessage = "";

// Handle joining a class
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $classCode = trim($_POST['class_code']);

    if (!empty($classCode)) {
        $stmt = $pdo->prepare("SELECT id, subject, teacher_id FROM classrooms WHERE class_code = ?");
        $stmt->execute([$classCode]);
        $classroom = $stmt->fetch();

        if ($classroom) {
            $classroomId = $classroom['id'];
            $teacherId = $classroom['teacher_id'];

            // Check if student is already enrolled
            $stmt = $pdo->prepare("SELECT * FROM enrollments WHERE classroom_id = ? AND student_id = ?");
            $stmt->execute([$classroomId, $studentId]);

            if ($stmt->rowCount() == 0) {
                $stmt = $pdo->prepare("INSERT INTO enrollments (classroom_id, student_id) VALUES (?, ?)");
                $stmt->execute([$classroomId, $studentId]);
                $successMessage = "Successfully joined the classroom!";
            } else {
                $errorMessage = "You are already enrolled in this classroom.";
            }
        } else {
            $errorMessage = "Invalid class code.";
        }
    } else {
        $errorMessage = "Class code is required.";
    }
}

// Fetch enrolled classes
$stmt = $pdo->prepare("
    SELECT classrooms.id, classrooms.subject, users.firstname, users.lastname 
    FROM enrollments 
    INNER JOIN classrooms ON enrollments.classroom_id = classrooms.id 
    INNER JOIN users ON classrooms.teacher_id = users.id
    WHERE enrollments.student_id = ?
");
$stmt->execute([$studentId]);
$enrolledClasses = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Join Classroom</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex bg-gray-100">

    <!-- Include Sidebar -->
    <?php include '../includes/student_nav.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-700">My Classrooms</h1>
            <button onclick="openModal()" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">+ Join Class</button>
        </div>

        <!-- Display Messages -->
        <?php if (!empty($successMessage)): ?>
            <div class="mt-4 p-3 bg-green-100 text-green-800 rounded">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php elseif (!empty($errorMessage)): ?>
            <div class="mt-4 p-3 bg-red-100 text-red-800 rounded">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <!-- Classroom Cards -->
        <div class="mt-6 grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            <?php if (!empty($enrolledClasses)): ?>
                <?php foreach ($enrolledClasses as $class): ?>
                    <a href="manage_class.php?class_id=<?php echo htmlspecialchars($class['id']); ?>"
                        class="block p-5 bg-white shadow-md rounded-lg border border-gray-200 hover:bg-blue-50 transition">

                        <h3 class="text-gray-600 text-sm">Subject: <strong> <?php echo htmlspecialchars($class['subject']); ?></strong></h3>

                        <p class="text-gray-600 text-sm">Teacher: <strong><?php echo htmlspecialchars($class['firstname'] . ' ' . $class['lastname']); ?></strong></p>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500">You are not enrolled in any classes yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Join Classroom Modal -->
    <div id="classroomModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Join a Classroom</h2>

            <form method="POST">
                <label class="block text-gray-700">Enter Class Code:</label>
                <input type="text" name="class_code" class="w-full p-2 border rounded mt-2 focus:ring-2 focus:ring-blue-500" required>

                <div class="mt-4 flex justify-end">
                    <button type="button" onclick="closeModal()" class="bg-gray-400 text-white py-2 px-4 rounded hover:bg-gray-500 transition">Cancel</button>
                    <button type="submit" class="ml-2 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">Join</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("classroomModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("classroomModal").classList.add("hidden");
        }
    </script>

</body>

</html>