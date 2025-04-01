<?php
header('Content-Type: application/json');
include 'db.php'; // Include your database connection file

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {

    if (isset($_GET['residentId'])) {
        $residentId = intval($_GET['residentId']);
        
        // SQL query to fetch birth records for the specific resident
        $sql = "SELECT br.*, u.name AS user_name 
                FROM marriage_registration br
                JOIN users u ON br.userId = u.id 
                WHERE br.userId = $residentId";

        $result = $conn->query($sql);

        if ($result) {
            $marriageCertificates = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($marriageCertificates);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
        }
        exit;
    }

    // Check for count parameter
    if (isset($_GET['count']) && $_GET['count'] === 'true') {
        // Count total users
        $count_sql = "SELECT COUNT(*) AS total_marriage FROM marriage_registration";
        $count_result = $conn->query($count_sql);
        $total_count = $count_result ? $count_result->fetch_assoc()['total_marriage'] : 0;

        echo json_encode(['total' => $total_count]);
        exit;
    }
    // Check if an ID parameter is provided for a single marriage registration view
    if (isset($_GET['id'])) {
        // Retrieve a single marriage registration by ID
        $id = intval($_GET['id']);
        
        // Update the SQL query to join with the users table to get the name
        $sql = "SELECT br.*, u.name AS user_name 
                FROM marriage_registration br
                JOIN users u ON br.userId = u.id 
                WHERE br.id = $id";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $marriageCertificate = $result->fetch_assoc();
            echo json_encode($marriageCertificate);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Marriage registration not found.']);
        }
        exit; // Exit after handling single record request
    }
    // Get counts of marriage certificates based on assigned employee
    if (isset($_GET['get_employee_counts']) && isset($_GET['employee_id'])) {
        $employeeId = intval($_GET['employee_id']);
        
        // SQL query to get the count of death registrations assigned to the employee
        $sql = "SELECT COUNT(*) AS total_certificates 
                FROM marriage_registration 
                WHERE employee_id = $employeeId";
        
        $result = $conn->query($sql);
        
        if ($result) {
            $data = $result->fetch_assoc();
            echo json_encode(['total_certificates' => $data['total_certificates']]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
        }
        exit; // Exit after handling employee count request
    }

    // Retrieve marriage certificates with optional employee filter and search query
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $employeeId = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : null;
    $status = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';

    // Update the SQL query to include the join
    $sql = "SELECT br.*, u.name AS user_name 
            FROM marriage_registration br
            JOIN users u ON br.userId = u.id 
            WHERE 1=1";

    // Filter by employee ID if provided
    if ($employeeId) {
        $sql .= " AND br.employee_id = $employeeId";
    }

    // Filter by resident name instead of first name and last name
    if ($search) {
        $sql .= " AND br.reference_number LIKE '%$search%'";
    }
    // Filter by status if provided
    if ($status) {
        $sql .= " AND br.status = '$status'";
    }

    $result = $conn->query($sql);
    if ($result) {
        $marriageCertificates = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($marriageCertificates);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    }
}

if ($method === 'POST') {
    // Create a new marriage certificate
    $data = json_decode(file_get_contents('php://input'), true);

    // Define expected fields
    $fields = [
        'userId', 'employee_id', 'groom_first_name', 'groom_middle_name', 'groom_last_name', 
        'groom_suffix', 'groom_dob', 'groom_birth_place', 'bride_birth_place', 'groom_civil_status', 'groom_nationality', 
        'groom_father_name', 'groom_mother_name', 'bride_first_name', 'bride_middle_name', 
        'bride_last_name', 'bride_maiden_name', 'bride_suffix', 'bride_dob', 
        'bride_civil_status', 'bride_nationality', 'bride_father_name', 'bride_mother_name', 
        'marriage_date', 'marriage_place', 'groom_witness', 'bride_witness', 'status'
    ];

    // Validate and prepare data
    $values = [];
    foreach ($fields as $field) {
        if ($field === 'status') {
            $values[] = "pending"; // Default status
        } elseif (isset($data[$field])) {
            $values[] = $conn->real_escape_string($data[$field]);
        } elseif ($field === 'groom_suffix' || $field === 'bride_suffix') {
            $values[] = ''; // Default to empty string if not set
        } else {
            http_response_code(400);
            echo json_encode(['error' => "$field is required."]);
            exit;
        }
    }

    // Validate employee_id
    $employeeId = intval($data['employee_id']);
    $employeeCheckSql = "SELECT id FROM users WHERE id = $employeeId AND role = 'employee'";
    $employeeCheckResult = $conn->query($employeeCheckSql);

    if ($employeeCheckResult->num_rows === 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid employee_id.']);
        exit;
    }

    // Generate a unique reference number
    $referenceNumber = "MR-" . date("Ymd") . "-" . rand(1000, 9999);

    // Insert into database
    $sql = "INSERT INTO marriage_registration (" . implode(', ', $fields) . ", reference_number, created_at) 
            VALUES ('" . implode("', '", $values) . "', '$referenceNumber', NOW())";

    if ($conn->query($sql) === TRUE) {
        // Get the ID of the new marriage registration
        $marriageId = $conn->insert_id;

        // Prepare notification message
        $groomFullName = "{$data['groom_first_name']} {$data['groom_last_name']}";
        $brideFullName = "{$data['bride_first_name']} {$data['bride_last_name']}";
        $createdAt = date("F j, Y, g:i a");

        $notificationMessage = "A new marriage certificate has been registered for $groomFullName and $brideFullName (ID: $marriageId) at $createdAt.";

        // Insert notification
        $notificationSql = "INSERT INTO notifications (employee_id, message, type, read_status) 
                            VALUES ($employeeId, '$notificationMessage', 'marriage_registration', 0)";
        
        if ($conn->query($notificationSql) === TRUE) {
            echo json_encode([
                'message' => 'Marriage certificate registered successfully and notification sent to employee.',
                'marriageId' => $marriageId,
                'reference_number' => $referenceNumber
            ]);
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
        $sql = "UPDATE marriage_registration SET status = '$status' WHERE id = $id AND employee_id = $employeeId";
        
        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Marriage registration status updated successfully']);
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
    $sql = "DELETE FROM marriage_registration WHERE id = $id AND employee_id = $employeeId";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Marriage registration deleted successfully.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    }
}
?>
