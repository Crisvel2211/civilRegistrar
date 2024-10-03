<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold text-center mb-4">Register</h2>
        <div id="register-form">
            <div class="mb-4">
                <label for="register-name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="register-name" placeholder="Enter your name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="register-email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="register-email" placeholder="Enter your email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="register-password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="register-password" placeholder="Enter your password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <button onclick="register()" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Register</button>
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

    async function register() {
        const name = document.getElementById('register-name').value.trim();
        const email = document.getElementById('register-email').value.trim();
        const password = document.getElementById('register-password').value.trim();

        // Check if name is missing
        if (!name) {
            showToast("Please provide a name", 'error');
            return;
        }

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
            const response = await fetch('http://localhost/civil-registrar/api/auth.php?action=register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name, email, password, role: 'resident' })
            });

            const result = await response.json();

            if (result.message) {
                // Registration successful
                showToast(result.message, 'success');
                // Redirect to login page
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 2000); // Redirect after 2 seconds to allow the toast message to be seen
            } else {
                // Show error message from the server
                showToast(result.error, 'error');
            }
        } catch (error) {
            showToast(`An error occurred: ${error.message}`, 'error');
        }
    }
</script>

</body>
</html>
