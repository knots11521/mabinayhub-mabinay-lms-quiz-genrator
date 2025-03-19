<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../public/index.php");
    exit();
}

require_once '../config/database.php';

// Pagination Setup
$limit = 5;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
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

    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND id != ?");
    $checkStmt->execute([$username, $id]);
    $count = $checkStmt->fetchColumn();

    if ($count > 0) {
        // Trigger the error modal directly using JS
        echo "<script>
                window.onload = function() {
                    openErrorModal('The username \"$username\" is already taken!');
                }
              </script>";
        return; // Stop further execution (optional)
    }

    $stmt = $pdo->prepare("UPDATE users SET lastname = ?, firstname = ?, username = ? WHERE id = ?");
    $stmt->execute([$lastname, $firstname, $username, $id]);

    $_SESSION['success'] = "User updated successfully!";
    header("Location: manage_users.php?page=$page");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
   <script>        function openEditModal(id, lastname, firstname, username) {
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_lastname").value = lastname;
            document.getElementById("edit_firstname").value = firstname;
            document.getElementById("edit_username").value = username;

            const modal = document.getElementById("editUserModal");
            const modalContent = document.getElementById("editModalContent");

            modal.classList.remove("hidden");
            document.body.classList.add("overflow-hidden");

            // Trigger animation
            setTimeout(() => {
                modalContent.classList.remove("opacity-0", "scale-95");
                modalContent.classList.add("opacity-100", "scale-100");
            }, 10);
        }

        function closeEditModal() {
            const modal = document.getElementById("editUserModal");
            const modalContent = document.getElementById("editModalContent");

            // Trigger closing animation
            modalContent.classList.remove("opacity-100", "scale-100");
            modalContent.classList.add("opacity-0", "scale-95");

            setTimeout(() => {
                modal.classList.add("hidden");
                document.body.classList.remove("overflow-hidden");
            }, 300);
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
        // information js
        function showUserInfo(lastname, firstname, username, role, section, yearLevel, subject) {
            document.getElementById('info_lastname').textContent = lastname || 'N/A';
            document.getElementById('info_firstname').textContent = firstname || 'N/A';
            document.getElementById('info_username').textContent = username || 'N/A';
            document.getElementById('info_role').textContent = role || 'N/A';
            document.getElementById('info_section').textContent = section || 'N/A';
            document.getElementById('info_year_level').textContent = yearLevel || 'N/A';
            document.getElementById('info_subject').textContent = subject || 'N/A';

            const modal = document.getElementById('userInfoModal');
            const modalContent = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // Add animation (fade + scale in)
            setTimeout(() => {
                modalContent.classList.remove('opacity-0', 'scale-95');
                modalContent.classList.add('opacity-100', 'scale-100');
            }, 10); // Slight delay to trigger transition
        }

        function closeUserInfoModal() {
            const modal = document.getElementById('userInfoModal');
            const modalContent = document.getElementById('modalContent');

            // Add animation (fade + scale out)
            modalContent.classList.remove('opacity-100', 'scale-100');
            modalContent.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }, 300); // Wait for animation to complete
        }




        window.addEventListener('resize', checkScreenSize);</script>

</head>

