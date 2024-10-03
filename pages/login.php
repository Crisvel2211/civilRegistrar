<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Toastify CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
        <div id="login-form">
            <div class="mb-4">
                <label for="login-email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="login-email" placeholder="Enter your email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="login-password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="login-password" placeholder="Enter your password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <button onclick="login()" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Login</button>
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

    async function login() {
        const email = document.getElementById('login-email').value.trim();
        const password = document.getElementById('login-password').value.trim();

        // Check if email is missing
        if (!email) {
            showToast("Please provide an email", 'error');
            return;
        }

        // Check if password is missing
        if (!password) {
            showToast("Please provide a password", 'error');
            return;
        }

        try {
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
        }
    }
</script>

</body>
</html>
