<?php
header("Content-Type: application/json");
include 'db.php'; // Include database connection

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Create a new permit request
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['permit_type'], $data['resident_name'], $data['date_of_request'], $data['user_id'], $data['employee_id'])) {
        echo json_encode(["error" => "Missing required fields"]);
        exit();
    }

    // Generate a unique reference number
    $reference_number = 'PR-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));

    $permit_type = $data['permit_type'];
    $resident_name = $data['resident_name'];
    $date_of_request = $data['date_of_request'];
    $additional_details = isset($data['additional_details']) ? $data['additional_details'] : '';
    $user_id = $data['user_id'];
    $employee_id = $data['employee_id'];

    $query = "INSERT INTO permit_requests (reference_number, permit_type, resident_name, date_of_request, additional_details, user_id, employee_id) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssii", $reference_number, $permit_type, $resident_name, $date_of_request, $additional_details, $user_id, $employee_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Permit request submitted successfully", "reference_number" => $reference_number]);
    } else {
        echo json_encode(["error" => "Failed to submit request", "details" => $stmt->error]);
    }

    $stmt->close();
}

elseif ($method === 'GET' && isset($_GET['id'])) {
    // Get a single permit request
    $id = $_GET['id'];
    $query = "SELECT * FROM permit_requests WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Permit request not found"]);
    }

    $stmt->close();
}

elseif ($method === 'GET') {
    // Get all permit requests
    $query = "SELECT * FROM permit_requests ORDER BY created_at DESC";
    $result = $conn->query($query);

    $requests = [];
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }

    echo json_encode($requests);
}

elseif ($method === 'PUT' && isset($_GET['id'])) {
    // Update a permit request
    $id = $_GET['id'];
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['permit_type'], $data['resident_name'], $data['date_of_request'], $data['user_id'], $data['employee_id'])) {
        echo json_encode(["error" => "Missing required fields"]);
        exit();
    }

    $permit_type = $data['permit_type'];
    $resident_name = $data['resident_name'];
    $date_of_request = $data['date_of_request'];
    $additional_details = isset($data['additional_details']) ? $data['additional_details'] : '';
    $user_id = $data['user_id'];
    $employee_id = $data['employee_id'];

    $query = "UPDATE permit_requests SET permit_type=?, resident_name=?, date_of_request=?, additional_details=?, user_id=?, employee_id=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssiii", $permit_type, $resident_name, $date_of_request, $additional_details, $user_id, $employee_id, $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Permit request updated successfully"]);
    } else {
        echo json_encode(["error" => "Failed to update request"]);
    }

    $stmt->close();
}

elseif ($method === 'DELETE' && isset($_GET['id'])) {
    // Delete a permit request
    $id = $_GET['id'];
    $query = "DELETE FROM permit_requests WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Permit request deleted successfully"]);
    } else {
        echo json_encode(["error" => "Failed to delete request"]);
    }

    $stmt->close();
}

else {
    echo json_encode(["error" => "Invalid request method"]);
}

$conn->close();
?>
