<?php
header('Content-Type: application/json');
include 'db.php'; // Ensure this file establishes a connection to the database

// Check if the connection was established successfully
if (!$conn) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Get the resident_id and issued_type from the POST request
$residentId = $_POST['resident_id'] ?? null;
$issuedType = $_POST['issued_type'] ?? null;

if (!$residentId || !$issuedType) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$certificateContent = '';

// Handle issued types
if ($issuedType === 'birth') {
    // Fetch the birth registration details for the resident
    $query = "SELECT * FROM birth_registration WHERE userId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $residentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['error' => 'No birth record found for the selected resident']);
        exit;
    }

    $birthRecord = $result->fetch_assoc();
    $certificateContent = "
         <h1>Birth Certificate</h1>
        <p><strong>Child's Full Name:</strong> {$birthRecord['child_first_name']} {$birthRecord['child_middle_name']} {$birthRecord['child_last_name']}</p>
        <p><strong>Sex:</strong> {$birthRecord['child_sex']}</p>
        <p><strong>Date of Birth:</strong> {$birthRecord['child_date_of_birth']}</p>
        <p><strong>Time of Birth:</strong> {$birthRecord['child_time_of_birth']}</p>
        <p><strong>Place of Birth:</strong> {$birthRecord['child_place_of_birth']}</p>
        <p><strong>Birth Type:</strong> {$birthRecord['child_birth_type']}</p>
        <p><strong>Birth Order:</strong> {$birthRecord['child_birth_order']}</p>
        <p><strong>Father's Name:</strong> {$birthRecord['father_first_name']} {$birthRecord['father_middle_name']} {$birthRecord['father_last_name']} {$birthRecord['father_suffix']}</p>
        <p><strong>Father's Nationality:</strong> {$birthRecord['father_nationality']}</p>
        <p><strong>Father's Date of Birth:</strong> {$birthRecord['father_date_of_birth']}</p>
        <p><strong>Father's Place of Birth:</strong> {$birthRecord['father_place_of_birth']}</p>
        <p><strong>Mother's Name:</strong> {$birthRecord['mother_first_name']} {$birthRecord['mother_middle_name']} {$birthRecord['mother_last_name']} (nee {$birthRecord['mother_maiden_name']})</p>
        <p><strong>Mother's Nationality:</strong> {$birthRecord['mother_nationality']}</p>
        <p><strong>Mother's Date of Birth:</strong> {$birthRecord['mother_date_of_birth']}</p>
        <p><strong>Mother's Place of Birth:</strong> {$birthRecord['mother_place_of_birth']}</p>
        <p><strong>Parents Married at Birth:</strong> {$birthRecord['parents_married_at_birth']}</p>
    ";

} elseif ($issuedType === 'death') {
    // Fetch the death registration details for the resident
    $query = "SELECT * FROM death_registration WHERE userId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $residentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['error' => 'No death record found for the selected resident']);
        exit;
    }

    $record = $result->fetch_assoc();
    $certificateContent = "
        <h1>Death Certificate</h1>
        <p><strong>Deceased's Full Name:</strong> {$record['deceased_first_name']} {$record['deceased_middle_name']} {$record['deceased_last_name']}</p>
        <p><strong>Date of Death:</strong> {$record['date_of_death']}</p>
        <p><strong>Cause of Death:</strong> {$record['cause_of_death']}</p>
        <!-- Add other details here -->
    ";

} elseif ($issuedType === 'marriage') {
    // Fetch the marriage registration details for the resident
    $query = "SELECT * FROM marriage_registration WHERE userId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $residentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['error' => 'No marriage record found for the selected resident']);
        exit;
    }

    $record = $result->fetch_assoc();
    $certificateContent = "
        <h1>Marriage Certificate</h1>
        <p><strong>Groom's Full Name:</strong> {$record['groom_first_name']} {$record['groom_middle_name']} {$record['groom_last_name']}</p>
        <p><strong>Bride's Full Name:</strong> {$record['bride_first_name']} {$record['bride_middle_name']} {$record['bride_last_name']}</p>
        <!-- Add other details here -->
    ";
}

echo json_encode(['certificateContent' => $certificateContent]);

$stmt->close();
$conn->close(); // Close the database connection
?>
