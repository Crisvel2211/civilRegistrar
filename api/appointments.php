<?php
header('Content-Type: application/json');
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

// Define the base URL for the uploaded images
$base_url = 'https://civilregistrar.lgu2.com//api/uploads/'; 

// Handle GET requests to fetch all appointments, by ID, or by userId
if ($method == 'GET') {
    if (isset($_GET['id'])) {
        // Get appointment by ID
        $id = intval($_GET['id']);
        $sql = "SELECT * FROM appointments WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $appointment = $result->fetch_assoc();

        if ($appointment) {
            // Decode the JSON requirements field
            $appointment['requirements'] = json_decode($appointment['requirements']);
            // Prepend base URL to each image path in requirements
            $appointment['requirements'] = array_map(function($requirement) use ($base_url) {
                return $base_url . basename($requirement);
            }, $appointment['requirements']);
            
            echo json_encode($appointment);
        } else {
            echo json_encode(["message" => "Appointment not found."]);
        }
    } elseif (isset($_GET['userId'])) {
        // Get appointments by resident_id (userId)
        $userId = intval($_GET['userId']);
        $sql = "SELECT * FROM appointments WHERE resident_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $appointments = [];

        while ($row = $result->fetch_assoc()) {
            // Decode the JSON requirements field for each appointment
            $row['requirements'] = json_decode($row['requirements']);
            // Prepend base URL to each image path in requirements
            $row['requirements'] = array_map(function($requirement) use ($base_url) {
                return $base_url . basename($requirement);
            }, $row['requirements']);

            $appointments[] = $row;
        }

        echo json_encode($appointments);
    } else {
        // Get all appointments
        $sql = "SELECT * FROM appointments";
        $result = $conn->query($sql);
        $appointments = [];

        while ($row = $result->fetch_assoc()) {
            // Decode the JSON requirements field for each appointment
            $row['requirements'] = json_decode($row['requirements']);
            // Prepend base URL to each image path in requirements
            $row['requirements'] = array_map(function($requirement) use ($base_url) {
                return $base_url . basename($requirement);
            }, $row['requirements']);

            $appointments[] = $row;
        }

        echo json_encode($appointments);
    }
}

// Handle POST requests to create a new appointment
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $resident_id = $_POST['resident_id'];
    $appointment_type = $_POST['appointment_type'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $purpose = $_POST['purpose'];

    // Handle file uploads
    $requirements = $_FILES['requirements'];
    $file_paths = [];
    $upload_dir = 'uploads/'; // Directory where files will be uploaded

    // Check and create upload directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    foreach ($requirements['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($requirements['name'][$key]);
        $target_file = $upload_dir . uniqid() . '_' . $file_name;

        // Check for file upload errors
        if ($requirements['error'][$key] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($tmp_name, $target_file)) {
                $file_paths[] = $target_file; // Store the file path
            } else {
                echo json_encode(["error" => "Failed to upload file: $file_name"]);
                exit;
            }
        } else {
            echo json_encode(["error" => "Error uploading file: $file_name"]);
            exit;
        }
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO appointments (resident_id, appointment_type, appointment_date, appointment_time, purpose, requirements) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $requirements_json = json_encode($file_paths); // Store file paths as JSON

    // Change the binding types according to the data types
    $stmt->bind_param("isssss", $resident_id, $appointment_type, $appointment_date, $appointment_time, $purpose, $requirements_json);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Appointment booked successfully."]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }

    $stmt->close();
}

// Handle PUT requests to update an existing appointment
if ($method == 'PUT') {
    parse_str(file_get_contents("php://input"), $put_vars);

    // Get data from the PUT request
    $id = intval($put_vars['id']);
    $resident_id = $put_vars['resident_id'];
    $appointment_type = $put_vars['appointment_type'];
    $appointment_date = $put_vars['appointment_date'];
    $appointment_time = $put_vars['appointment_time'];
    $purpose = $put_vars['purpose'];

    // Prepare and execute the SQL statement
    $sql = "UPDATE appointments SET resident_id = ?, appointment_type = ?, appointment_date = ?, appointment_time = ?, purpose = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssi", $resident_id, $appointment_type, $appointment_date, $appointment_time, $purpose, $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Appointment updated successfully."]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }

    $stmt->close();
}

// Handle DELETE requests to delete an appointment
if ($method == 'DELETE') {
    parse_str(file_get_contents("php://input"), $delete_vars);

    // Get the appointment ID from the DELETE request
    $id = intval($delete_vars['id']);
    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Appointment deleted successfully."]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }

    $stmt->close();
}

?>
