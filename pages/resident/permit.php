<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

$updateProfileContent = "
    <div class='container mx-auto w-full md:mt-1 px-[8px] h-[88vh] overflow-y-scroll'>
        <div class='container mx-auto p-6'>
            <div class='mb-8'>
                <h1 class='text-3xl font-bold text-center text-gray-500'>Permit Request</h1>
            </div>
            
            <!-- Permit Request Form -->
            <form action='submit_permit_request.php' method='POST' class='bg-gray-100 p-6 rounded-lg shadow-md'>
                <div class='mb-4'>
                    <label for='permit_type' class='block text-sm font-medium text-gray-700'>Permit Type</label>
                    <select id='permit_type' name='permit_type' class='mt-1 block w-full p-2 border border-gray-300 rounded'>
                        <option value='exhumation'>Exhumation</option>
                        <option value='burial'>Burial</option>
                        <option value='cremation'>Cremation</option>
                    </select>
                </div>
                
                <div class='mb-4'>
                    <label for='resident_name' class='block text-sm font-medium text-gray-700'>Resident Full Name</label>
                    <input type='text' id='resident_name' name='resident_name' class='mt-1 block w-full p-2 border border-gray-300 rounded' required>
                </div>

                <div class='mb-4'>
                    <label for='date_of_request' class='block text-sm font-medium text-gray-700'>Date of Request</label>
                    <input type='date' id='date_of_request' name='date_of_request' class='mt-1 block w-full p-2 border border-gray-300 rounded' required>
                </div>

                <div class='mb-4'>
                    <label for='additional_details' class='block text-sm font-medium text-gray-700'>Additional Details</label>
                    <textarea id='additional_details' name='additional_details' rows='4' class='mt-1 block w-full p-2 border border-gray-300 rounded'></textarea>
                </div>
                
                <div class='mb-4'>
                    <button type='submit' class='w-full p-2 bg-blue-500 text-white rounded'>Submit Request</button>
                </div>
            </form>
        </div>
    </div>
";

residentLayout($updateProfileContent);
?>
