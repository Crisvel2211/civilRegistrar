<?php
header('Content-Type: application/json');
include 'db.php';

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Check if an ID parameter is provided
    if (isset($_GET['id'])) {
        // Retrieve a resident by ID
        $id = intval($_GET['id']); // Ensure ID is an integer to prevent SQL injection
        $residentSql = "SELECT id, name FROM users WHERE id = $id AND role = 'resident'";
        
        $residentResult = $conn->query($residentSql);

        if ($residentResult && $residentResult->num_rows > 0) {
            $resident = $residentResult->fetch_assoc();
            echo json_encode($resident);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Resident not found.']);
        }
    } else {
        // Retrieve all residents
        $residentSql = "SELECT id, name FROM users WHERE role = 'resident'";
        $residentResult = $conn->query($residentSql);

        if ($residentResult) {
            $residents = [];
            while ($row = $residentResult->fetch_assoc()) {
                $residents[] = $row;
            }
            echo json_encode($residents);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
        }
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Method not allowed.']);
}
?>
