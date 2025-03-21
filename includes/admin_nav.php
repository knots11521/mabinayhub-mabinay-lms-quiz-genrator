<!-- Sidebar Navigation -->
<div id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transition-transform duration-300 transform -translate-x-full md:translate-x-0">
    <div class="p-5 flex justify-between items-center border-b">
        <h2 class="text-lg font-bold text-gray-700">Admin Panel</h2>
        <button id="close-btn" class="md:hidden text-gray-600 text-2xl focus:outline-none" onclick="toggleSidebar()">✖</button>
    </div>
    <nav class="mt-5">
        <a href="dashboard.php" class="block py-3 px-5 text-gray-700 hover:bg-gray-200 transition">Dashboard</a>
        <a href="manage_users.php" class="block py-3 px-5 text-gray-700 hover:bg-gray-200 transition">Manage Users</a>
        <a href="add_users.php" class="block py-3 px-5 text-gray-700 hover:bg-gray-200 transition">Add Users</a>
        <a href="../logout.php" class="block py-3 px-5 text-red-600 hover:bg-red-100 transition">Logout</a>
    </nav>
</div>
