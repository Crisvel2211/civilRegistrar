<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

$updateProfileContent = "
    <div class='container mx-auto w-full md:mt-1 px-[8px] h-[88vh] overflow-y-scroll'>
        <div class='container mx-auto p-6'>
             <div class='flex items-center space-x-2 p-4 -ml-7 -mt-6 mb-5'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M12 8v4m0 4h.01M6 8l6 6 6-6'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>LEGAL AND ADMINISTRATIVE</h1>
        </div class='w-full mx-auto mt-8'>
            <form id='legalForm' class='grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-6 rounded-lg shadow-md w-[88%] mx-auto'>
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
                    <label for='userId' class='block text-sm font-medium text-gray-700'>User ID</label>
                    <input type='number' id='userId' name='userId' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'>
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
        const userId = localStorage.getItem('userId');
        if (userId) {
            data.userId = userId; // Set userId in the data object
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
            const response = await fetch('https://civilregistrar.lgu2.com/api/legal.php', {
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
                setTimeout(() => {
                    redirectToCheckout();
              }, 2000);
            } else {
                showToast('Error: ' + result.error, 'error'); // Error toast
            }
        } catch (error) {
            showToast('An error occurred: ' + error.message, 'error'); // Error toast
        } finally {
            submitButton.disabled = false; // Re-enable the button in all cases
        }
    });

    function redirectToCheckout() {
        const customerData = {
            name: localStorage.getItem("name") || "Default Name",
            email: localStorage.getItem("email") || "default@example.com"
        };

        fetch("https://civilregistrar.lgu2.com/api/legalPaymentApi.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(customerData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.checkout_url) {
                window.location.href = data.checkout_url; // Redirect to PayMongo checkout
            } else {
                console.error("Error:", data.error);
                showToast('Payment initialization failed!', 'error');
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
            showToast('Network error while processing payment.', 'error');
        });
    }

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
