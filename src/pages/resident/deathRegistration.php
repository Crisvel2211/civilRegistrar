<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

// Define the content for the death registration form
$deathContent = "
    <div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
        <div class='pt-2 mb-3'>
            <h1 class='text-center font-bold text-[23px]'>DEATH REGISTRATION FORM</h1>
        </div>
        <div class='m-4 bg-white p-4 rounded-[8px]'>
            <form class='grid grid-cols-3 gap-2' action='next_step_death_verification.php' method='POST'>

                <!-- 1.1 Deceased Information -->
                <div class='col-span-3 mb-3'>
                    <h1 class='font-bold'>Deceased Information</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Deceased's First Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='deceasedFirstName' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Deceased's Middle Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='deceasedMiddleName'/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Deceased's Last Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='deceasedLastName' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Date of Birth</label>
                    <input type='date' class='outline-none border border-gray-700 p-1 rounded-md' name='deceasedDOB' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Date of Death</label>
                    <input type='date' class='outline-none border border-gray-700 p-1 rounded-md' name='dateOfDeath' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Place of Death</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='placeOfDeath' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Cause of Death</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='causeOfDeath' required/>
                </div>

                <!-- 1.2 Informant Information -->
                <div class='col-span-3 mb-3 mt-5'>
                    <h1 class='font-bold'>Informant Information</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Informant's Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='informantName' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Relationship to Deceased</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='relationship' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Informant's Contact Number</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='informantContact' required/>
                </div>

                <!-- 1.3 Disposition Details -->
                <div class='col-span-3 mb-3 mt-5'>
                    <h1 class='font-bold'>Disposition Details</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Method of Disposition</label>
                    <select name='dispositionMethod' class='outline-none border border-gray-700 p-1 rounded-md' required>
                        <option value='Burial'>Burial</option>
                        <option value='Cremation'>Cremation</option>
                    </select>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Date of Disposition</label>
                    <input type='date' class='outline-none border border-gray-700 p-1 rounded-md' name='dispositionDate' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Location of Disposition</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='dispositionLocation' required/>
                </div>

                <!-- Submit Button -->
                <div class='col-span-3 flex justify-center mt-5'>
                    <button type='submit' class='bg-blue-500 text-white py-2 px-4 rounded-md'>Submit Registration</button>
                </div>

            </form>
        </div>
    </div>
";

// Render the layout with the death registration content
residentLayout($deathContent);
?>
