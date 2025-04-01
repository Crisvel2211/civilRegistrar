<?php
header('Content-Type: application/json');
require 'db.php';  // Assumes $conn is set up here

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    // GET - Retrieve one or all records
    case 'GET':
        if (isset($_GET['id'])) {
            // Get a single record by id
            $id = intval($_GET['id']);
            $stmt = $conn->prepare("SELECT * FROM legal_admin_services WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo json_encode($result->fetch_assoc());
            } else {
                echo json_encode(['message' => 'Record not found']);
            }
            $stmt->close();
        } else {
            // Get all records
            $result = $conn->query("SELECT * FROM legal_admin_services");
            $records = [];
            while ($row = $result->fetch_assoc()) {
                $records[] = $row;
            }
            echo json_encode($records);
        }
        break;

    // POST - Create a new record
    case 'POST':
        // Read JSON input
        $data = json_decode(file_get_contents("php://input"), true);
        
        // Check required fields; now also require user_id
        if (
            empty($data['service_name']) ||
            empty($data['applicant_name']) ||
            empty($data['applicant_contact']) ||
            empty($data['applicant_address']) ||
            empty($data['reason_for_change']) ||
            empty($data['reference_number']) ||
            empty($data['user_id'])
        ) {
            echo json_encode([
                'success' => false,
                'message' => 'Missing required fields.'
            ]);
            exit;
        }

        // Generate a unique case_reference_no
        $case_reference_no = 'CASE-' . strtoupper(uniqid());

        $service_name      = $data['service_name'];
        $applicant_name    = $data['applicant_name'];
        $applicant_contact = $data['applicant_contact'];
        $applicant_address = $data['applicant_address'];
        $reason_for_change = $data['reason_for_change'];
        $reference_number  = $data['reference_number'];
        $user_id           = $data['user_id'];
        $employee_id       = isset($data['employee_id']) ? $data['employee_id'] : null;  // Optional

        $stmt = $conn->prepare("INSERT INTO legal_admin_services (case_reference_no, service_name, applicant_name, applicant_contact, applicant_address, reason_for_change, reference_number, user_id, employee_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        // Use "ssssssiii" if employee_id is integer and may be null (using "i" for both user_id and employee_id)
        $stmt->bind_param("sssssssii", $case_reference_no, $service_name, $applicant_name, $applicant_contact, $applicant_address, $reason_for_change, $reference_number, $user_id, $employee_id);

        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Record created successfully.',
                'case_reference_no' => $case_reference_no
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to create record.',
                'error'   => $stmt->error
            ]);
        }
        $stmt->close();
        break;

    // PUT - Update an existing record
    case 'PUT':
        if (!isset($_GET['id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'ID is required for updating a record.'
            ]);
            exit;
        }

        $id = intval($_GET['id']);
        $data = json_decode(file_get_contents("php://input"), true);

        // Build dynamic update query based on provided fields
        $fields = [];
        $params = [];
        $types  = "";

        if (isset($data['service_name'])) {
            $fields[] = "service_name = ?";
            $params[] = $data['service_name'];
            $types   .= "s";
        }
        if (isset($data['applicant_name'])) {
            $fields[] = "applicant_name = ?";
            $params[] = $data['applicant_name'];
            $types   .= "s";
        }
        if (isset($data['applicant_contact'])) {
            $fields[] = "applicant_contact = ?";
            $params[] = $data['applicant_contact'];
            $types   .= "s";
        }
        if (isset($data['applicant_address'])) {
            $fields[] = "applicant_address = ?";
            $params[] = $data['applicant_address'];
            $types   .= "s";
        }
        if (isset($data['reason_for_change'])) {
            $fields[] = "reason_for_change = ?";
            $params[] = $data['reason_for_change'];
            $types   .= "s";
        }
        if (isset($data['reference_number'])) {
            $fields[] = "reference_number = ?";
            $params[] = $data['reference_number'];
            $types   .= "s";
        }
        if (isset($data['status'])) {
            $fields[] = "status = ?";
            $params[] = $data['status'];
            $types   .= "s";
        }
        if (isset($data['user_id'])) {
            $fields[] = "user_id = ?";
            $params[] = $data['user_id'];
            $types   .= "i";
        }
        if (isset($data['employee_id'])) {
            $fields[] = "employee_id = ?";
            $params[] = $data['employee_id'];
            $types   .= "i";
        }

        if (empty($fields)) {
            echo json_encode([
                'success' => false,
                'message' => 'No fields provided for update.'
            ]);
            exit;
        }

        $query = "UPDATE legal_admin_services SET " . implode(", ", $fields) . " WHERE id = ?";
        $params[] = $id;
        $types   .= "i";

        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Record updated successfully.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update record.',
                'error'   => $stmt->error
            ]);
        }
        $stmt->close();
        break;

    // DELETE - Remove a record
    case 'DELETE':
        if (!isset($_GET['id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'ID is required for deletion.'
            ]);
            exit;
        }
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("DELETE FROM legal_admin_services WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Record deleted successfully.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to delete record.',
                'error'   => $stmt->error
            ]);
        }
        $stmt->close();
        break;

    default:
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method.'
        ]);
        break;
}
?>
