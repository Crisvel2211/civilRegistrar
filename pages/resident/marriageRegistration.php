<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

// Define the content for the marriage registration form
$marriageContent = " 
    <div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
        <div class='pt-2 mb-3'>
            <h1 class='text-center font-bold text-[23px]'>MARRIAGE REGISTRATION FORM</h1>
        </div>
        <div class='m-4 bg-white p-4 rounded-[8px]'>
            <form class='grid grid-cols-3 gap-2' action='next_step_marriage_verification.php' method='POST'>
                
                <!-- 1.1 Personal Information of the Couple -->
                <div class='col-span-3 mb-3'>
                    <h1 class='font-bold'>Personal Information of the Couple</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Groom's First Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groomFirstName' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Groom's Middle Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groomMiddleName'/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Groom's Last Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groomLastName' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Groom's Suffix (if applicable)</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groomSuffix'/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Bride's First Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='brideFirstName' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Bride's Middle Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='brideMiddleName'/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Bride's Last Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='brideLastName' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Bride's Maiden Name (if applicable)</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='brideMaidenName'/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Bride's Suffix (if applicable)</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='brideSuffix'/>
                </div>

                <!-- 1.2 Birth Details -->
                <div class='col-span-3 mb-3 mt-5'>
                    <h1 class='font-bold'>Birth Details</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Date of Birth of Groom:</label>
                    <input type='date' class='outline-none border border-gray-700 p-1 rounded-md' name='groomDOB' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Date of Birth of Bride:</label>
                    <input type='date' class='outline-none border border-gray-700 p-1 rounded-md' name='brideDOB' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Place of Birth of Groom:</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groomBirthPlace' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Place of Birth of Bride:</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='brideBirthPlace' required/>
                </div>

                <!-- 1.3 Civil Status Before Marriage -->
                <div class='col-span-3 mb-3 mt-5'>
                    <h1 class='font-bold'>Civil Status Before Marriage</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Groom’s Civil Status:</label>
                    <select name='groomCivilStatus' class='outline-none border border-gray-700 p-1 rounded-md' required>
                        <option value='Single'>Single</option>
                        <option value='Widowed'>Widowed</option>
                        <option value='Divorced'>Divorced</option>
                        <option value='Annulled'>Annulled</option>
                    </select>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Bride’s Civil Status:</label>
                    <select name='brideCivilStatus' class='outline-none border border-gray-700 p-1 rounded-md' required>
                        <option value='Single'>Single</option>
                        <option value='Widowed'>Widowed</option>
                        <option value='Divorced'>Divorced</option>
                        <option value='Annulled'>Annulled</option>
                    </select>
                </div>

                <!-- 1.4 Nationality -->
                <div class='col-span-3 mb-3 mt-5'>
                    <h1 class='font-bold'>Nationality</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Nationality of Groom</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groomNationality' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Nationality of Bride</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='brideNationality' required/>
                </div>

                <!-- 1.5 Parents' Information -->
                <div class='col-span-3 mb-3 mt-5'>
                    <h1 class='font-bold'>Parents' Information</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Full Name of Groom's Father:</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groomFatherName' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Full Name of Groom's Mother:</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groomMotherName' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Full Name of Bride's Father:</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='brideFatherName' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Full Name of Bride's Mother:</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='brideMotherName' required/>
                </div>

                <!-- 1.6 Marriage Details -->
                <div class='col-span-3 mb-3 mt-5'>
                    <h1 class='font-bold'>Marriage Details</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Date of Marriage:</label>
                    <input type='date' class='outline-none border border-gray-700 p-1 rounded-md' name='marriageDate' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Place of Marriage:</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='marriagePlace' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Witness Name (Groom):</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groomWitness' required/>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Witness Name (Bride):</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='brideWitness' required/>
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
residentLayout($marriageContent);
?>

