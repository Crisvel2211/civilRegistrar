<?php
header("Access-Control-Allow-Origin: *"); // Allow all origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
include 'db.php'; // Make sure this file sets $conn properly

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// GET: Fetch one or all records
if ($method === 'GET') {
    if ($id) {
        $stmt = $conn->prepare("SELECT * FROM census WHERE person_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo json_encode($result->fetch_assoc());
    } else {
        $result = $conn->query("SELECT * FROM census");
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    }
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $fields = [
        'person_id', 'household_id', 'first_name', 'last_name', 'date_of_birth', 'age', 'gender',
        'nationality', 'ethnicity', 'address', 'city', 'state', 'zip_code', 'phone_number',
        'email', 'occupation', 'employment_status', 'income', 'education_level',
        'marital_status', 'disability_status', 'language_spoken_at_home',
        'number_of_children', 'home_ownership_status', 'religion'
    ];

    $values = [];
    foreach ($fields as $field) {
        if (!isset($data[$field])) {
            http_response_code(400);
            echo json_encode(['error' => "$field is required."]);
            exit;
        }
        $values[] = $conn->real_escape_string($data[$field]);
    }

    // Build the SQL query
    $sql = "INSERT INTO census (" . implode(", ", $fields) . ", date_recorded) VALUES ('" .
        implode("', '", $values) . "', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Census record added successfully.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database insert failed: ' . $conn->error]);
    }
}


// PUT: Update existing record
elseif ($method === 'PUT' && $id) {
    $data = json_decode(file_get_contents("php://input"), true);

    $fields = "";
    $params = [];
    $types = "";

    foreach ($data as $key => $value) {
        $fields .= "$key = ?, ";
        $params[] = $value;
        $types .= is_int($value) ? "i" : (is_float($value) ? "d" : "s");
    }

    $fields = rtrim($fields, ", ");
    $params[] = $id;
    $types .= "i";

    $sql = "UPDATE census SET $fields WHERE person_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Record updated successfully']);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }
}

// DELETE: Remove record
elseif ($method === 'DELETE' && $id) {
    $stmt = $conn->prepare("DELETE FROM census WHERE person_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Record deleted successfully']);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }
}

$conn->close();
?>
