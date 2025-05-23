<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';


// Define the content for the home page
$homeContent = "
    <div class='bg-gray-300 w-full h-[88vh] overflow-y-scroll'>
         <div class='flex items-center space-x-2 p-4'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M12 4v7m0 0l3-3m-3 3l-3-3m3 3v10M5 12H3m2 0h12'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>BIRTH REGISTRATION</h1>
        </div>
        <div class='m-4 bg-white p-4 rounded-[8px] w-[88%] mx-auto'>
            <form class='grid grid-cols-1 md:grid-cols-3 gap-2 w-full' id='birthCertificateForm'>
              <input type='hidden' name='user_id' id='user_id' />
                <!-- Child's Information -->
                <div class='col-span-3 mb-3'>
                    <h1 class='font-bold'>Child’s Information</h1>
                </div>

                <div class='col-span-3 md:col-span-1 '>
                  <label class='text-[12.5px]'>Firstname</label>
                   <div class='col-span-3 md:col-span-1'>
                    <input type='text' name='child_first_name' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'  />
                  </div>
                </div>
                 
    
               <div class='col-span-3 md:col-span-1'>
                 <label class='text-[12.5px]'>Lastname</label>
                 <div class='col-span-3 md:col-span-1'>
                    <input type='text' name='child_last_name' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'  />
                </div>
               </div>
                
               <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Middlename</label>
                 <div class='col-span-3 md:col-span-1'>
                
                    <input type='text' name='child_middle_name' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' />
                </div>
               </div>
    
                <div class='col-span-3 md:col-span-1 w-full>
                  <label for='sex' class='text-[12.5px]'>Sex</label>
                  <div class='col-span-3 md:col-span-1'>
                    
                    <select name='child_sex' id='sex' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' >
                        <option value='male'>Male</option>
                        <option value='female'>Female</option>
                    </select>
                  </div>
                </div>
                
                
              <div class='col-span-3 md:col-span-1 w-full'>
                <label for='dob' class='text-[12.5px]'>Date of Birth</label>
                 <div class='col-span-3 md:col-span-1'>
                    
                    <input type='date' name='child_date_of_birth' id='dob' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' />
                </div>
              </div>
            
               <div class='col-span-3 md:col-span-1 w-full>
                <label for='time_of_birth' class='text-[12.5px]'>Time of Birth</label>
                <div class='col-span-3 md:col-span-1'>
                   
                    <input type='time' name='child_time_of_birth' id='time_of_birth' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'/>
                </div>
               
               </div>

               <div class='col-span-3 md:col-span-1 w-full>
                 <label for='place_of_birth' class='text-[12.5px]'>Place of Birth</label>
                 <div class='col-span-3 md:col-span-1'>
                    <input type='text' name='child_place_of_birth' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'/>
                 </div>
               </div>


                <div class='col-span-3 md:col-span-1 w-full'>
                    <label for='birth_type' class='text-[12.5px]'>Birth Type</label>
                    <div class='col-span-3 md:col-span-1'>
                        <select name='child_birth_type' id='birth_type' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' >
                            <option value='single'>Single</option>
                            <option value='twin'>Twin</option>
                            <option value='triplet'>Triplet</option>
                            <option value='other'>Other</option>
                        </select>
                    </div>
                    
                </div>
        

                <div class='col-span-3 md:col-span-1 w-full'>
                  <label for='birth_order' class='text-[12.5px]'>Birth Order</label>
                  <div class='col-span-3 md:col-span-1'>
                    <input type='number' name='child_birth_order' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' min='1'/>
                  </div>
                </div>

                

                <div class='col-span-3 mb-2 mt-4'>
                    <h1 class='font-bold'>Father’s Information</h1>
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                  <label class='text-[12.5px]'>Firstname</label>
                  <div class='col-span-3 md:col-span-1'>
                    <input type='text' name='father_first_name' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'/>
                  </div>
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Lastname</label>
                 <div class='col-span-3 md:col-span-1'>
                   <input type='text' name='father_last_name' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'/>
                 </div>
                </div>
            
                <div class='col-span-3 md:col-span-1 w-full'>
                  <label class='text-[12.5px]'>Middlename</label>
                  <div class='col-span-3 md:col-span-1'>
                    <input type='text' name='father_middle_name' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'/>
                  </div>
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Suffix</label>
                 <div class='col-span-3 md:col-span-1'>
                    <input type='text' name='father_suffix' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'/>
                 </div>
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                  <label class='text-[12.5px]'>Nationality</label>
                   <div class='col-span-3 md:col-span-1'>
                    <input type='text' name='father_nationality' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'  />
                   </div>              
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                  <label class='text-[12.5px]'>Date of Birth</label>
                   <div class='col-span-1 md:col-span-1'>
                    <input type='date' name='father_date_of_birth' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'/>
                  </div>
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                  <label class='text-[12.5px]'>Place of Birth</label>
                  <div class='col-span-3 md:col-span-1'>
                    <input type='text' name='father_place_of_birth' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'  />
                  </div>               
                </div>
 

                <div class='col-span-3 mb-2 mt-4'>
                    <h1 class='font-bold'>Mother’s Information</h1>
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Firstname</label>
                  <div class='col-span-3 md:col-span-1'>
                    <input type='text' name='mother_first_name' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'/>
                  </div>
                
                </div>

                <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Lastname</label>
                 <div class='col-span-3 md:col-span-1'> 
                    <input type='text' name='mother_last_name' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'/>
                 </div>
                </div>



                <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Middlename</label>
                 <div class='col-span-3 md:col-span-1'>
                
                    <input type='text' name='mother_middle_name' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'/>
                 </div>
                </div>
                
                <div class='col-span-3 md:col-span-1 w-full'>
                  <label class='text-[12.5px]'>Maiden Name</label>
                   <div class='col-span-3 md:col-span-1'> 
                    <input type='text' name='mother_maiden_name' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' />
                   </div>
                </div>
                
                <div class='col-span-3 md:col-span-1 w-full'>
                  <label class='text-[12.5px]'>Nationality</label>
                 <div class='col-span-3 md:col-span-1'>
                    <input type='text' name='mother_nationality' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'/>
                 </div>
                </div>
                
                <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Date of Birth</label>
                 <div class='col-span-3 md:col-span-1'>                  
                    <input type='date' name='mother_date_of_birth' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'/>
                 </div>
                </div>
                
                <div class='col-span-3 md:col-span-1 w-full'>
                 <label class='text-[12.5px]'>Place of Birth</label>
                  <div class='col-span-3 md:col-span-1'>
                    <input type='text' name='mother_place_of_birth' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'/>
                  </div>
                </div>
               
                <div class='col-span-3 md:col-span-1 w-full'>
                 <label for='parents_married_at_birth' class='text-[12.5px]'>Were Parents Married at Birth?</label>
                  <div class='col-span-3 md:col-span-1'>
                   
                    <select name='parents_married_at_birth' id='parents_married_at_birth' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' >
                        <option value='yes'>Yes</option>
                        <option value='no'>No</option>
                    </select>
                  </div>
                </div>
               

                <div class='col-span-3 mt-4'>
                    <h1 class='font-bold'>Empolyee Information</h1>
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
                <div class='col-span-3 flex justify-center mt-5'>
                    <button type='submit' class='w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500'>Submit Registration</button>
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
            const response = await fetch('https://civilregistrar.lgu2.com/api/birth.php', {
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
                  window.location.href = "https://civilregistrar.lgu2.com/pages/resident/birthDoc.php";
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