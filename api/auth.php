<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php'; // Include your database connection file
include 'jwt.php';   // Include your JWT helper file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

$method = $_SERVER['REQUEST_METHOD'];
$response = []; // Initialize an array to collect responses

// User Registration
if ($method === 'POST' && isset($_GET['action']) && $_GET['action'] === 'register') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['name'], $data['email'], $data['password'], $data['role'])) {
        $response = ['error' => 'Invalid input'];
    } else {
        $name = trim($conn->real_escape_string($data['name']));
        $email = trim($conn->real_escape_string($data['email']));
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        $role = trim($conn->real_escape_string($data['role']));
        $verification_token = bin2hex(random_bytes(16)); // Generate a unique token

        $sql_check = "SELECT id FROM users WHERE email = '$email'";
        $result_check = $conn->query($sql_check);

        if ($result_check === FALSE) {
            $response = ['error' => 'Query error: ' . $conn->error];
        } elseif ($result_check->num_rows > 0) {
            $response = ['error' => 'Email already exists'];
        } else {
            // Insert the user into the database with the verification token
            $sql = "INSERT INTO users (name, email, password, role, verification_token, is_verified) VALUES ('$name', '$email', '$password', '$role', '$verification_token', 0)";
            if ($conn->query($sql) === TRUE) {
                // Send verification email
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'sanchezlando333@gmail.com'; // Your email
                    $mail->Password   = 'ifkkfcdkadzhcggh'; // Your email password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    $mail->setFrom('sanchezlando333@gmail.com', 'CivilRegistrar');
                    $mail->addAddress($email, $name);

                    $mail->isHTML(true);
                    $mail->Subject = 'Email Verification';
                    $mail->Body    = "Hi $name,<br><br>Thank you for registering! Please verify your email by clicking on the link below:<br><a href='http://localhost/civil-registrar/api/verifyTokenEmail.php?token=$verification_token'>Verify Email</a><br><br>Thank you!";
                    $mail->send();

                    $response = ['message' => 'User registered successfully. Please check your email for verification.'];
                } catch (Exception $e) {
                    $response = ['error' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"];
                }
            } else {
                $response = ['error' => 'Database error: ' . $conn->error];
            }
        }
    }
}

// User Login
if ($method === 'POST' && isset($_GET['action']) && $_GET['action'] === 'login') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['email'], $data['password'])) {
        $response = ['error' => 'Invalid input'];
    } else {
        $email = $conn->real_escape_string($data['email']);
        $password = $data['password'];

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $payload = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'exp' => time() + (60 * 60) // Token valid for 1 hour
                ];

                $token = JWT::encode($payload);
                $response = [
                    'token' => $token,
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'userId' => $user['id'],
                    'email' => $user['email']
                ];
            } else {
                $response = ['error' => 'Invalid password'];
            }
        } else {
            $response = ['error' => 'User not found'];
        }
    }
}

// JWT validation endpoint
if ($method === 'GET' && isset($_GET['action']) && $_GET['action'] === 'validate') {
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
