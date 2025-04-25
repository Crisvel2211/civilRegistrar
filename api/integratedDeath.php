<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

include 'db.php'; // Ensure db.php has $conn = new mysqli(...);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $referenceNumber = 'DR-' . strtoupper(uniqid());

    $fields = [
        'deceased_first_name', 'deceased_last_name', 'deceased_middle_name',
        'deceased_nationality', 'deceased_date_of_birth', 'deceased_place_of_birth',
        'deceased_date_of_death', 'deceased_place_of_death', 'cause_of_death', 'certifier_name'
    ];

    $values = [];
    foreach ($fields as $field) {
        if (isset($data[$field])) {
            $values[] = $conn->real_escape_string($data[$field]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "$field is required."]);
            exit;
        }
    }

    $fields[] = 'reference_number';
    $values[] = $referenceNumber;

    $sql = "INSERT INTO integrated_death_registration (" . implode(', ', $fields) . ", created_at)
            VALUES ('" . implode("', '", $values) . "', NOW())";

    if ($conn->query($sql)) {
        echo json_encode([
            'message' => 'Death registered successfully.',
            'reference_number' => $referenceNumber
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database insert failed: ' . $conn->error]);
    }
}

if ($method === 'GET') {
    if (isset($_GET['reference_number'])) {
        $ref = $conn->real_escape_string($_GET['reference_number']);
        $sql = "SELECT * FROM integrated_death_registration WHERE reference_number = '$ref'";
        $result = $conn->query($sql);
        echo json_encode($result->fetch_assoc());
    } else {
        $sql = "SELECT * FROM integrated_death_registration";
        $result = $conn->query($sql);
        $records = [];
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
        echo json_encode($records);
    }
}

if ($method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['id']) || !isset($data['status'])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID and Status are required']);
        exit;
    }

    $id = intval($data['id']);
    $status = $conn->real_escape_string($data['status']);
    $sql = "UPDATE integrated_death_registration SET status = '$status' WHERE id = $id";

    if ($conn->query($sql)) {
        echo json_encode(['message' => 'Status updated successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Update failed: ' . $conn->error]);
    }
}

if ($method === 'DELETE') {
    if (isset($_GET['reference_number'])) {
        $ref = $conn->real_escape_string($_GET['reference_number']);
        $sql = "DELETE FROM integrated_death_registration WHERE reference_number = '$ref'";
        if ($conn->query($sql)) {
            echo json_encode(['message' => 'Record deleted']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Delete failed: ' . $conn->error]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Reference number is required']);
    }
}
?>
