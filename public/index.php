<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>LMS Landing Page</title>
    <style>
        html {
            scroll-behavior: smooth;
        }

        .nav-link {
            transition: background-color 0.3s, color 0.3s;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- MAIN CONTAINER -->
    <div class="min-h-screen w-full bg-white shadow-xl overflow-hidden">

        <!-- NAVBAR -->
        <header class="fixed top-0 left-0 w-full bg-white shadow-md z-50">
            <div class="flex items-center justify-between px-8 py-4 border-b">
                <!-- LOGO -->
                <div class="flex items-center">
                    <img src="../assets/images/SHM (2).png" alt="Skwela-Hub Mabinay" class="h-16 w-auto object-contain mr-3" />
                    <!--<span class="text-2xl font-bold text-teal-600">SHM</span>-->
                </div>

                <!-- NAV LINKS -->
                <nav class="hidden md:flex space-x-6">
                    <a href="#main" class="nav-link px-4 py-2 rounded-md transition">Home</a>
                    <a href="#about" class="nav-link px-4 py-2 rounded-md transition">About</a>
                    <a href="login.php" class="nav-link px-4 py-2 rounded-md transition">Login</a>
                </nav>

                <!-- MOBILE MENU BUTTON -->
                <button id="menu-toggle" class="md:hidden focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- MOBILE NAVIGATION MENU -->
            <div id="mobile-menu" class="hidden md:hidden bg-white border-t transition-all duration-300">
                <a href="#main" class="block px-8 py-3 transition hover:bg-gray-100">Home</a>
                <a href="#about" class="block px-8 py-3 transition hover:bg-gray-100">About</a>
                <a href="login.php" class="block px-8 py-3 transition hover:bg-gray-100">Login</a>
            </div>
        </header>

        <!-- HERO SECTION -->
        <div id="main" class="grid grid-cols-1 md:grid-cols-2 gap-12 px-8 py-24 md:py-32">
            <div class="flex flex-col justify-center">
                <h2 class="text-gray-400 text-sm uppercase font-semibold tracking-wide">Welcome</h2>
                <h1 class="text-4xl font-extrabold text-teal-600 mt-2 leading-tight">Skwela-Hub Mabinay</h1>
                <p class="text-gray-500 mt-4 leading-relaxed">
                    Skwela-Hub Mabinay provides a comprehensive and user-friendly platform for students and teachers.
                </p>
                <a href="login.php" class="mt-6 inline-block bg-teal-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-teal-600 transition w-fit">
                    Get Started
                </a>                
                
            </div>
            <div class="flex items-center justify-center">
                <img src="../assets/images/bc.jpg" alt="LMS Illustration" class="w-full max-w-md md:max-w-lg lg:max-w-xl object-contain" />
            </div>
        </div>

        <!-- ABOUT SECTION -->
        <section id="about" class="px-8 py-16 bg-gray-100 pt-20">
            <h2 class="text-3xl font-bold text-center text-teal-600">About Us</h2>
            <p class="text-gray-600 text-center mt-4 max-w-2xl mx-auto">
                Skwela-Hub Mabinay is an innovative Learning Management System designed to facilitate seamless communication and learning between students and teachers.
            </p>
            <div class="mt-8 flex justify-center">
                <a href="about.html" class="bg-teal-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-teal-600 transition">
                    Learn More
                </a>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="bg-gray-900 text-white py-8">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <h3 class="font-bold">Contact Us</h3>
                    <p class="mt-2 text-gray-400">info@example.com</p>
                    <p class="text-gray-400">+1 234 567 890</p>
                </div>
                <div>
                    <h3 class="font-bold">Follow Us</h3>
                    <div class="flex justify-center mt-2 space-x-4">
                        <a href="#" class="hover:text-teal-400">Facebook</a>
                        <a href="#" class="hover:text-teal-400">Twitter</a>
                        <a href="#" class="hover:text-teal-400">LinkedIn</a>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold">Privacy</h3>
                    <p class="mt-2 text-gray-400">
                        <a href="#" class="hover:text-teal-400">Terms of Service</a> |
                        <a href="#" class="hover:text-teal-400">Privacy Policy</a>
                    </p>
                </div>
            </div>
        </footer>

    </div>

    <script>
        // Toggle mobile menu
        document.getElementById('menu-toggle').addEventListener('click', () => {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Handle active state for tabs
        document.addEventListener("DOMContentLoaded", () => {
            const navLinks = document.querySelectorAll(".nav-link");
            let currentPath = window.location.pathname.split("/").pop() || "index.html"; // Default to "index.html"

            navLinks.forEach(link => {
                if (link.getAttribute("href") === currentPath) {
                    link.classList.add("bg-teal-500", "text-white"); // Active state
                    link.classList.remove("text-gray-500", "hover:text-teal-600"); // Remove inactive styles
                } else {
                    link.classList.add("text-gray-500", "hover:text-teal-600"); // Inactive state
                }
            });
        });
    </script>

</body>

</html>
