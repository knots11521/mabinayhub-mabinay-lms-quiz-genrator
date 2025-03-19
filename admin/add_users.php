<?php
session_start();
require_once '../config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
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

        function toggleModal() {
            const modal = document.getElementById('modal');
            const modalOverlay = document.getElementById('modal-overlay');

            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modalOverlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                modal.classList.add('hidden');
                modalOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }
    </script>
</head>
<body class="h-screen flex bg-gray-100">

    <!-- Sidebar -->
    <?php include '../includes/admin_nav.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-md p-4 flex justify-between items-center md:hidden">
            <button id="burger-btn" class="text-gray-600 text-2xl focus:outline-none" onclick="toggleSidebar()">☰</button>
            <h2 class="text-lg font-bold">Add Users</h2>
        </header>

        <main class="flex-1 p-6">
            <h2 class="text-xl font-bold mb-4">Upload Users (CSV Format)</h2>

            <!-- Success/Error Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="p-4 mb-4 text-green-800 bg-green-200 rounded">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="p-4 mb-4 text-red-800 bg-red-200 rounded">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Upload Form -->
            <form action="../process/upload_users.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="csv_file" required class="border p-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
            </form>

            <!-- Show preview table only if data exists -->
            <?php if (isset($_SESSION['preview_data'])): ?>
                <h2 class="text-xl font-semibold mt-6">Preview Data</h2>
                <button class="mt-2 bg-green-500 text-white px-4 py-2 rounded" onclick="toggleModal()">Confirm & Add Users</button>

                <!-- Preview Table -->
                <table class="table-auto w-full border-collapse border border-gray-400 bg-white mt-4">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">Lastname</th>
                            <th class="border p-2">Firstname</th>
                            <th class="border p-2">Username</th>
                            <th class="border p-2">Role</th>
                            <th class="border p-2">Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['preview_data'] as $user): ?>
                            <tr>
                                <td class="border p-2"><?= htmlspecialchars($user[0]) ?></td>
                                <td class="border p-2"><?= htmlspecialchars($user[1]) ?></td>
                                <td class="border p-2"><?= htmlspecialchars($user[2]) ?></td>
                                <td class="border p-2"><?= htmlspecialchars($user[3]) ?></td>
                                <td class="border p-2"><?= htmlspecialchars($user[4]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modal Overlay -->
    <div id="modal-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-semibold mb-4">Confirm User Upload</h2>
            <p>Are you sure you want to add these users?</p>
            <div class="mt-4 flex justify-end">
                <button class="bg-gray-400 text-white px-4 py-2 rounded mr-2" onclick="toggleModal()">Cancel</button>
                <form action="../process/confirm_upload.php" method="POST">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Confirm</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
