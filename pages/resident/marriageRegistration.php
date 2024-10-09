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
            <form id='marriageCertificateForm' class='grid grid-cols-3 gap-2'>
                
                <!-- Hidden Input for userId -->
                <input type='hidden' name='user_id' id='user_id' />

                <!-- Personal Information of the Couple -->
                <div class='col-span-3 mb-3'>
                    <h1 class='font-bold'>Personal Information of the Couple</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Groom's First Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groom_first_name'  />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Groom's Middle Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groom_middle_name' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Groom's Last Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groom_last_name' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Groom's Suffix (if applicable)</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groom_suffix' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Bride's First Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='bride_first_name' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Bride's Middle Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='bride_middle_name' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Bride's Last Name</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='bride_last_name' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Bride's Maiden Name (if applicable)</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='bride_maiden_name' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Bride's Suffix (if applicable)</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='bride_suffix' />
                </div>

                <!-- Birth Details -->
                <div class='col-span-3 mb-3 mt-5'>
                    <h1 class='font-bold'>Birth Details</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Date of Birth of Groom:</label>
                    <input type='date' class='outline-none border border-gray-700 p-1 rounded-md' name='groom_dob' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Date of Birth of Bride:</label>
                    <input type='date' class='outline-none border border-gray-700 p-1 rounded-md' name='bride_dob' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Place of Birth of Groom:</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groom_birth_place' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Place of Birth of Bride:</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='bride_birth_place' />
                </div>

                 <!-- Birth Details -->
                <div class='col-span-3 mb-3 mt-5'>
                    <h1 class='font-bold'>Place of Marriage & Date</h1>
                </div>

                 <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Marriage Date</label>
                    <input type='date' class='outline-none border border-gray-700 p-1 rounded-md' name='marriage_date' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Marriage place</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='marriage_place' />
                </div>

                <!-- Civil Status Before Marriage -->
                <div class='col-span-3 mb-3 mt-5'>
                    <h1 class='font-bold'>Civil Status Before Marriage</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Groom’s Civil Status:</label>
                    <select name='groom_civil_status' class='outline-none border border-gray-700 p-1 rounded-md'>
                        <option value='Single'>Single</option>
                        <option value='Widowed'>Widowed</option>
                        <option value='Divorced'>Divorced</option>
                        <option value='Annulled'>Annulled</option>
                    </select>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Bride’s Civil Status:</label>
                    <select name='bride_civil_status' class='outline-none border border-gray-700 p-1 rounded-md'>
                        <option value='Single'>Single</option>
                        <option value='Widowed'>Widowed</option>
                        <option value='Divorced'>Divorced</option>
                        <option value='Annulled'>Annulled</option>
                    </select>
                </div>


                <!-- Nationality -->
                <div class='col-span-3 mb-3 mt-5'>
                    <h1 class='font-bold'>Nationality</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Nationality of Groom</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groom_nationality' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Nationality of Bride</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='bride_nationality' />
                </div>


                <!-- Parents' Information -->
                <div class='col-span-3 mb-3 mt-5'>
                    <h1 class='font-bold'>Parents' Information</h1>
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Full Name of Groom's Father:</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groom_father_name' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Full Name of Groom's Mother:</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groom_mother_name' />
                </div>

                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Full Name of Bride's Father:</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='bride_father_name' />
                </div>
                 <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Full Name of Bride's Mother:</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='bride_mother_name' />
                </div>

                
                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Groom Witness</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='groom_witness' />
                </div>
                <div class='col-span-1 flex flex-col'>
                    <label class='text-[12.5px]'>Bride Witness</label>
                    <input type='text' class='outline-none border border-gray-700 p-1 rounded-md' name='bride_witness' />
                </div>
                
                <!-- Employee Information -->
                <div class='col-span-3 mb-3'>
                    <h1 class='font-bold'>Employee Information</h1>
                </div>
                 <div class='flex flex-col'>
                    <label for='employee' class='text-[12.5px]'>Select Employee</label>
                    <select name='employee_id' id='employee' class='outline-none border border-gray-700 p-1 rounded-md'>
                        <option value=''>Select an Employee</option>
                        <!-- Dynamic employee options will be inserted here -->
                    </select>
                </div>

                 <!-- Submit Button -->
                <div class='col-span-3 flex justify-center mt-5'>
                    <button type='submit' class='bg-blue-500 text-white py-2 px-4 rounded-md'>Submit Registration</button>
                </div>

            </form>
        </div>
    </div>
";

// Print the content
residentLayout($marriageContent);
?>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>

    function showToast(message, type) {
        Toastify({
            text: message,
            style: {
                background: type === 'success' ? 'linear-gradient(to right, #00b09b, #96c93d)' : 'linear-gradient(to right, #ff5f6d, #ffc371)'
            },
            duration: 3000
        }).showToast();
    }

    // Validation function
    function validateForm(data) {
        // Example validation rules
        if (!data.groom_first_name || !data.groom_middle_name) {
            showToast('groom first and last names are required.', 'error');
            return false;
        }

        // Additional validations can be added here
        return true;
    }

    document.getElementById('marriageCertificateForm').addEventListener('submit', async function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        const submitButton = this.querySelector('button[type="submit"]');

        // Retrieve user ID from local storage
        const userId = localStorage.getItem('userId');
        if (userId) {
            data.userId = userId; // Set userId in the data object
        } else {
            showToast('User ID is not found in local storage.', 'error');
            return; // Stop the form submission if userId is not found
        }

        // Disable the submit button to prevent multiple submissions
        submitButton.disabled = true;

        // Validate the form data before sending
        if (!validateForm(data)) {
            submitButton.disabled = false; // Re-enable the button if validation fails
            return; // Stop the form submission
        }

        // Send the data to the server
        try {
            const response = await fetch('http://localhost/civil-registrar/api/marriage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });
            

            const result = await response.json();
            if (response.ok) {
                showToast(result.message, 'success'); // Show success toast
                this.reset(); // Clear the form
            } else {
                showToast(result.error, 'error'); // Show error toast
            }
        } catch (error) {
            showToast('An error occurred: ' + error.message, 'error'); // Show error toast
        } finally {
            submitButton.disabled = false; // Re-enable the button in all cases
        }
    });


    const selectElement = document.getElementById('employee');

// Fetch the list of employees from the backend
fetch('http://localhost/civil-registrar/api/employees.php') // Adjust the URL based on your API structure
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(employees => {
        employees.forEach(employee => {
            const option = document.createElement('option');
            option.value = employee.id; // Set the value to the employee ID
            option.textContent = employee.name; // Set the display text to the employee's name
            selectElement.appendChild(option);
        });
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
    });

</script>