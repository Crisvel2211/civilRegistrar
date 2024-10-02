<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

include 'db.php'; // Your database connection file

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Retrieve notifications for a specific employee
    $employeeId = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : null;

    if ($employeeId === null) {
        http_response_code(400);
        echo json_encode(['error' => 'employee_id is required']);
        exit;
    }

    // Fetch unread notifications for the employee
    $sql = "SELECT * FROM notifications WHERE employee_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
    }

    echo json_encode($notifications);
    $stmt->close();
}

if ($method === 'POST') {
    // Create a new notification
    $data = json_decode(file_get_contents('php://input'), true);

    // Check required fields
    $requiredFields = ['employee_id', 'message', 'type'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            http_response_code(400);
            echo json_encode(['error' => "$field is required"]);
            exit;
        }
    }

    // Insert notification into the database
    $employeeId = intval($data['employee_id']);
    $message = $conn->real_escape_string($data['message']);
    $type = $conn->real_escape_string($data['type']);
    $status = isset($data['read_status']) ? intval($data['read_status']) : 0; // Default to unread

    $sql = "INSERT INTO notifications (employee_id, message, type, read_status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issi', $employeeId, $message, $type, $status);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Notification created successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to create notification: ' . $conn->error]);
    }

    $stmt->close();
}

if ($method === 'PUT') {
    // Update the read status of a notification
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id']) || !isset($data['employee_id']) || !isset($data['read_status'])) {
        http_response_code(400);
        echo json_encode(['error' => 'id, employee_id, and read_status are required']);
        exit;
    }

    $id = intval($data['id']);
    $employeeId = intval($data['employee_id']);
    $readStatus = intval($data['read_status']);

    // Update the notification read status
    $sql = "UPDATE notifications SET read_status = ? WHERE id = ? AND employee_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $readStatus, $id, $employeeId);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Notification updated successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to update notification: ' . $conn->error]);
    }

    $stmt->close();
}
?>
