<div id="sidebar" class="fixed md:relative inset-y-0 left-0 w-64 bg-white shadow-lg md:shadow-none transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-50">
    <div class="p-5 flex justify-between items-center border-b">
        <h2 class="text-lg font-bold text-gray-700">Teacher Panel</h2>
        <button class="md:hidden text-gray-600 text-2xl focus:outline-none" onclick="toggleSidebar()">✖</button>
    </div>
    <nav class="mt-5">
        <a href="dashboard.php" class="block py-3 px-5 text-gray-700 hover:bg-gray-200 transition">Dashboard</a>
        <a href="create_classroom.php" class="block py-3 px-5 text-gray-700 hover:bg-gray-200 transition">Manage Classroom</a>
        <a href="../logout.php" class="block py-3 px-5 text-red-600 hover:bg-red-100 transition">Logout</a>
    </nav>
</div>
