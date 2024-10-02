<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php'; // Include your database connection file
include 'jwt.php';   // JWT helper

$method = $_SERVER['REQUEST_METHOD'];
$response = []; // Initialize an array to collect responses

// Registration endpoint
if ($method === 'POST' && isset($_GET['action']) && $_GET['action'] === 'register') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['name'], $data['email'], $data['password'], $data['role'])) {
        $response = ['error' => 'Invalid input'];
    } else {
        $name = trim($conn->real_escape_string($data['name']));
        $email = trim($conn->real_escape_string($data['email']));
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        $role = trim($conn->real_escape_string($data['role']));

        $sql_check = "SELECT id FROM users WHERE email = '$email'";
        $result_check = $conn->query($sql_check);

        if ($result_check === FALSE) {
            $response = ['error' => 'Query error: ' . $conn->error];
        } elseif ($result_check->num_rows > 0) {
            $response = ['error' => 'Email already exists'];
        } else {
            $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
            if ($conn->query($sql) === TRUE) {
                $response = ['message' => 'User registered successfully'];
            } else {
                $response = ['error' => 'Database error: ' . $conn->error];
            }
        }
    }
}

// Login endpoint
if ($method === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Ensure email and password are present in the request
    if (!isset($data['email'], $data['password'])) {
        $response = ['error' => 'Invalid input'];
    } else {
        $email = $conn->real_escape_string($data['email']);
        $password = $data['password'];

        // Check if user exists
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Create JWT token
                $payload = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'password' => $user['password'],
                    'exp' => time() + (60 * 60)  // Token valid for 1 hour
                ];

                $token = JWT::encode($payload);

                // Return both the token and the user's role
                $response = [
                    'token' => $token,
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'userId' => $user['id'], // Return userId
                    'email' => $user['email'], // Return userId
                    'password' => $user['password']
                ];
            } else {
                $response = ['error' => 'Invalid password'];
            }
        } else {
            $response = ['error' => 'User not found'];
        }
    }

    // Send the response as JSON
    echo json_encode($response);
    exit();
}

// JWT validation endpoint
if ($method === 'GET' && isset($_GET['action']) && $_GET['action'] === 'validate') {
    // Validate JWT token
    $headers = getallheaders();
    $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';
    $token = str_replace('Bearer ', '', $authHeader);

    if ($token) {
        try {
            $decoded = JWT::decode($token);
            $response = ['message' => 'Token is valid', 'data' => $decoded];
        } catch (Exception $e) {
            $response = ['error' => 'Invalid token'];
        }
    } else {
        $response = ['error' => 'No token provided'];
    }
}

// Send the final JSON response
echo json_encode($response);
?>
