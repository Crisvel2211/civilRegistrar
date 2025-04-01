<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php'; // Include your database connection file
include 'jwt.php';   // JWT helper
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/../vendor/autoload.php';

$method = $_SERVER['REQUEST_METHOD'];
$response = []; // Initialize an array to collect responses

// Function to send OTP
function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sanchezlando333@gmail.com'; // SMTP username
        $mail->Password   = 'ifkkfcdkadzhcggh'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('sanchezlando333@gmail.com', 'CivilRegistrar');
        $mail->addAddress($email); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP code is: <strong>$otp</strong>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

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

        $sql_check = "SELECT id FROM users WHERE email = '$email' UNION SELECT id FROM pending_users WHERE email = '$email'";
        $result_check = $conn->query($sql_check);

        if ($result_check === FALSE) {
            $response = ['error' => 'Query error: ' . $conn->error];
        } elseif ($result_check->num_rows > 0) {
            $response = ['error' => 'Email already exists'];
        } else {
            $otp = rand(100000, 999999); // Generate a random 6-digit OTP
            $sql = "INSERT INTO pending_users (name, email, password, role, otp) VALUES ('$name', '$email', '$password', '$role', '$otp')";
            if ($conn->query($sql) === TRUE) {
                if (sendOTP($email, $otp)) {
                    $response = ['message' => 'An OTP has been sent to your email.'];
                } else {
                    $response = ['error' => 'Failed to send OTP.'];
                }
            } else {
                $response = ['error' => 'Database error: ' . $conn->error];
            }
        }
    }
}
if ($method === 'POST' && isset($_GET['action']) && $_GET['action'] === 'verify_otp') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the required fields are present
    if (!isset($data['email'], $data['otp'])) {
        $response = ['error' => 'Invalid input'];
    } else {
        $email = $conn->real_escape_string($data['email']);
        $otp = $conn->real_escape_string($data['otp']);

        // Automatically delete OTP entries older than 1 minute
        $conn->query("DELETE FROM pending_users WHERE created_at < NOW() - INTERVAL 2 MINUTE");

        // Query to get the user's OTP and its age
        $sql = "SELECT *, TIMESTAMPDIFF(minute, created_at, NOW()) AS otp_age FROM pending_users WHERE email = '$email'";
        $result = $conn->query($sql);

        // Handle query results
        if ($result === false) {
            $response = ['error' => 'Query failed: ' . $conn->error];
        } elseif ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Check if the OTP is within the 1-minute limit
            if ($user['otp_age'] <= 2) {
                if ($otp === $user['otp']) {
                    // Insert the user into the users table
                    $sql_insert = "INSERT INTO users (name, email, password, role, otp) VALUES ('{$user['name']}', '{$user['email']}', '{$user['password']}', '{$user['role']}', '{$user['otp']}')";

                    // Execute the insertion and handle success or failure
                    if ($conn->query($sql_insert) === TRUE) {
                        // Optionally, delete the user from pending_users if insertion is successful
                        $conn->query("DELETE FROM pending_users WHERE email = '$email'");
                        $response = ['message' => 'User verified and registered successfully.'];
                    } else {
                        $response = ['error' => 'Database error: ' . $conn->error];
                    }
                } else {
                    $response = ['error' => 'Invalid OTP. Please try again.'];
                }
            } else {
                // OTP has expired
                $response = ['error' => 'OTP has expired. Please register again.'];

                // Automatically delete the user from pending_users if OTP expired
                $conn->query("DELETE FROM pending_users WHERE email = '$email'");
            }
        } else {
            $response = ['error' => 'No pending registration found for this email.'];
        }
    }
}

// New endpoint to delete a pending user by email
if ($method === 'DELETE' && isset($_GET['action']) && $_GET['action'] === 'delete_pending_user') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if email is provided
    if (!isset($data['email'])) {
        $response = ['error' => 'Email is required'];
    } else {
        $email = $conn->real_escape_string($data['email']);

        // SQL to delete the pending user
        $sql_delete_pending = "DELETE FROM pending_users WHERE email = '$email'";
        if ($conn->query($sql_delete_pending) === TRUE) {
            $response = ['message' => 'Pending user deleted successfully.'];
        } else {
            $response = ['error' => 'Failed to delete pending user: ' . $conn->error];
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
                    'exp' => time() + (60 * 60)  // Token valid for 1 hour
                ];

                $token = JWT::encode($payload);

                // Return both the token and the user's details including profile image
                $response = [
                    'token' => $token,
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'userId' => $user['id'], // Return userId
                    'email' => $user['email'],
                    'userProfile' => $user['userProfile'] // Include the profile image URL
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


