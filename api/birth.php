<?php
header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';


include 'db.php'; // Include your database connection

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {

    if (isset($_GET['residentId'])) {
        $residentId = intval($_GET['residentId']);
        
        // SQL query to fetch birth records for the specific resident
        $sql = "SELECT br.*, u.name AS user_name 
                FROM birth_registration br
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
        $count_sql = "SELECT COUNT(*) AS total_birth FROM birth_registration";
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
                FROM birth_registration br
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
                FROM birth_registration 
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

     // Get counts of death certificates based on assigned employee
     if (isset($_GET['get_resident_counts']) && isset($_GET['userId'])) {
        $userId = intval($_GET['userId']);
       
        
        // SQL query to get the count of death registrations assigned to the employee
        $sql = "SELECT COUNT(*) AS total_certificates 
                FROM birth_registration 
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

    // Update the SQL query to include the join
    $sql = "SELECT br.*, u.name AS user_name 
            FROM birth_registration br
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

   
    $referenceNumber = 'BR-' . strtoupper(uniqid());

    // Define expected fields
    $fields = [
        'userId', 'employee_id', 'child_first_name', 'child_last_name', 'child_middle_name', 'child_sex',
        'child_date_of_birth', 'child_time_of_birth', 'child_place_of_birth',
        'child_birth_type', 'child_birth_order', 'father_first_name', 'father_last_name',
        'father_middle_name', 'father_suffix', 'father_nationality', 'father_date_of_birth',
        'father_place_of_birth', 'mother_first_name', 'mother_last_name', 
        'mother_middle_name', 'mother_maiden_name', 'mother_nationality', 
        'mother_date_of_birth', 'mother_place_of_birth', 'parents_married_at_birth', 'status'
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
    $sql = "INSERT INTO birth_registration (" . implode(', ', $fields) . ", created_at) VALUES ('" . implode("', '", $values) . "', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        $birthId = $conn->insert_id;

         // Send email notification using PHPMailer
         $mail = new PHPMailer(true);
         try {
             // Server settings
             $mail->isSMTP();
             $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
             $mail->SMTPAuth   = true;
             $mail->Username   = 'sanchezlando333@gmail.com'; // SMTP username
             $mail->Password   = 'ifkkfcdkadzhcggh'; // SMTP password
             $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
             $mail->Port       = 587;
 
             // Recipients
             $mail->setFrom('sanchezlando333@gmail.com', 'CivilRegistrar');
             $mail->addAddress('sanchezlando333@gmail.com'); // Add a recipient
 
             // Content
             $mail->isHTML(true);
             $mail->Subject = 'New Birth Registration Created';
             $mail->Body    = "
             A new birth registration has been created:
             
             Reference Number: $referenceNumber
             Child: {$data['child_first_name']} {$data['child_last_name']}
             Birth Date: {$data['child_date_of_birth']}
             Birth Time: {$data['child_time_of_birth']}
             Parent(s): {$data['father_first_name']} {$data['father_last_name']} and {$data['mother_first_name']} {$data['mother_last_name']}
             Status: Pending
             
             Please verify the details in the system.";
 
             $mail->send();
 
             echo json_encode([
                 'message' => 'Birth certificate registered successfully.',
                 'birthId' => $birthId,
                 'reference_number' => $referenceNumber
             ]);
         } catch (Exception $e) {
             echo json_encode(['error' => 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo]);
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
            // Send email with PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
                $mail->SMTPAuth   = true;
                $mail->Username   = 'sanchezlando333@gmail.com'; // SMTP username
                $mail->Password   = 'ifkkfcdkadzhcggh'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('sanchezlando333@gmail.com', 'CivilRegistrar');
                $mail->addAddress('sanchezlando333@gmail.com'); // Add a recipient

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Birth Registration Status Updated';
                $mail->Body    = "
                The status of a birth registration has been updated:
                 
                ID: $id
                Status: $status
                
                Please verify the details in the system.";

                // Send the email
                $mail->send();

                echo json_encode(['success' => true, 'message' => 'Birth registration status updated successfully']);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
            }
            
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
