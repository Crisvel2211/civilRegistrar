<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

$updateProfileContent = "
    <div class='container mx-auto w-full md:mt-1 px-[8px] h-[88vh] overflow-y-scroll'>
        <div class='container mx-auto p-6'>
            <div class='mb-8'>
                <h1 class='text-3xl font-bold text-center text-gray-500'>Legal and Administrative Form</h1>
            </div>
            <form id='legalForm' action='#' method='POST' class='grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-6 rounded-lg shadow-md'>
                <div class='mb-4'>
                    <label for='service_name' class='block text-sm font-medium text-gray-700'>Service Name</label>
                    <select id='service_name' name='service_name' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'>
                        <option value='' disabled selected>Select a Service</option>
                        <option value='Admission of Paternity'>Admission of Paternity</option>
                        <option value='Legitimation with Admission of Paternity'>Legitimation with Admission of Paternity</option>
                        <option value='Petition for Change of First Name (CFN)'>Petition for Change of First Name (CFN)</option>
                        <option value='Petition for Correction of Clerical Error (CCE)'>Petition for Correction of Clerical Error (CCE)</option>
                        <option value='Petition for Correction of Sex and/or Date of Birth'>Petition for Correction of Sex and/or Date of Birth</option>
                    </select>
                </div>

                <div class='mb-4'>
                    <label for='applicant_name' class='block text-sm font-medium text-gray-700'>Applicant Name</label>
                    <input type='text' id='applicant_name' name='applicant_name' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'>
                </div>

                <div class='mb-4'>
                    <label for='applicant_contact' class='block text-sm font-medium text-gray-700'>Applicant Contact</label>
                    <input type='text' id='applicant_contact' name='applicant_contact' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'>
                </div>

                <div class='mb-4'>
                    <label for='applicant_address' class='block text-sm font-medium text-gray-700'>Applicant Address</label>
                    <input type='text' id='applicant_address' name='applicant_address' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'>
                </div>

                <div class='mb-4'>
                    <label for='reason_for_change' class='block text-sm font-medium text-gray-700'>Reason for Change</label>
                    <textarea id='reason_for_change' name='reason_for_change' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'></textarea>
                </div>

                <div class='mb-4'>
                    <label for='reference_number' class='block text-sm font-medium text-gray-700'>Reference Number</label>
                    <input type='text' id='reference_number' name='reference_number' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'>
                </div>

               <div class='mb-4 hidden'>
                    <label for='user_id' class='block text-sm font-medium text-gray-700'>User ID</label>
                    <input type='number' id='user_id' name='user_id' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'>
                </div>


                <div class='mb-4'>
                    <label for='employee' class='block text-sm font-medium text-gray-700'>Assigned Employee</label>
                    <select id='employee' name='employee' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'>
                        <option value='' disabled selected>Select an employee</option>
                        <!-- Employee options will be populated here by JavaScript -->
                    </select>
                </div>

                <div class='mb-4 col-span-2'>
                    <button type='submit' class='w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500'>Submit</button>
                </div>
            </form>
        </div>
    </div>
";

residentLayout($updateProfileContent);
?>

<script>
    // Toast function to display success or error messages
    function showToast(message, type) {
        Toastify({
            text: message,
            style: {
                background: type === 'success' ? 'linear-gradient(to right, #00b09b, #96c93d)' : 'linear-gradient(to right, #ff5f6d, #ffc371)'
            },
            duration: 3000
        }).showToast();
    }

    document.getElementById('legalForm').addEventListener('submit', async function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        const submitButton = this.querySelector('button[type="submit"]');

        // Retrieve user ID from local storage
        const user_id = localStorage.getItem('userId');
        if (user_id) {
            data.user_id = user_id; // Set userId in the data object
        } else {
            showToast('User ID is not found in local storage.', 'error');
            return; // Stop the form submission if userId is not found
        }

        if (data.employee) {
            data.employee_id = data.employee; 
            delete data.employee;
        }

        // Check for missing required fields
    const requiredFields = ['service_name', 'applicant_name', 'applicant_contact', 'applicant_address', 'reason_for_change', 'reference_number'];
    for (let field of requiredFields) {
        if (!data[field] || data[field].trim() === '') {
            showToast(`Please fill out the ${field.replace('_', ' ')} field.`, 'error');
            return; // Stop form submission if any required field is empty
        }
    }

        // Disable the submit button to prevent multiple submissions
        submitButton.disabled = true;

        try {
            const response = await fetch('http://localhost/group69/api/legal.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();
            if (response.ok) {
                showToast('Success: ' + result.message, 'success'); // Success toast
                this.reset(); // Clear the form
            } else {
                showToast('Error: ' + result.error, 'error'); // Error toast
            }
        } catch (error) {
            showToast('An error occurred: ' + error.message, 'error'); // Error toast
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
            // Check if the response contains employee data
            if (Array.isArray(employees)) {
                employees.forEach(employee => {
                    const option = document.createElement('option');
                    option.value = employee.id; // Set the value to the employee ID
                    option.textContent = employee.name; // Set the display text to the employee's name
                    selectElement.appendChild(option);
                });
            } else {
                console.error('Invalid data structure:', employees);
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
</script>
