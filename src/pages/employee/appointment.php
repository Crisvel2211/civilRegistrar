<?php
// Include the layout file
include '../../layout/employee/employeeLayout.php';

// Assuming an array of resident names is available, this could come from a database query
$residents = [
    'John Doe',
    'Jane Smith',
    'Robert Johnson',
    'Emily Davis'
    // Add more resident names as needed
];

$updateProfileContent = "   
       <div class='min-h-screen flex items-center justify-center'>
        <div class='bg-white p-8 rounded-lg shadow-lg w-full max-w-md'>
            <h2 class='text-2xl font-bold text-center mb-6 text-gray-800'>Book an Appointment</h2>
            
            <form>
                <!-- Resident Selection (Dropdown) -->
                <div class='mb-4'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='resident'>
                        Select Resident
                    </label>
                    <select id='resident' name='resident' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' required>
                        <option value='' disabled selected>Select a resident</option>";
                        // Dynamically populate the select options with resident names
                        foreach ($residents as $resident) {
                            $updateProfileContent .= "<option value='$resident'>$resident</option>";
                        }
$updateProfileContent .= "
                    </select>
                </div>

                <!-- Date -->
                <div class='mb-4'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='appointment-date'>
                        Select Date
                    </label>
                    <input id='appointment-date' type='date' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' required>
                </div>

                <!-- Time -->
                <div class='mb-4'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='appointment-time'>
                        Select Time
                    </label>
                    <input id='appointment-time' type='time' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' required>
                </div>

                <!-- Purpose of Appointment -->
                <div class='mb-6'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='purpose'>
                        Purpose of Appointment
                    </label>
                    <textarea id='purpose' placeholder='Consultation, Check-up, etc.' class='w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300' rows='3' required></textarea>
                </div>

                <!-- Submit Button -->
                <div class='flex justify-center'>
                    <button type='submit' class='bg-blue-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300'>
                        Confirm Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
";

employeeLayout($updateProfileContent);
?>
