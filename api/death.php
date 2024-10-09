<?php
header('Content-Type: application/json');
include 'db.php'; // Include your database connection file

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Check if an ID parameter is provided for a single death registration view
    if (isset($_GET['id'])) {
        // Retrieve a single death registration by ID
        $id = intval($_GET['id']);
        
        // Update the SQL query to join with the users table to get the name
        $sql = "SELECT br.*, u.name AS user_name 
                FROM death_registration br
                JOIN users u ON br.userId = u.id 
                WHERE br.id = $id";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $deathCertificate = $result->fetch_assoc();
            echo json_encode($deathCertificate);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'death registration not found.']);
        }
        exit; // Exit after handling single record request
    }
     // Get counts of death certificates based on assigned employee
     if (isset($_GET['get_employee_counts']) && isset($_GET['employee_id'])) {
        $employeeId = intval($_GET['employee_id']);
        
        // SQL query to get the count of death registrations assigned to the employee
        $sql = "SELECT COUNT(*) AS total_certificates 
                FROM death_registration 
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

    // Retrieve death certificates with optional employee filter and search query
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $employeeId = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : null;
    $status = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';

    // Update the SQL query to include the join
    $sql = "SELECT br.*, u.name AS user_name 
            FROM death_registration br
            JOIN users u ON br.userId = u.id 
            WHERE 1=1";

    // Filter by employee ID if provided
    if ($employeeId) {
        $sql .= " AND br.employee_id = $employeeId";
    }

    // Filter by resident name instead of first name and last name
    if ($search) {
        $sql .= " AND (CONCAT(u.name) LIKE '%$search%')";
    }

    // Filter by status if provided
    if ($status) {
        $sql .= " AND br.status = '$status'";
    }

    $result = $conn->query($sql);
    if ($result) {
        $deathCertificates = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($deathCertificates);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    }
}

if ($method === 'POST') {
    // Create a new death certificate
    $data = json_decode(file_get_contents('php://input'), true);

    // Define expected fields, including userId and employeeId for the death registration
    $fields = [
        'userId', 'employee_id', 'deceased_first_name', 'deceased_middle_name', 'deceased_last_name', 
        'deceased_dob', 'date_of_death', 'place_of_death', 'cause_of_death', 
        'informant_name', 'relationship_to_deceased', 'informant_contact', 'disposition_method', 
        'disposition_date', 'disposition_location', 'status'
    ];

    // Validate and prepare data, including userId and employee_id
    $values = [];
    foreach ($fields as $field) {
        if ($field === 'status') {
            // Set default status if not provided
            $values[] = "pending"; // Default status
        } elseif (isset($data[$field])) {
            // Escape input for security
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

    // Insert the new death certificate record, including userId and employee_id
    $sql = "INSERT INTO death_registration (" . implode(', ', $fields) . ", created_at) VALUES ('" . implode("', '", $values) . "', NOW())"; // Capture created_at
    
    if ($conn->query($sql) === TRUE) {
        // Get the ID of the newly registered death certificate
        $deathId = $conn->insert_id;

        
        $FullName = "{$data['deceased_first_name']} {$data['deceased_last_name']}";

        // Get the created_at timestamp
        $createdAt = date("F j, Y, g:i a"); // Adjust format as needed

        // Create the notification message
        $notificationMessage = "A new death certificate has been registered for $FullName and (ID: $deathId) at $createdAt.";

        // Insert notification for the employee
        $notificationSql = "INSERT INTO notifications (employee_id, message, type, read_status) VALUES ($employeeId, '$notificationMessage', 'death_registration', 0)";
        
        if ($conn->query($notificationSql) === TRUE) {
            echo json_encode(['message' => 'death certificate registered successfully and notification sent to employee.']);
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
        $sql = "UPDATE death_registration SET status = '$status' WHERE id = $id AND employee_id = $employeeId";
        
        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'death registration status updated successfully']);
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
    $sql = "DELETE FROM death_registration WHERE id = $id AND employee_id = $employeeId";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'death registration deleted successfully.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
    }
}
?>
