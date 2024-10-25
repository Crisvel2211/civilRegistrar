<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CivilRegistrar</title>
    <link rel="icon" href="../images/qcfavicon.svg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css">

    <style>
        /* Custom background */
        body {
            background-image: url('https://quezoncity.gov.ph/wp-content/uploads/2024/07/quezon-city-official-website-hero-banner.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .bg-white {
            background-color: rgba(255, 255, 255, 0.9);
        }
        /* Password strength line styling */
        .strength-line {
            height: 6px;
            width: 100%;
            background-color: #e5e7eb; /* Gray background for strength line */
            border-radius: 4px;
            overflow: hidden;
            margin-top: 8px;
        }
        .strength-bar {
            height: 100%;
            transition: width 0.3s ease;
        }
        .weak { background-color: #f87171; }     /* Red */
        .medium { background-color: #facc15; }   /* Yellow */
        .strong { background-color: #34d399; }   /* Green */
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
        <div class='flex relative justify-evenly items-center w-full mt-4 px-4 mb-5'>
            <div>
                <img src="../images/qclogo.png" alt='logo' class='cursor-pointer w-full h-[100px]'/>
            </div>
        </div>
        <div id="register-form">
            <div class="mb-4">
                <label for="register-name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="register-name" placeholder="Enter your name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="register-email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="register-email" placeholder="Enter your email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4 relative">
                <label for="register-password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="register-password" placeholder="Enter your password" oninput="checkPasswordStrength()" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <button type="button" onclick="togglePassword()" class="absolute inset-y-6 right-0 px-4 py-2 text-sm text-gray-600 hover:text-gray-900 focus:outline-none">
                    <i id="toggle-password-icon" class="fa-solid fa-eye-slash"></i>
                </button>
            </div>
            <div class="strength-line mb-2 -mt-2">
                <div id="strength-bar" class="strength-bar"></div>
            </div>
            <div class="mb-4">
                <button id="register-btn" onclick="register()" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex justify-center items-center">
                    <span id="register-btn-text">Register</span>
                    <svg id="register-spinner" class="hidden ml-2 w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.964 7.964 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
            <div id="register-message" class="text-center mt-4"></div>
            <p class="text-center mt-4 text-sm">Already have an account? <a href="login.php" class="text-blue-600 hover:underline">Login here</a></p>
        </div>
    </div>

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
            const passwordInput = document.getElementById('register-password');
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

        function checkPasswordStrength() {
            const password = document.getElementById('register-password').value;
            const strengthBar = document.getElementById('strength-bar');
            let strength = 0;

            if (password.length >= 1) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[\W_]/.test(password)) strength++;

            // Adjust bar style based on strength
            if (strength === 1) {
                strengthBar.style.width = '33%';
                strengthBar.className = 'strength-bar weak';
            } else if (strength === 2) {
                strengthBar.style.width = '66%';
                strengthBar.className = 'strength-bar medium';
            } else if (strength >= 3) {
                strengthBar.style.width = '100%';
                strengthBar.className = 'strength-bar strong';
            } else {
                strengthBar.style.width = '0';
            }
        }

        function validateEmail(email) {
            // Checks if the email has a valid format and ends with @gmail.com
            return /^[^\s@]+@gmail\.com$/.test(email);
        }

        async function register() {
    const name = document.getElementById('register-name').value.trim();
    const email = document.getElementById('register-email').value.trim();
    const password = document.getElementById('register-password').value.trim();
    const registerBtn = document.getElementById('register-btn');
    const registerSpinner = document.getElementById('register-spinner');
    const registerBtnText = document.getElementById('register-btn-text');
    const strengthBar = document.getElementById('strength-bar');

    if (!name) {
        showToast("Required Name", 'error');
        return;
    }
    if (!validateEmail(email)) {
        showToast("Email must be a valid Gmail address (e.g., user@gmail.com).", 'error');
        return;
    }

    // Ensure password is strong
    if (!strengthBar.classList.contains('strong')) {
        showToast("Password must be strong to register", 'error');
        return;
    }

    // Show loading spinner
    registerBtnText.classList.add('hidden');
    registerSpinner.classList.remove('hidden');

    try {
        const response = await fetch('http://localhost/civil-registrar/api/auth.php?action=register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ name, email, password, role: 'resident' })
        });

        const data = await response.json();

        if (response.ok) {
            showToast("Registration successful! Please check your email for verification.", 'success');
            document.getElementById('register-form').reset();
        } else {
            console.error('Error from server:', data);
            showToast(data.message || "Registration failed. Please try again.", 'error');
        }
    } catch (error) {
        console.error('Error during registration:', error);
        showToast("An error occurred. Please try again.", 'error');
    } finally {
        registerBtnText.classList.remove('hidden');
        registerSpinner.classList.add('hidden');
    }
}

    </script>
</body>
</html>
