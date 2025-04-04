<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

$updateProfileContent = "
    <div class='container mx-auto w-full h-[88vh] overflow-y-scroll'>
        <div class='container mx-auto p-6'>
           <div class='flex items-center space-x-2 p-4 -ml-7 -mt-6'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M9 12h6M12 9v6M4 4l16 16'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>PERMIT REQUEST</h1>
        </div>
            
            <!-- Permit Request Form -->
            <form id='requestForm' class='bg-white p-6 rounded-lg shadow-md grid grid-cols-1 md:grid-cols-2 gap-4 w-[88%] mx-auto mt-4'>
                <div class='mb-4'>
                    <label for='permit_type' class='block text-sm font-medium text-gray-700'>Permit Type</label>
                    <select id='permit_type' name='permit_type' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'>
                        <option value='exhumation'>Exhumation</option>
                        <option value='burial'>Burial</option>
                        <option value='cremation'>Cremation</option>
                    </select>
                </div>
                
                <div class='mb-4'>
                    <label for='resident_name' class='block text-sm font-medium text-gray-700'>Resident Full Name</label>
                    <input type='text' id='resident_name' name='resident_name' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' >
                </div>

                <div class='mb-4'>
                    <label for='date_of_request' class='block text-sm font-medium text-gray-700'>Date of Request</label>
                    <input type='date' id='date_of_request' name='date_of_request' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' >
                </div>

                <div class='mb-4'>
                    <label for='employee' class='block text-sm font-medium text-gray-700'>Assigned Employee</label>
                    <select id='employee' name='employee' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'>
                        <option value='' disabled selected>Select an employee</option>
                        <!-- Employee options will be populated here by JavaScript -->
                    </select>
                </div>

                <div class='mb-4 col-span-2'>
                    <label for='additional_details' class='block text-sm font-medium text-gray-700'>Additional Details</label>
                    <textarea id='additional_details' name='additional_details' rows='4' class='mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm'></textarea>
                </div>
                
                <div class='mb-4 md:col-span-2 flex justify-center'>
                    <button type='submit' class='w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500'>Submit Request</button>
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

    document.getElementById('requestForm').addEventListener('submit', async function(event) {
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

        // Check for missing  fields
    const Fields = ['permit_type', 'resident_name', 'date_of_request', 'additional_details'];
    for (let field of Fields) {
        if (!data[field] || data[field].trim() === '') {
            showToast(`Please fill out the ${field.replace('_', ' ')} field.`, 'error');
            return; // Stop form submission if any  field is empty
        }
    }

        // Disable the submit button to prevent multiple submissions
        submitButton.disabled = true;

        try {
            const response = await fetch('http://localhost/group69/api/permit_request_api.php', {
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

        fetch("http://localhost/group69/api/permitPaymentApi.php", {
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