<?php
header('Content-Type: application/json');
include 'db.php'; // Include your database connection file

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Check if an ID parameter is provided for a single birth registration view
    if (isset($_GET['id'])) {
        // Retrieve a single birth registration by ID
        $id = intval($_GET['id']);
        
        $sql = "SELECT * FROM birth_registration WHERE id = $id";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $birthCertificate = $result->fetch_assoc();
            echo json_encode($birthCertificate);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Birth registration not found.']);
        }
        exit; // Exit after handling single record request
    }

    // Retrieve birth certificates with optional employee filter and search query
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $employeeId = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : null;
    $status = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';

    $sql = "SELECT * FROM birth_registration WHERE 1=1";

    // Filter by employee ID if provided
    if ($employeeId) {
        $sql .= " AND employee_id = $employeeId";
    }

    // Filter by search query
    if ($search) {
        $sql .= " AND (child_first_name LIKE '%$search%' OR child_last_name LIKE '%$search%')";
    }

    // Filter by status if provided
    if ($status) {
        $sql .= " AND status = '$status'";
    }

    $result = $conn->query($sql);
    if ($result) {
        $birthCertificates = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($birthCertificates);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    }
}



if ($method === 'POST') {
    // Create a new birth certificate
    $data = json_decode(file_get_contents('php://input'), true);

    // Define expected fields, including userId and employeeId
    $fields = [
        'userId', 'employee_id', 'child_first_name', 'child_last_name', 'child_middle_name', 'child_sex',
        'child_date_of_birth', 'child_time_of_birth', 'child_place_of_birth',
        'child_birth_type', 'child_birth_order', 'father_first_name', 'father_last_name',
        'father_middle_name', 'father_suffix', 'father_nationality', 'father_date_of_birth',
        'father_place_of_birth', 'mother_first_name', 'mother_last_name', 
        'mother_middle_name', 'mother_maiden_name', 'mother_nationality', 
        'mother_date_of_birth', 'mother_place_of_birth', 'parents_married_at_birth', 'status'
    ];

    // Validate and prepare data, including userId and employee_id
    $values = [];
    foreach ($fields as $field) {
        if ($field === 'status') {
            // Set default status if not provided
            $values[] = "pending"; // Default status
        } elseif (isset($data[$field])) {
            $values[] = $conn->real_escape_string($data[$field]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => "$field is required."]);
            exit;
        }
    }

    // Validate employee_id by checking if it's a valid employee
    $employeeId = intval($data['employee_id']);
    $employeeCheckSql = "SELECT id FROM users WHERE id = $employeeId AND role = 'employee'";
    $employeeCheckResult = $conn->query($employeeCheckSql);

    if ($employeeCheckResult->num_rows === 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid employee_id.']);
        exit;
    }

    // Insert the new record, including userId and employee_id
    $sql = "INSERT INTO birth_registration (" . implode(', ', $fields) . ", created_at) VALUES ('" . implode("', '", $values) . "', NOW())"; // Capture created_at
    
    if ($conn->query($sql) === TRUE) {
        // Get the ID of the newly registered birth certificate
        $birthId = $conn->insert_id;

        // Prepare the child's full name for the notification
        $childFullName = "{$data['child_first_name']} {$data['child_last_name']}";
        
        // Get the created_at timestamp
        $createdAt = date("F j, Y, g:i a"); // Adjust format as needed

        // Create the notification message
        $notificationMessage = "A new birth certificate has been registered for $childFullName (ID: $birthId) at $createdAt.";

        // Insert notification for the employee
        $notificationSql = "INSERT INTO notifications (employee_id, message, type, read_status) VALUES ($employeeId, '$notificationMessage', 'birth_registration', 0)";
        
        if ($conn->query($notificationSql) === TRUE) {
            echo json_encode(['message' => 'Birth certificate registered successfully and notification sent to employee.']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to insert notification: ' . $conn->error]);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    }
}



if ($method === 'PUT') {
    // Read the JSON input and decode it
    $data = json_decode(file_get_contents('php://input'), true);
    
    if ($data === null) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON input.']);
        exit;
    }

    // Check if ID and employee_id are provided
    $id = isset($data['id']) ? intval($data['id']) : null;
    $employeeId = isset($data['employee_id']) ? intval($data['employee_id']) : null;

    if ($id === null || $employeeId === null) {
        http_response_code(400);
        echo json_encode(['error' => 'ID and employee_id are required.']);
        exit;
    }

    // Validate employee_id by checking if it's a valid employee
    $employeeCheckSql = "SELECT id FROM users WHERE id = $employeeId AND role = 'employee'";
    $employeeCheckResult = $conn->query($employeeCheckSql);

    if ($employeeCheckResult->num_rows === 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid employee_id.']);
        exit;
    }

    // Ensure only status is being updated
    if (isset($data['status'])) {
        $status = $conn->real_escape_string($data['status']);

        // Construct the SQL UPDATE query
        $sql = "UPDATE birth_registration SET status = '$status' WHERE id = $id AND employee_id = $employeeId";
        
        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Birth registration status updated successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database query failed: ' . $conn->error]);
        }
        
        
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Status is required for update']);
    }
}






if ($method === 'DELETE') {
    // Get the Content-Type header
    $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

    // Parse input based on Content-Type
    if ($contentType === 'application/json') {
        $data = json_decode(file_get_contents('php://input'), true);
    } else {
        parse_str(file_get_contents('php://input'), $data);
    }

    if ($data === null) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input.']);
        exit;
    }

    // Ensure ID and employee_id are provided
    $id = isset($data['id']) ? intval($data['id']) : null;
    $employeeId = isset($data['employee_id']) ? intval($data['employee_id']) : null;

    if ($id === null || $employeeId === null) {
        http_response_code(400);
        echo json_encode(['error' => 'ID and employee_id are required.']);
        exit;
    }

    // Validate employee_id by checking if it's a valid employee
    $employeeCheckSql = "SELECT id FROM users WHERE id = $employeeId AND role = 'employee'";
    $employeeCheckResult = $conn->query($employeeCheckSql);

    if ($employeeCheckResult->num_rows === 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid employee_id.']);
        exit;
    }

    // Prepare and execute the DELETE query
    $sql = "DELETE FROM birth_registration WHERE id = $id AND employee_id = $employeeId";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Birth certificate deleted successfully.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    }
}




?>
