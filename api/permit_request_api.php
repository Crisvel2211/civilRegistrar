<?php
header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");


include 'db.php'; // Include your database connection

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {

    if (isset($_GET['residentId'])) {
        $residentId = intval($_GET['residentId']);
        
        // SQL query to fetch birth records for the specific resident
        $sql = "SELECT br.*, u.name AS user_name 
                FROM permit_requests br
                JOIN users u ON br.userId = u.id 
                WHERE br.userId = $residentId";

        $result = $conn->query($sql);

        if ($result) {
            $birthCertificates = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($birthCertificates);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
        }
        exit;
    }

    // Check for count parameter
    if (isset($_GET['count']) && $_GET['count'] === 'true') {
        // Count total users
        $count_sql = "SELECT COUNT(*) AS total_birth FROM permit_requests";
        $count_result = $conn->query($count_sql);
        $total_count = $count_result ? $count_result->fetch_assoc()['total_birth'] : 0;

        echo json_encode(['total' => $total_count]);
        exit;
    }
    // Check if an ID parameter is provided for a single birth registration view
    if (isset($_GET['id'])) {
        // Retrieve a single birth registration by ID
        $id = intval($_GET['id']);
        
        // Update the SQL query to join with the users table to get the name
        $sql = "SELECT br.*, u.name AS user_name 
                FROM permit_requests br
                JOIN users u ON br.userId = u.id 
                WHERE br.id = $id";
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

    // Get counts of death certificates based on assigned employee
    if (isset($_GET['get_employee_counts']) && isset($_GET['employee_id'])) {
        $employeeId = intval($_GET['employee_id']);
        
        // SQL query to get the count of death registrations assigned to the employee
        $sql = "SELECT COUNT(*) AS total_certificates 
                FROM permit_requests 
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
    if (isset($_GET['get_resident_counts']) && isset($_GET['userId'])) {
        $userId = intval($_GET['userId']);
       
        
        // SQL query to get the count of death registrations assigned to the employee
        $sql = "SELECT COUNT(*) AS total_certificates 
                FROM permit_requests 
                WHERE userId = $userId";
        
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

    // Retrieve birth certificates with optional employee filter and search query
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $employeeId = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : null;
    $status = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';
    $createdAt = isset($_GET['created_at']) ? $conn->real_escape_string($_GET['created_at']) : '';

    // Update the SQL query to include the join
    $sql = "SELECT br.*, u.name AS user_name 
            FROM permit_requests br
            JOIN users u ON br.userId = u.id 
            WHERE 1=1";

    // Filter by employee ID if provided
    if ($employeeId) {
        $sql .= " AND br.employee_id = $employeeId";
    }

    if ($search) {
        $sql .= " AND br.reference_number LIKE '%$search%'";
    }

    // Filter by status if provided
    if ($status) {
        $sql .= " AND br.status = '$status'";
    }
    if (!empty($createdAt)) {
        if (strpos($createdAt, ':') !== false) {
            // Full datetime
            $sql .= " AND br.created_at = '$createdAt'";
        } else {
            // Just date
            $sql .= " AND DATE(br.created_at) = '$createdAt'";
        }
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

    $referenceNumber = 'PR-' . strtoupper(uniqid());

    // Define expected fields
    $fields = [
        'userId', 'employee_id', 'permit_type', 'resident_name', 'date_of_request', 'additional_details',
         'status'
    ];

    // Validate and prepare data
    $values = [];
    foreach ($fields as $field) {
        if ($field === 'status') {
            $values[] = "pending"; // Default status
        } elseif (isset($data[$field])) {
            $values[] = $conn->real_escape_string($data[$field]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => "$field is required."]);
            exit;
        }
    }

    // Add reference number to the values
    $fields[] = 'reference_number';
    $values[] = $referenceNumber;

    // Insert the new record
    $sql = "INSERT INTO permit_requests (" . implode(', ', $fields) . ", created_at) VALUES ('" . implode("', '", $values) . "', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        $permitId = $conn->insert_id;

        echo json_encode([
            'message' => 'Permit registered successfully.',
            'permitId' => $permitId,
            'reference_number' => $referenceNumber
        ]);
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
        $sql = "UPDATE permit_requests SET status = '$status' WHERE id = $id AND employee_id = $employeeId";
        
        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Permit status updated successfully']);
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
    $sql = "DELETE FROM permit_requests WHERE id = $id AND employee_id = $employeeId";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Permit Requests deleted successfully.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    }
}




?>
