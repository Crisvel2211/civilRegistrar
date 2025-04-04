<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

// Define the content for the death registration form
$deathContent = "
    <div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
        <div class='flex items-center space-x-2 p-4'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M12 8v4m0 4h.01M6 9h12M6 15h12M6 12h12'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>DEATH RECORDS</h1>
        </div>
        <div class='m-4 bg-white p-4 rounded-[8px] w-[88%] mx-auto'>
            <form class='grid grid-cols-1 md:grid-cols-3 gap-2 w-full' id='deathCertificateForm'>
           
              <!-- Hidden Input for userId -->
                <input type='hidden' name='user_id' id='user_id' />

                <!-- 1.1 Deceased Information -->
                <div class='col-span-3 mb-3'>
                    <h1 class='font-bold'>Deceased Information</h1>
                </div>


                <div class='col-span-3 md:col-span-1 w-full'>
                  <label class='text-[12.5px]'>Deceased's First Name</label>
                    <div class='col-span-3 md:col-span-1'>
                        <input type='text' class='outline-none border border-gray-700 p-1 rounded-md w-full ' name='deceased_first_name' />
                    </div>
                
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                  <label class='text-[12.5px]'>Deceased's Middle Name</label>
                  <div class='col-span-3 md:col-span-1'>
                    <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='deceased_middle_name'/>
                  </div>
                </div>


                <div class='col-span-3 md:col-span-1 w-full'>
                   <label class='text-[12.5px]'>Deceased's Last Name</label>
                   <div class='col-span-3 md:col-span-1'>
                    <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='deceased_last_name' />
                   </div>
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Date of Birth</label>
                  <div class='col-span-3 md:col-span-1'>
                   
                    <input type='date' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='deceased_dob' />
                  </div>
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Date of Death</label>
                    <div class='col-span-3 md:col-span-1'>
                       
                        <input type='date' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='date_of_death' />
                    </div>
                
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Place of Death</label>
                    <div class='col-span-3 md:col-span-1'>
                       
                        <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='place_of_death' />
                    </div>
                </div>
                

                <div class='col-span-3 md:col-span-1 w-full'>
                <label class='text-[12.5px]'>Cause of Death</label>
                    <div class='col-span-3 md:col-span-1'>
                        
                        <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='cause_of_death' />
                    </div>
                </div>

                   
                <!-- 1.2 Informant Information -->
                <div class='col-span-3 mb-2 mt-4'>
                    <h1 class='font-bold'>Informant Information</h1>
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Informant's Name</label>
                    <div class='col-span-3 md:col-span-1'>
                       
                        <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='informant_name' />
                    </div>
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Relationship to Deceased</label>
                    <div class='col-span-3 md:col-span-1'>
                       
                        <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='relationship_to_deceased' />
                    </div>
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                <label class='text-[12.5px]'>Informant's Contact Number</label>
                    <div class='col-span-3 md:col-span-1'>
                        
                        <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='informant_contact' />
                    </div>
                </div>


                <!-- 1.3 Disposition Details -->
                <div class='col-span-3 mb-2 mt-4'>
                    <h1 class='font-bold'>Disposition Details</h1>
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                <label class='text-[12.5px]'>Method of Disposition</label>
                    <div class='col-span-3 md:col-span-1'>
                        
                        <select name='disposition_method' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' >
                            <option value='Burial'>Burial</option>
                            <option value='Cremation'>Cremation</option>
                        </select>
                    </div>
                
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                <label class='text-[12.5px]'>Date of Disposition</label>
                <div class='col-span-3 md:col-span-1'>
                    
                    <input type='date' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='disposition_date' />
                </div>
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                <label class='text-[12.5px]'>Location of Disposition</label>
                    <div class='col-span-3 md:col-span-1'>
                        
                        <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='disposition_location' />
                    </div>

                </div>

            

                

                
                <!-- Employee Information -->
                <div class='col-span-3 mb-2 mt-4'>
                    <h1 class='font-bold'>Employee Information</h1>
                </div>

                 <div class='col-span-3 md:col-span-1 w-full'>
                 <label for='employee' class='text-[12.5px]'>Select Employee</label>
                    <div class='col-span-3 md:col-span-1'>
                        <select name='employee_id' id='employee' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'>
                            <option value=''>Select an Employee</option>
                            <!-- Dynamic employee options will be inserted here -->
                        </select>
                    </div>
                </div>

                 <!-- Submit Button -->
                <div class='col-span-3 flex justify-center mt-2'>
                    <button type='submit' class='w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500'>Submit Registration</button>
                </div>

            </form>
        </div>
    </div>
";

// Render the layout with the death registration content
residentLayout($deathContent);
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
        if (!data.deceased_first_name || !data.deceased_last_name) {
            showToast('deceased first and last names are required', 'error');
            return false;
        }

        // Additional validations can be added here
        return true;
    }

    document.getElementById('deathCertificateForm').addEventListener('submit', async function(event) {
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
            const response = await fetch('https://civilregistrar.lgu2.com/api/death.php', {
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
                setTimeout(() => {
                  window.location.href = "https://civilregistrar.lgu2.com/pages/resident/deathDoc.php";
              }, 2000);
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
fetch('https://civilregistrar.lgu2.com/api/employees.php') // Adjust the URL based on your API structure
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