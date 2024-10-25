<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CivilRegistrar</title>
    <link rel="icon" href="../images/qcfavicon.svg" type="image/x-icon">
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome CDN (Updated version for solid icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Toastify CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css" rel="stylesheet">
     <style>
        /* Add custom styles for the background image */
        body {
            background-image: url('https://quezoncity.gov.ph/wp-content/uploads/2024/07/quezon-city-official-website-hero-banner.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Optionally, adjust the opacity of the login form background for better contrast */
        .bg-white {
            background-color: rgba(255, 255, 255, 0.9); /* Makes the background slightly transparent */
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class='flex relative justify-evenly items-center w-full mt-4 px-4 mb-5'>
            <div>
                <img src="../images/qclogo.png" alt='logo' class='cursor-pointer w-full h-[100px]'/>
            </div>
           
        </div>
        <div id="login-form">
            <div class="mb-4">
                <label for="login-email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="login-email" placeholder="Enter your email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4 relative">
                <label for="login-password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="login-password" placeholder="Enter your password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <button type="button" onclick="togglePassword()" class="absolute inset-y-6 right-0 px-4 py-2 text-sm text-gray-600 hover:text-gray-900 focus:outline-none">
                    <i id="toggle-password-icon" class="fa-solid fa-eye-slash"></i>
                </button>
            </div>
            <div class="mb-4">
                <button id="login-btn" onclick="login()" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex justify-center items-center">
                    <span id="login-btn-text">Login</span>
                    <svg id="login-spinner" class="hidden ml-2 w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.964 7.964 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
            <div class="text-center mt-4">
                <p class="text-sm">Don't have an account? <a href="register.php" class="text-blue-600 hover:underline">Register here</a></p>
            </div>
        </div>
    </div>

    <!-- Toastify JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.js"></script>
    <script>

  

    function showToast(message, type) {
        Toastify({
            text: message,
            style: {
                background: type === 'success' ? "linear-gradient(to right, #00b09b, #96c93d)" : "linear-gradient(to right, #ff5f6d, #ffc371)"
            },
            duration: 3000,
            close: true
        }).showToast();
    }

    function togglePassword() {
        const passwordInput = document.getElementById('login-password');
        const toggleIcon = document.getElementById('toggle-password-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        }
    }

    async function login() {
        const email = document.getElementById('login-email').value.trim();
        const password = document.getElementById('login-password').value.trim();
        const loginBtn = document.getElementById('login-btn');
        const loginSpinner = document.getElementById('login-spinner');
        const loginBtnText = document.getElementById('login-btn-text');

        // Show loading spinner and disable button
        loginBtnText.classList.add('hidden');
        loginSpinner.classList.remove('hidden');
        loginBtn.disabled = true;

        // Check if email is missing
        if (!email) {
            showToast("Please provide an email", 'error');
            loginBtn.disabled = false;
            loginBtnText.classList.remove('hidden');
            loginSpinner.classList.add('hidden');
            return;
        }

        // Check if password is missing
        if (!password) {
            showToast("Please provide a password", 'error');
            loginBtn.disabled = false;
            loginBtnText.classList.remove('hidden');
            loginSpinner.classList.add('hidden');
            return;
        }

        try {
            // Simulate a delay to show the spinner for 3 seconds (you can adjust the duration)
            await new Promise((resolve) => setTimeout(resolve, 2000));

            const response = await fetch('http://localhost/civil-registrar/api/auth.php?action=login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            const result = await response.json();
            if (result.token) {
                showToast('Login successful!', 'success');
                localStorage.setItem('token', result.token); // Store the JWT token
                localStorage.setItem('userId', result.userId);
                localStorage.setItem('email', result.email);
                localStorage.setItem('password', result.password);
                localStorage.setItem('role', result.role); // Store the user ID
                localStorage.setItem('profileImage', result.userProfile);

                setTimeout(() => {
                    const role = result.role; // Get the role from the result
                    if (role === 'admin') {
                        window.location.href = './admin/adminDashboard.php';
                    } else if (role === 'employee') {
                        window.location.href = './employee/employeeDashboard.php';
                    } else if (role === 'resident') {
                        window.location.href = './resident/residentDashboard.php';
                    } else {
                        showToast('Unknown role', 'error');
                    }
                }, 2000); // Redirect after 2 seconds
            } else {
                showToast(result.error, 'error');
            }
        } catch (error) {
            showToast(`An error occurred: ${error.message}`, 'error');
        } finally {
            // Hide spinner and re-enable button
            loginBtn.disabled = false;
            loginBtnText.classList.remove('hidden');
            loginSpinner.classList.add('hidden');
        }
    }
    </script>

</body>
</html>
