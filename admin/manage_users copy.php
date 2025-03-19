<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../public/index.php");
    exit();
}

require_once '../config/database.php';

// Pagination Setup
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total users count (excluding admin)
$totalStmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role != 'admin'");
$totalUsers = $totalStmt->fetchColumn();
$totalPages = ceil($totalUsers / $limit);

// Fetch users for current page
$stmt = $pdo->prepare("SELECT * FROM users WHERE role != 'admin' LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle Edit User Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $id = $_POST['edit_id'];
    $lastname = $_POST['edit_lastname'];
    $firstname = $_POST['edit_firstname'];
    $username = $_POST['edit_username'];

    $stmt = $pdo->prepare("UPDATE users SET lastname = ?, firstname = ?, username = ? WHERE id = ?");
    $stmt->execute([$lastname, $firstname, $username, $id]);

    $_SESSION['success'] = "User updated successfully!";
    header("Location: manage_users.php?page=$page");
    exit();
}

// Handle Delete User (Triggered by GET Request)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['success'] = "User deleted successfully!";
    header("Location: manage_users.php?page=$page");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function openModal(id, lastname, firstname, username) {
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_lastname").value = lastname;
            document.getElementById("edit_firstname").value = firstname;
            document.getElementById("edit_username").value = username;
            document.getElementById("editModal").classList.remove("hidden");
            document.getElementById("modalOverlay").classList.remove("hidden");
            document.body.classList.add("overflow-hidden");
        }

        function closeModal() {
            document.getElementById("editModal").classList.add("hidden");
            document.getElementById("modalOverlay").classList.add("hidden");
            document.body.classList.remove("overflow-hidden");
        }

        function confirmDelete(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = `manage_users.php?delete=${userId}&page=<?= $page ?>`;
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function checkScreenSize() {
            if (window.innerWidth >= 768) {
                document.getElementById('sidebar').classList.remove('-translate-x-full');
                document.getElementById('overlay').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                document.getElementById('sidebar').classList.add('-translate-x-full');
            }
        }

        window.addEventListener('resize', checkScreenSize);
        window.onload = checkScreenSize;
    </script>
</head>

<body class="h-screen flex bg-gray-100">

    <!-- Overlay for mobile sidebar -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden md:hidden transition-opacity duration-300" onclick="toggleSidebar()"></div>

    <!-- Sidebar (Include your actual sidebar file if needed) -->
    <?php include '../includes/admin_nav.php'; ?>

    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-md p-4 flex justify-between items-center md:hidden">
            <button class="text-gray-600 text-2xl focus:outline-none" onclick="toggleSidebar()">☰</button>
            <h2 class="text-lg font-bold">Manage Users</h2>
        </header>

        <main class="flex-1 p-6">
            <h2 class="text-2xl font-semibold">Manage Users</h2>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-100 text-green-700 p-3 mt-4 rounded">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <div class="mt-6 bg-white shadow rounded p-4">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-3">Last Name</th>
                            <th class="p-3">First Name</th>
                            <th class="p-3">Username</th>
                            <th class="p-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3"><?= htmlspecialchars($user['lastname']); ?></td>
                                <td class="p-3"><?= htmlspecialchars($user['firstname']); ?></td>
                                <td class="p-3"><?= htmlspecialchars($user['username']); ?></td>
                                <td class="p-3 flex justify-center gap-3">
                                    <!-- Edit Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600 cursor-pointer" onclick="openModal('<?= $user['id'] ?>', '<?= htmlspecialchars($user['lastname']) ?>', '<?= htmlspecialchars($user['firstname']) ?>', '<?= htmlspecialchars($user['username']) ?>')" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>

                                    <!-- Delete Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600 cursor-pointer" onclick="confirmDelete(<?= $user['id'] ?>)" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6L18.1 20.1A2 2 0 0 1 16.1 22H7.9A2 2 0 0 1 5.9 20.1L5 6M10 11v6M14 11v6M8 6V3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v3"></path>
                                    </svg>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="mt-4">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="px-3 py-1 border rounded <?= $i === $page ? 'bg-blue-500 text-white' : 'bg-gray-200' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