<body class="h-screen flex bg-gray-100">

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden md:hidden transition-opacity duration-300" onclick="toggleSidebar()"></div>

    <!-- Include Sidebar -->
    <?php include '../includes/admin_nav.php'; ?>

    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-md p-4 flex justify-between items-center md:hidden">
            <button id="burger-btn" class="text-gray-600 text-2xl focus:outline-none" onclick="toggleSidebar()">☰</button>
            <h2 class="text-lg font-bold">Manage Users</h2>
        </header>

        <div class="p-6">
            <h2 class="text-2xl font-semibold text-gray-700">Manage Users</h2>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mt-4">
                    <?= $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <div class="mt-6 bg-white shadow-sm rounded-lg p-4 overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
                            <th class="py-3 px-4">Last Name</th>
                            <th class="py-3 px-4">First Name</th>
                            <th class="py-3 px-4">Username</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4"><?= $user['lastname']; ?></td>
                                <td class="py-3 px-4"><?= $user['firstname']; ?></td>
                                <td class="py-3 px-4"><?= $user['username']; ?></td>
                                <td class="py-3 px-4 text-center flex justify-center space-x-2">
                                    <button onclick="openEditModal('<?= $user['id']; ?>', '<?= $user['lastname']; ?>', '<?= $user['firstname']; ?>', '<?= $user['username']; ?>')"
                                        class="p-2 hover:bg-blue-100 rounded transition">
                                        <!-- Edit Icon Here (unchanged) -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </button>

                                    <a href="delete_user.php?id=<?= $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" class="p-2 hover:bg-red-100 rounded transition">
                                        <!-- Delete Icon (Unchanged) -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6L18.1 20.1A2 2 0 0 1 16.1 22H7.9A2 2 0 0 1 5.9 20.1L5 6M10 11v6M14 11v6M8 6V3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v3"></path>
                                        </svg>
                                    </a>
                                    <button onclick="showUserInfo('<?= $user['lastname']; ?>', '<?= $user['firstname']; ?>', '<?= $user['username']; ?>', '<?= $user['role']; ?>', '<?= $user['section']; ?>', '<?= $user['year_level']; ?>', '<?= $user['subject']; ?>')"
                                        class="p-2 hover:bg-green-100 rounded transition">
                                        <!-- Info Icon (Modern Tailwind Icon - No Emojis) -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18z" />
                                        </svg>
                                    </button>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-6">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1; ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md transition hover:bg-gray-400">
                            Previous
                        </a>
                    <?php endif; ?>

                    <span class="text-gray-700">Page <?= $page; ?> of <?= $totalPages; ?></span>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1; ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md transition hover:bg-gray-400">
                            Next
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm hidden flex items-center justify-center">
        <div id="editModalContent" class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md opacity-0 scale-95 transition-all duration-300 ease-out">
            <h2 class="text-2xl font-medium text-gray-800 border-b pb-3 mb-4">Edit User</h2>
            <form method="POST">
                <input type="hidden" name="edit_id" id="edit_id">
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-600 text-sm mb-1">Last Name</label>
                        <input type="text" name="edit_lastname" id="edit_lastname" class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block text-gray-600 text-sm mb-1">First Name</label>
                        <input type="text" name="edit_firstname" id="edit_firstname" class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="block text-gray-600 text-sm mb-1">Username</label>
                        <input type="text" name="edit_username" id="edit_username" class="w-full border px-3 py-2 rounded focus:ring focus:ring-blue-300">
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2 text-sm bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" name="edit_user" class="px-5 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- User Info Modal -->
    <div id="userInfoModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm hidden flex items-center justify-center">
        <div id="modalContent" class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md opacity-0 scale-95 transition-all duration-300 ease-out">
            <h2 class="text-2xl font-medium text-gray-800 border-b pb-3 mb-4">User Information</h2>
            <div class="space-y-3 text-gray-600 text-sm leading-relaxed">
                <p><strong class="font-medium">Last Name:</strong> <span id="info_lastname" class="text-gray-800"></span></p>
                <p><strong class="font-medium">First Name:</strong> <span id="info_firstname" class="text-gray-800"></span></p>
                <p><strong class="font-medium">Username:</strong> <span id="info_username" class="text-gray-800"></span></p>
                <p><strong class="font-medium">Role:</strong> <span id="info_role" class="text-gray-800"></span></p>
                <p><strong class="font-medium">Section:</strong> <span id="info_section" class="text-gray-800"></span></p>
                <p><strong class="font-medium">Year Level:</strong> <span id="info_year_level"></span></p>
                <p><strong class="font-medium">Subject:</strong> <span id="info_subject"></span></p>
            </div>
            <div class="mt-6 flex justify-end">
                <button onclick="closeUserInfoModal()" class="px-5 py-2 text-sm bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>


</body>

</html>