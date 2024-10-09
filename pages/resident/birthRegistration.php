<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';


// Define the content for the home page
$homeContent = "
    <div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
        <div class='pt-2 mb-3'>
            <h1 class='text-center font-bold text-[23px]'>BIRTH CERTIFICATE REGISTRATION FORM</h1>
        </div>
        <div class='m-4 bg-white p-4 rounded-[8px]'>
            <form class='grid grid-cols-3 gap-2' id='birthCertificateForm'>
              <input type='hidden' name='user_id' id='user_id' />
                <!-- Child's Information -->
                <div class='col-span-3 mb-3'>
                    <h1 class='font-bold'>Child’s Information</h1>
                </div>
                
                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Firstname</label>
                    <input type='text' name='child_first_name' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Lastname</label>
                    <input type='text' name='child_last_name' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Middlename</label>
                    <input type='text' name='child_middle_name' class='outline-none border border-gray-700 p-1 rounded-md' />
                </div>

                <div class='flex flex-col'>
                    <label for='sex' class='text-[12.5px]'>Sex</label>
                    <select name='child_sex' id='sex' class='outline-none border border-gray-700 p-1 rounded-md' >
                        <option value='male'>Male</option>
                        <option value='female'>Female</option>
                    </select>
                </div>

                <div class='flex flex-col'>
                    <label for='dob' class='text-[12.5px]'>Date of Birth</label>
                    <input type='date' name='child_date_of_birth' id='dob' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label for='time_of_birth' class='text-[12.5px]'>Time of Birth</label>
                    <input type='time' name='child_time_of_birth' id='time_of_birth' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label for='place_of_birth' class='text-[12.5px]'>Place of Birth</label>
                    <input type='text' name='child_place_of_birth' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label for='birth_type' class='text-[12.5px]'>Birth Type</label>
                    <select name='child_birth_type' id='birth_type' class='outline-none border border-gray-700 p-1 rounded-md' >
                        <option value='single'>Single</option>
                        <option value='twin'>Twin</option>
                        <option value='triplet'>Triplet</option>
                        <option value='other'>Other</option>
                    </select>
                </div>

                <div class='flex flex-col'>
                    <label for='birth_order' class='text-[12.5px]'>Birth Order</label>
                    <input type='number' name='child_birth_order' class='outline-none border border-gray-700 p-1 rounded-md' min='1'  />
                </div>

                <div class='col-span-3 mb-3'>
                    <h1 class='font-bold'>Father’s Information</h1>
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Firstname</label>
                    <input type='text' name='father_first_name' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Lastname</label>
                    <input type='text' name='father_last_name' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Middlename</label>
                    <input type='text' name='father_middle_name' class='outline-none border border-gray-700 p-1 rounded-md' />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Suffix</label>
                    <input type='text' name='father_suffix' class='outline-none border border-gray-700 p-1 rounded-md' />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Nationality</label>
                    <input type='text' name='father_nationality' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Date of Birth</label>
                    <input type='date' name='father_date_of_birth' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Place of Birth</label>
                    <input type='text' name='father_place_of_birth' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='col-span-3 mb-3'>
                    <h1 class='font-bold'>Mother’s Information</h1>
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Firstname</label>
                    <input type='text' name='mother_first_name' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Lastname</label>
                    <input type='text' name='mother_last_name' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Middlename</label>
                    <input type='text' name='mother_middle_name' class='outline-none border border-gray-700 p-1 rounded-md' />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Maiden Name</label>
                    <input type='text' name='mother_maiden_name' class='outline-none border border-gray-700 p-1 rounded-md' />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Nationality</label>
                    <input type='text' name='mother_nationality' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Date of Birth</label>
                    <input type='date' name='mother_date_of_birth' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label class='text-[12.5px]'>Place of Birth</label>
                    <input type='text' name='mother_place_of_birth' class='outline-none border border-gray-700 p-1 rounded-md'  />
                </div>

                <div class='flex flex-col'>
                    <label for='parents_married_at_birth' class='text-[12.5px]'>Were Parents Married at Birth?</label>
                    <select name='parents_married_at_birth' id='parents_married_at_birth' class='outline-none border border-gray-700 p-1 rounded-md' >
                        <option value='yes'>Yes</option>
                        <option value='no'>No</option>
                    </select>
                </div>

                <div class='col-span-3 mb-3'>
                    <h1 class='font-bold'>Empolyee Information</h1>
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

// Output the complete layout
residentLayout($homeContent);
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
        if (!data.child_first_name || !data.child_last_name) {
            showToast('Child’s first and last names are required.', 'error');
            return false;
        }

        if (data.child_birth_order <= 0) {
            showToast('Birth order must be a positive number.', 'error');
            return false;
        }

        // Additional validations can be added here
        return true;
    }

    document.getElementById('birthCertificateForm').addEventListener('submit', async function(event) {
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
            const response = await fetch('http://localhost/civil-registrar/api/birth.php', {
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