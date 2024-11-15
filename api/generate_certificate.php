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
    <html>
    <head>
        <script src='https://cdn.tailwindcss.com'></script>
    </head>
    <body class='bg-gray-100'>
        <div class='w-full max-w-4xl mx-auto p-8 bg-gradient-to-b from-[#e8f7d6] to-[#fff7d6] border-2 border-gray-300 shadow-lg'>
            <div class='relative mb-8'>
                <div class='absolute top-0 left-0 w-24 h-24 rounded-full border-2 border-blue-500 flex items-center justify-center'>
                    <div class='w-20 h-20 rounded-full border-2 border-blue-400 flex items-center justify-center'>
                        <div class='text-xs text-center text-blue-600'>REPUBLIC SEAL</div>
                    </div>
                </div>
                <h1 class='text-center text-3xl font-bold pt-6'>BIRTH CERTIFICATE</h1>
            </div>

            <div class='space-y-4'>
                <div>
                    <h2 class='text-xl font-semibold border-b border-gray-300 pb-1 mb-2'>Child's Information</h2>
                    <p><strong class='font-medium'>Full Name:</strong> {$birthRecord['child_first_name']} {$birthRecord['child_middle_name']} {$birthRecord['child_last_name']}</p>
                    <p><strong class='font-medium'>Sex:</strong> {$birthRecord['child_sex']}</p>
                    <p><strong class='font-medium'>Date of Birth:</strong> {$birthRecord['child_date_of_birth']}</p>
                    <p><strong class='font-medium'>Time of Birth:</strong> {$birthRecord['child_time_of_birth']}</p>
                    <p><strong class='font-medium'>Place of Birth:</strong> {$birthRecord['child_place_of_birth']}</p>
                    <p><strong class='font-medium'>Birth Type:</strong> {$birthRecord['child_birth_type']}</p>
                    <p><strong class='font-medium'>Birth Order:</strong> {$birthRecord['child_birth_order']}</p>
                </div>

                <div>
                    <h2 class='text-xl font-semibold border-b border-gray-300 pb-1 mb-2'>Father's Information</h2>
                    <p><strong class='font-medium'>Name:</strong> {$birthRecord['father_first_name']} {$birthRecord['father_middle_name']} {$birthRecord['father_last_name']} {$birthRecord['father_suffix']}</p>
                    <p><strong class='font-medium'>Nationality:</strong> {$birthRecord['father_nationality']}</p>
                    <p><strong class='font-medium'>Date of Birth:</strong> {$birthRecord['father_date_of_birth']}</p>
                    <p><strong class='font-medium'>Place of Birth:</strong> {$birthRecord['father_place_of_birth']}</p>
                </div>

                <div>
                    <h2 class='text-xl font-semibold border-b border-gray-300 pb-1 mb-2'>Mother's Information</h2>
                    <p><strong class='font-medium'>Name:</strong> {$birthRecord['mother_first_name']} {$birthRecord['mother_middle_name']} {$birthRecord['mother_last_name']} (nee {$birthRecord['mother_maiden_name']})</p>
                    <p><strong class='font-medium'>Nationality:</strong> {$birthRecord['mother_nationality']}</p>
                    <p><strong class='font-medium'>Date of Birth:</strong> {$birthRecord['mother_date_of_birth']}</p>
                    <p><strong class='font-medium'>Place of Birth:</strong> {$birthRecord['mother_place_of_birth']}</p>
                </div>

                <div>
                    <p><strong class='font-medium'>Parents Married at Birth:</strong> {$birthRecord['parents_married_at_birth']}</p>
                </div>

                <div class='mt-8 pt-4 border-t border-gray-300'>
                    <div class='grid grid-cols-2 gap-8'>
                        <div class='text-center mt-6'>
                            <img src='https://fontmeme.com/permalink/241113/3689af6f9cc47262970a90e1de5e1497.png' alt='Civil Registrar Signature' class='h-10 pl-14' />
                            <div class='border-b border-black mx-8'></div>
                            <p class='text-sm mt-1'>Civil Registrar</p>
                        </div>
                        <div class='text-center mt-10'>
                            <p>" . date("M j, Y", strtotime($birthRecord['created_at'])) . "</p>
                            <div class='border-b border-black mx-8'></div>
                            <p class='text-sm mt-1'>Date Registered</p>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </body>
    </html>
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

    $deathRecord = $result->fetch_assoc();
    $certificateContent = "
        <html>
        <head>
            <script src='https://cdn.tailwindcss.com'></script>
        </head>
        <body class='bg-gray-100 '>
            <div class='w-full max-w-4xl mx-auto p-8 bg-gradient-to-b from-[#e8f7d6] to-[#fff7d6] border-2 border-gray-300 shadow-lg'>
                <div class='relative mb-8'>
                    <div class='absolute top-0 left-0 w-24 h-24 rounded-full border-2 border-blue-500 flex items-center justify-center'>
                        <div class='w-20 h-20 rounded-full border-2 border-blue-400 flex items-center justify-center'>
                            <div class='text-xs text-center text-blue-600'>REPUBLIC SEAL</div>
                        </div>
                    </div>
                    <h1 class='text-center text-3xl font-bold pt-6'>DEATH CERTIFICATE</h1>
                </div>

                <div class='space-y-4'>
                    <div>
                        <h2 class='text-xl font-semibold border-b border-gray-300 pb-1 mb-2'>Deceased Information</h2>
                        <p><strong class='font-medium'>Deceased Full Name:</strong> {$deathRecord['deceased_first_name']} {$deathRecord['deceased_middle_name']} {$deathRecord['deceased_last_name']}</p>
                        <p><strong class='font-medium'>Date of Birth:</strong> {$deathRecord['deceased_dob']}</p>
                        <p><strong class='font-medium'>Date of Death:</strong> {$deathRecord['date_of_death']}</p>
                        <p><strong class='font-medium'>Place of Death:</strong> {$deathRecord['place_of_death']}</p>
                        <p><strong class='font-medium'>Cause of Death:</strong> {$deathRecord['cause_of_death']}</p>
                    </div>

                    <div>
                        <h2 class='text-xl font-semibold border-b border-gray-300 pb-1 mb-2'>Informant Information</h2>
                        <p><strong class='font-medium'>Informant's Name:</strong> {$deathRecord['informant_name']}</p>
                        <p><strong class='font-medium'>Relationship to Deceased:</strong> {$deathRecord['relationship_to_deceased']}</p>
                        <p><strong class='font-medium'>Informant's Contact Number:</strong> {$deathRecord['informant_contact']}</p>
                    </div>

                    <div>
                        <h2 class='text-xl font-semibold border-b border-gray-300 pb-1 mb-2'>Disposition Details</h2>
                        <p><strong class='font-medium'>Method of Disposition:</strong> {$deathRecord['disposition_method']}</p>
                        <p><strong class='font-medium'>Date of Disposition:</strong> {$deathRecord['disposition_date']}</p>
                        <p><strong class='font-medium'>Location of Disposition:</strong> {$deathRecord['disposition_location']}</p>
                    </div>

                    <div class='mt-8 pt-4 border-t border-gray-300'>
                        <div class='grid grid-cols-2 gap-8'>
                            <div class='text-center mt-6'>
                                <img src='https://fontmeme.com/permalink/241113/3689af6f9cc47262970a90e1de5e1497.png' alt='Civil Registrar Signature' class='h-10 pl-14' />
                                <div class='border-b border-black mx-8'></div>
                                <p class='text-sm mt-1'>Civil Registrar</p>
                            </div>
                            <div class='text-center mt-10'>
                                <p>" . date("M j, Y", strtotime($deathRecord['created_at'])) . "</p>
                                <div class='border-b border-black mx-8'></div>
                                <p class='text-sm mt-1'>Date Registered</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
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

    $marriageRecord = $result->fetch_assoc();
    $certificateContent = "
    <html>
    <head>
        <script src='https://cdn.tailwindcss.com'></script>
    </head>
    <body class='bg-gray-100'>
        <div class='w-full max-w-4xl mx-auto p-8 bg-gradient-to-b from-[#e8f7d6] to-[#fff7d6] border-2 border-gray-300 shadow-lg'>
            <div class='relative mb-8'>
                <div class='absolute top-0 left-0 w-24 h-24 rounded-full border-2 border-blue-500 flex items-center justify-center'>
                    <div class='w-20 h-20 rounded-full border-2 border-blue-400 flex items-center justify-center'>
                        <div class='text-xs text-center text-blue-600'>REPUBLIC SEAL</div>
                    </div>
                </div>
                <h1 class='text-center text-3xl font-bold pt-6'>MARRIAGE CERTIFICATE</h1>
            </div>

            <div class='space-y-4'>
                <div>
                    <h2 class='text-xl font-semibold border-b border-gray-300 pb-1 mb-2'>Personal Information of the Couple</h2>
                    <p><strong class='font-medium'>Groom's Full Name:</strong> {$marriageRecord['groom_first_name']} {$marriageRecord['groom_middle_name']} {$marriageRecord['groom_last_name']}</p>
                    <p><strong class='font-medium'>Bride's Full Name:</strong> {$marriageRecord['bride_first_name']} {$marriageRecord['bride_middle_name']} {$marriageRecord['bride_last_name']}</p>
                    <p><strong class='font-medium'>Marriage Date:</strong> {$marriageRecord['marriage_date']}</p>
                    <p><strong class='font-medium'>Marriage Place:</strong> {$marriageRecord['marriage_place']}</p>
                </div>

                <div class='mt-8 pt-4 border-t border-gray-300'>
                    <div class='grid grid-cols-2 gap-8'>
                        <div class='text-center mt-6'>
                            <img src='https://fontmeme.com/permalink/241113/3689af6f9cc47262970a90e1de5e1497.png' alt='Civil Registrar Signature' class='h-10 pl-14' />
                            <div class='border-b border-black mx-8'></div>
                            <p class='text-sm mt-1'>Civil Registrar</p>
                        </div>
                        <div class='text-center mt-10'>
                            <p>" . date("M j, Y", strtotime($marriageRecord['created_at'])) . "</p>
                            <div class='border-b border-black mx-8'></div>
                            <p class='text-sm mt-1'>Date Registered</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    ";
}

echo json_encode(['certificateContent' => $certificateContent]);

$stmt->close();
$conn->close(); // Close the database connection
?>
