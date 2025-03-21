<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skwela Hub Mabinay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleMenu() {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        }
    </script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 1.5s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">

<header class="w-full bg-white shadow-md fixed top-0 left-0 right-0 z-50">
    <div class="max-w-6xl mx-auto flex justify-between items-center px-6 py-4">
        <h1 class="text-2xl font-bold tracking-wide text-blue-600">SHM</h1>
        <nav class="hidden md:flex">
            <ul class="flex space-x-6">
                <li><a href="#" class="text-gray-700 hover:text-blue-500 transition">Home</a></li>
                <li><a href="#" class="text-gray-700 hover:text-blue-500 transition">About</a></li>
                <li><a href="login.php" class="text-gray-700 hover:text-blue-500 transition">Login</a></li>
            </ul>
        </nav>
        <button class="md:hidden" onclick="toggleMenu()">
            <svg class="w-7 h-7 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>
    <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg rounded-b-lg">
        <ul class="flex flex-col space-y-4 py-4 px-6">
            <li><a href="#" class="block text-gray-700 hover:text-blue-500 transition">Home</a></li>
            <li><a href="#" class="block text-gray-700 hover:text-blue-500 transition">About</a></li>
            <li><a href="login.php" class="block text-gray-700 hover:text-blue-500 transition">Login</a></li>
        </ul>
    </div>
</header>

<section class="relative w-screen h-screen flex items-center justify-center bg-gray-200 pt-20">
    <div class="text-center animate-fadeIn max-w-2xl mx-auto px-4">
        <h2 class="text-4xl font-bold text-gray-800">Welcome to Skwela Hub Mabinay</h2>
        <p class="mt-4 text-lg text-gray-600">A place for learning and growth.</p>
        <a href="#" class="mt-6 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
            Get Started
        </a>
    </div>
</section>


<section class="max-w-6xl mx-auto py-16 px-4 sm:px-6 text-center">
    <h3 class="text-3xl font-semibold text-gray-800">What We Offer</h3>
    <div class="mt-10 grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h4 class="text-lg font-bold text-gray-700">Quality Learning</h4>
            <p class="mt-2 text-sm text-gray-600">Resources and tools to help you excel in your studies.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h4 class="text-lg font-bold text-gray-700">Community Support</h4>
            <p class="mt-2 text-sm text-gray-600">A supportive community of fellow learners and teachers.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h4 class="text-lg font-bold text-gray-700">Accessible Anytime</h4>
            <p class="mt-2 text-sm text-gray-600">Access lessons, quizzes, and more whenever you need.</p>
        </div>
    </div>
</section>

<section class="bg-blue-600 text-white py-16 text-center">
    <h3 class="text-3xl font-bold">Start Learning Today</h3>
    <p class="mt-3 text-lg text-blue-200">Join our community and expand your knowledge.</p>
    <a href="#" class="mt-6 inline-block px-6 py-3 bg-white text-blue-600 rounded-lg shadow hover:bg-gray-200 transition">
        Join Now
    </a>
</section>

<footer class="bg-gray-800 text-white text-center py-6">
    <p class="text-sm">© 2025 Skwela Hub Mabinay. All rights reserved.</p>
</footer>

</body>
</html>
