<?php
include 'db.php'; // Include your database connection file

if (isset($_GET['token'])) {
    $token = $conn->real_escape_string($_GET['token']);

    // Find user with this token
    $sql = "SELECT id FROM users WHERE verification_token = '$token'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Update user to set verified status
        $sql_update = "UPDATE users SET is_verified = 1, verification_token = NULL WHERE verification_token = '$token'";
        if ($conn->query($sql_update) === TRUE) {
            echo "Email verified successfully!";
        } else {
            echo "Error verifying email: " . $conn->error;
        }
    } else {
        echo "Invalid token!";
    }
} else {
    echo "No token provided!";
}
?>
