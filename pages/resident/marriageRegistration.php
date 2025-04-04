<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

// Define the content for the marriage registration form
$marriageContent = " 
    <div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
         <div class='flex items-center space-x-2 p-4'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M3 12h18M12 5l-3 3m3-3l3 3m0 9H6M9 17h6'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>MARRIAGE RECORDS</h1>
        </div>

        <div class='m-4 bg-white p-4 rounded-[8px] mx-auto w-[88%]'>
            <form id='marriageCertificateForm' class='grid grid-cols-1 md:grid-cols-3 gap-2 w-full'>
                
                <!-- Hidden Input for userId -->
                <input type='hidden' name='user_id' id='user_id' />

                <!-- Personal Information of the Couple -->
                <div class='col-span-3 mb-3'>
                    <h1 class='font-bold'>Personal Information of the Couple</h1>
                </div>

                 

                <div class='col-span-3 md:col-span-1 w-full'>
                  <label class='text-[12.5px]'>Groom's First Name</label>
                  <div class='col-span-3 md:col-span-1'>
                    <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='groom_first_name'  />
                  </div>
                </div>

              <div class='col-span-3 md:col-span-1 w-full'>
                <label class='text-[12.5px]'>Groom's Middle Name</label>
                <div class='col-span-3 md:col-span-1'>  
                    <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='groom_middle_name'/>
                </div>
              
              </div>

              <div class='col-span-3 md:col-span-1 w-full'>
                <label class='text-[12.5px]'>Groom's Last Name</label>
                <div class='col-span-3 md:col-span-1'>
                 <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='groom_last_name' />
                </div>
              
              </div>

              

               <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Groom's Suffix (if applicable)</label>
                  <div class='col-span-3 md:col-span-1'>
                    <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='groom_suffix' />
                  </div>
               
               </div>

               <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Bride's First Name</label>
                 <div class='col-span-3 md:col-span-1'>
                    <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='bride_first_name' />
                 </div>

               </div>

               <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Bride's Middle Name</label>
                 <div class='col-span-3 md:col-span-1'>
                    <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='bride_middle_name' />
                </div>
               </div>
    

             <div class='col-span-3 md:col-span-1 w-full'>
               <label class='text-[12.5px]'>Bride's Last Name</label>
               <div class='col-span-3 md:col-span-1'>
                    <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='bride_last_name' />
                </div>

             </div>

             <div class='col-span-3 md:col-span-1 w-full'>
               <label class='text-[12.5px]'>Bride's Maiden Name (if applicable)</label>
               <div class='col-span-3 md:col-span-1'>
                <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='bride_maiden_name' />
                </div>
             
             </div>


            <div class='col-span-3 md:col-span-1 w-full'>
              <label class='text-[12.5px]'>Bride's Suffix (if applicable)</label>
              <div class='col-span-3 md:col-span-1'>
                <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='bride_suffix' />
              </div>
            </div>
            
            <!-- Birth Details -->
            <div class='col-span-3 mb-2 mt-4'>
                <h1 class='font-bold'>Birth Details</h1>
            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
                <label class='text-[12.5px]'>Date of Birth of Groom:</label>
                <div class='col-span-3 md:col-span-1'>
                    <input type='date' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='groom_dob' />
                </div>
            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
             <label class='text-[12.5px]'>Date of Birth of Bride:</label>
              <div class='col-span-3 md:col-span-1'>
                    <input type='date' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='bride_dob' />
                </div>
            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
             <label class='text-[12.5px]'>Place of Birth of Groom:</label>
               <div class='col-span-3 md:col-span-1'>
                <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='groom_birth_place' />
                </div>
            </div>


            <div class='col-span-3 md:col-span-1 w-full'>
             <label class='text-[12.5px]'>Place of Birth of Bride:</label>
             <div class='col-span-3 md:col-span-1'>
                <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='bride_birth_place' />
                </div>
            </div>
                       

            <!-- Birth Details -->
            <div class='col-span-3 mb-2 mt-4'>
                <h1 class='font-bold'>Place of Marriage & Date</h1>
            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
             <label class='text-[12.5px]'>Marriage Date</label>
             <div class='col-span-3 md:col-span-1'>             
                <input type='date' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='marriage_date' />
             </div>
            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
              <label class='text-[12.5px]'>Marriage place</label>
              <div class='col-span-3 md:col-span-1'>
                <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='marriage_place' />
            </div>
            </div>


            <!-- Civil Status Before Marriage -->
            <div class='col-span-3 mb-2 mt-4'>
              <h1 class='font-bold'>Civil Status Before Marriage</h1>
            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
              <label class='text-[12.5px]'>Groom’s Civil Status:</label>
               <div class='col-span-3 md:col-span-1'>
                    <select name='groom_civil_status' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'>
                        <option value='Single'>Single</option>
                        <option value='Widowed'>Widowed</option>
                        <option value='Divorced'>Divorced</option>
                        <option value='Annulled'>Annulled</option>
                    </select>
                </div>
            
            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
               <label class='text-[12.5px]'>Bride’s Civil Status:</label>
               <div class='col-span-3 md:col-span-1'>
                    <select name='bride_civil_status' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'>
                        <option value='Single'>Single</option>
                        <option value='Widowed'>Widowed</option>
                        <option value='Divorced'>Divorced</option>
                        <option value='Annulled'>Annulled</option>
                    </select>
                </div>
            </div>


            <!-- Nationality -->
            <div class='col-span-3 mb-2 mt-4'>
                <h1 class='font-bold'>Nationality</h1>
            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
              <label class='text-[12.5px]'>Nationality of Groom</label>
                <div class='col-span-3 md:col-span-1'>
                    <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='groom_nationality' />
                </div>
            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
              <label class='text-[12.5px]'>Nationality of Bride</label>
               <div class='col-span-3 md:col-span-1'>
                    <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='bride_nationality' />
                </div>
            </div>
            
            <!-- Parents' Information -->
            <div class='col-span-3 mb-2 mt-4'>
                <h1 class='font-bold'>Parents' Information</h1>
            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
              <label class='text-[12.5px]'>Full Name of Groom's Father:</label>
              <div class='col-span-3 md:col-span-1'>
                <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='groom_father_name' />
                </div>
            
            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
             <label class='text-[12.5px]'>Full Name of Groom's Mother:</label>
              <div class='col-span-3 md:col-span-1'>
                    <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='groom_mother_name' />
              </div>
            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
               <label class='text-[12.5px]'>Full Name of Bride's Father:</label>
                <div class='col-span-3 md:col-span-1'>
                    <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='bride_father_name' />
                </div>
            
            </div>

            <div class='col-span-3 md:col-span-1 w-full>
              <label class='text-[12.5px]'>Full Name of Bride's Mother:</label>
              <div class='col-span-3 md:col-span-1'>
                <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='bride_mother_name' />
                </div>

            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
              <label class='text-[12.5px]'>Groom Witness</label>
              <div class='col-span-3 md:col-span-1'>
                <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='groom_witness' />
              </div>
            
            </div>

            <div class='col-span-3 md:col-span-1 w-full'>
              <label class='text-[12.5px]'>Bride Witness</label>
              <div class='col-span-3 md:col-span-1'>
                <input type='text' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' name='bride_witness' />
              </div>
            </div>

              
        
            <!-- Employee Information -->
            <div class='col-span-3 mt-5'>
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
                    <button type='submit' class='bg-indigo-500 text-white py-2 px-4 rounded-md w-full'>Submit Registration</button>
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
            const response = await fetch('http://localhost/group69/api/marriage.php', {
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
                  window.location.href = "http://localhost/group69/pages/resident/marriageDoc.php";
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
fetch('http://localhost/group69/api/employees.php') // Adjust the URL based on your API structure
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