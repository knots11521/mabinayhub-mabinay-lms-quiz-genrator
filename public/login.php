<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <script>
        function togglePassword() {
            let passwordField = document.getElementById("password");
            let eyeIcon = document.getElementById("eye-icon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</head>
<body class="h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="w-full max-w-4xl flex flex-col md:flex-row shadow-md rounded-lg overflow-hidden bg-white">
        <!-- Background Section (Hidden on Mobile) -->
        <div class="hidden md:flex flex-1 relative">
            <img src="../assets/images/loginbc.jpg" alt="Background" class="absolute inset-0 w-full h-full object-cover">
        </div>

        <!-- Login Form -->
        <div class="w-full md:w-1/2 p-8 md:p-10 flex flex-col justify-center bg-white">
            <h2 class="text-2xl md:text-3xl font-semibold text-teal-700 text-center md:text-left">Login</h2>
            <p class="text-gray-500 text-center md:text-left mb-6">Enter your credentials to continue.</p>

            <?php if (!empty($error)) : ?>
                <p class="bg-red-100 text-red-600 p-3 rounded-md text-center mb-4">
                    <?php echo htmlspecialchars($error); ?>
                </p>
            <?php endif; ?>

            <form action="../includes/auth.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium text-sm mb-1">Username</label>
                    <input type="text" name="username" placeholder="Enter username"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600 bg-gray-50" required>
                </div>

                <div class="relative">
                    <label class="block text-gray-700 font-medium text-sm mb-1">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-600 bg-gray-50" required>
                    <button type="button" onclick="togglePassword()" class="absolute top-3 right-3 text-gray-500">
                        <i id="eye-icon" class="fas fa-eye"></i>
                    </button>
                </div>

                <div class="flex flex-col md:flex-row md:justify-between items-center text-sm text-gray-600">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2 text-teal-600">
                        Remember me
                    </label>
                    <a href="#" class="hover:text-teal-700 mt-2 md:mt-0">Forgot password?</a>
                </div>

                <button type="submit"
                        class="w-full bg-teal-700 text-white py-2 rounded-md hover:bg-teal-800 transition shadow-sm transform hover:scale-105">
                    Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>
