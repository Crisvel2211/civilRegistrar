<?php
header('Content-Type: application/json');
include 'db.php';

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $employeeSql = "SELECT id, name FROM users WHERE role = 'employee'";
    $employeeResult = $conn->query($employeeSql);

    if ($employeeResult) {
        $employees = [];
        while ($row = $employeeResult->fetch_assoc()) {
            $employees[] = $row;
        }
        echo json_encode($employees);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed.']);
}
?>
