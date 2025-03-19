<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/index.php");
    exit();
}

require_once '../config/database.php';

$successMessage = $errorMessage = "";

// Function to generate an 8-character alphanumeric password
function generateClassCode($length = 8) {
    return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, $length);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_classroom'])) {
        $classId = $_POST['class_id'];

        try {
            $stmt = $pdo->prepare("DELETE FROM classrooms WHERE id = :id AND teacher_id = :teacher_id");
            $stmt->execute([
                ':id' => $classId,
                ':teacher_id' => $_SESSION['id']
            ]);

            $successMessage = "Classroom deleted successfully!";
        } catch (PDOException $e) {
            $errorMessage = "Error: " . $e->getMessage();
        }
    } else {
        $className = trim($_POST['class_name']);
        $classPassword = generateClassCode(); // Auto-generate class code
        $teacherId = $_SESSION['id'];

        if (!empty($className)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO classrooms (class_code, subject, teacher_id) VALUES (:class_code, :subject, :teacher_id)");
                $stmt->execute([
                    ':class_code' => $classPassword,
                    ':subject' => $className,
                    ':teacher_id' => $teacherId
                ]);
                $successMessage = "Classroom created successfully! Class Code: $classPassword";
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $errorMessage = "A classroom with this code already exists.";
                } else {
                    $errorMessage = "Error: " . $e->getMessage();
                }
            }
        } else {
            $errorMessage = "Classroom name is required.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Classrooms</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('overlay').classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        function confirmDelete(classId) {
            if (confirm("Are you sure you want to delete this classroom?")) {
                document.getElementById('deleteForm-' + classId).submit();
            }
        }

        function openModal() {
            document.getElementById("classroomModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("classroomModal").classList.add("hidden");
        }
    </script>
</head>
<body class="h-screen flex bg-gray-100">

    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden md:hidden" onclick="toggleSidebar()"></div>

    <?php include '../includes/teacher_nav.php'; ?>

    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-md p-4 flex justify-between items-center md:hidden">
            <button class="text-gray-600 text-2xl focus:outline-none" onclick="toggleSidebar()">☰</button>
            <h2 class="text-lg font-bold">Classrooms</h2>
        </header>

        <main class="flex-1 p-6">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-700">Classrooms</h1>
                <button onclick="openModal()" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">+ Create Classroom</button>
            </div>

            <?php if (!empty($successMessage)): ?>
                <div class="mt-4 p-3 bg-green-100 text-green-800 rounded">
                    <?php echo htmlspecialchars($successMessage); ?>
                </div>
            <?php elseif (!empty($errorMessage)): ?>
                <div class="mt-4 p-3 bg-red-100 text-red-800 rounded">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

            <div class="mt-6 grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                <?php
                $stmt = $pdo->prepare("SELECT * FROM classrooms WHERE teacher_id = ?");
                $stmt->execute([$_SESSION['id']]);
                $classrooms = $stmt->fetchAll();

                if (count($classrooms) > 0): 
                    foreach ($classrooms as $classroom): ?>
                        <div class="relative bg-white shadow-md rounded-lg border border-gray-200 p-5 hover:bg-blue-50 transition">
                            <a href="manage_class.php?class_id=<?php echo htmlspecialchars($classroom['id']); ?>">
                                <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($classroom['subject']); ?></h3>
                                <p class="text-gray-600 text-sm">Class Code: <strong><?php echo htmlspecialchars($classroom['class_code']); ?></strong></p>
                            </a>

                            <form method="POST" id="deleteForm-<?php echo $classroom['id']; ?>" class="absolute top-3 right-3">
                                <input type="hidden" name="class_id" value="<?php echo $classroom['id']; ?>">
                                <button type="button" onclick="confirmDelete(<?php echo $classroom['id']; ?>)"
                                    class="text-red-600 hover:text-red-800 transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6L18.1 20.1A2 2 0 0 1 16.1 22H7.9A2 2 0 0 1 5.9 20.1L5 6M10 11v6M14 11v6M8 6V3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v3"></path>
                                    </svg>
                                </button>
                                <input type="hidden" name="delete_classroom">
                            </form>
                        </div>
                    <?php endforeach; 
                else: ?>
                    <p class="text-gray-500">No classrooms created yet.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <div id="classroomModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Create a Classroom</h2>
            <form method="POST">
                <label class="block text-gray-700">Classroom Name:</label>
                <input type="text" name="class_name" class="w-full p-2 border rounded mt-2 focus:ring-2 focus:ring-blue-500" required>
                <div class="mt-4 flex justify-end">
                    <button type="button" onclick="closeModal()" class="bg-gray-400 text-white py-2 px-4 rounded hover:bg-gray-500">Cancel</button>
                    <button type="submit" class="ml-2 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Create</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
