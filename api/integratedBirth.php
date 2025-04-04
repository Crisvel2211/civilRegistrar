<?php
header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

include 'db.php'; // Include your database connection

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';  // Path to your autoload.php file

$method = $_SERVER['REQUEST_METHOD']; // Get the request method (GET, POST, PUT, DELETE)

if ($method === 'POST') {
    // Create a new birth registration
    $data = json_decode(file_get_contents('php://input'), true);

    // Generate unique reference number for the birth registration
    $referenceNumber = 'BR-' . strtoupper(uniqid());

    // Define expected fields
    $fields = [
        'child_first_name', 'child_last_name', 'child_middle_name', 'child_sex', 'child_date_of_birth', 
        'child_time_of_birth', 'child_place_of_birth', 'child_birth_type', 'child_birth_order', 
        'father_first_name', 'father_last_name', 'father_middle_name', 'father_suffix', 
        'father_nationality', 'father_date_of_birth', 'father_place_of_birth', 'mother_first_name', 
        'mother_last_name', 'mother_middle_name', 'mother_maiden_name', 'mother_nationality', 
        'mother_date_of_birth', 'mother_place_of_birth', 'parents_married_at_birth'
    ];

    // Validate and prepare data
    $values = [];
    foreach ($fields as $field) {
        if (isset($data[$field])) {
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

    // Insert the new record into the database
    $sql = "INSERT INTO integrated_birth_registration (" . implode(', ', $fields) . ", created_at) 
            VALUES ('" . implode("', '", $values) . "', NOW())";

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

if ($method === 'GET') {
    // Retrieve all birth registrations or a single registration based on reference number
    if (isset($_GET['reference_number'])) {
        // Fetch single birth registration by reference number
        $referenceNumber = $conn->real_escape_string($_GET['reference_number']);

        $sql = "SELECT * FROM integrated_birth_registration WHERE reference_number = '$referenceNumber'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No record found with the given reference number.']);
        }
    } else {
        // Fetch all birth registrations
        $sql = "SELECT * FROM integrated_birth_registration";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'No records found.']);
        }
    }
}

if ($method === 'PUT') {
    // Update an existing birth registration
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data === null) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON input.']);
        exit;
    }

    // Check if ID is provided
    $id = isset($data['id']) ? intval($data['id']) : null;
    if ($id === null) {
        http_response_code(400);
        echo json_encode(['error' => 'ID is required for update.']);
        exit;
    }

    // Check if status is provided for update
    if (isset($data['status'])) {
        $status = $conn->real_escape_string($data['status']);

        // Update the birth registration status
        $sql = "UPDATE integrated_birth_registration SET status = '$status' WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            // Send email notification to admin (or relevant stakeholder)
            $to = 'sanchezlando333@gmail.com';
            $subject = 'Birth Registration Status Updated';
            $message = "The status of a birth registration has been updated:
            
            ID: $id
            Status: $status

            Please verify the details in the system.";

            $headers = 'From: no-reply@example.com' . "\r\n" .
                       'Reply-To: no-reply@example.com' . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();
            
            // Send the email
            mail($to, $subject, $message, $headers);

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
    // Delete a birth registration record by reference number
    if (isset($_GET['reference_number'])) {
        $referenceNumber = $conn->real_escape_string($_GET['reference_number']);
        
        $sql = "DELETE FROM integrated_birth_registration WHERE reference_number = '$referenceNumber'";

        if ($conn->query($sql) === TRUE) {
            // Send email notification to admin (or relevant stakeholder)
            $to = 'sanchezlando333@gmail.com';
            $subject = 'Birth Registration Record Deleted';
            $message = "A birth registration record has been deleted:
            
            Reference Number: $referenceNumber
            
            Please verify the details in the system.";

            $headers = 'From: no-reply@example.com' . "\r\n" .
                       'Reply-To: no-reply@example.com' . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();
            
            // Send the email
            mail($to, $subject, $message, $headers);

            echo json_encode(['message' => 'Record deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Reference number is required for deletion']);
    }
}
?>
