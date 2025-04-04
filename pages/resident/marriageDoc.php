<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

$updateProfileContent = "
  <div class='container mx-auto w-full md:mt-1 px-[8px] h-[88vh] overflow-y-scroll'>
    <div class='flex items-center space-x-2 p-4'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-8 h-8 text-blue-600'>
                <path stroke-linecap='round' stroke-linejoin='round' d='M4 7l7 7-7 7M5 14h12a2 2 0 012 2v0a2 2 0 01-2 2H5a2 2 0 01-2-2v0a2 2 0 012-2'/>
            </svg>
            <h1 class='text-2xl font-bold text-gray-800'>SUBMIT SUPPORTING DOCUMENTS (MARRIAGE)</h1>
        </div>
  <div class='bg-white shadow-md rounded px-8 pt-6 pb-8 w-[88%] mx-auto mt-1'>
       
        <form id='documentForm' class='grid grid-cols-1 md:grid-cols-2 gap-4'>
            <input type='hidden' id='user_id' name='user_id'> <!-- Hidden User ID -->
            <div class='mb-4 col-span-2 md:col-span-1'>
                <label class='block text-gray-700 text-sm font-bold mb-2' for='full_name'>Full Name</label>
                <input id='full_name' type='text' name='full_name' class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline' placeholder='Full Name'>
            </div>
            <div class='mb-4 col-span-2 md:col-span-1'>
                <label class='block text-gray-700 text-sm font-bold mb-2' for='date_of_birth'>Date of Birth</label>
                <input id='date_of_birth' type='date' name='date_of_birth' class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'>
            </div>
            <div class='mb-4 col-span-2 md:col-span-1'>
                <label class='block text-gray-700 text-sm font-bold mb-2' for='address'>Address</label>
                <input id='address' type='text' name='address' class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline' placeholder='Address'>
            </div> 
            <div class='mb-4 col-span-2 md:col-span-1'>
                <label class='block text-gray-700 text-sm font-bold mb-2' for='phone'>Phone</label>
                <input id='phone' type='text' name='phone' pattern='^[0-9]{10}$' class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline' placeholder='Phone (10 digits)'>
                <p class='text-red-500 text-xs italic hidden' id='phone-error'>Please enter a valid 10-digit phone number.</p>
            </div>
            <div class='mb-4 col-span-2 md:col-span-1'>
                <label class='block text-gray-700 text-sm font-bold mb-2' for='verification_type'>Verification Type</label>
                <select id='verification_type' name='verification_type' class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'>
                    <option value='' disabled selected>Select Verification Type</option>
                    <option value='govtID'>Government ID</option>
                    <option value='certificate'>Certificate</option>
                    <option value='supportingDocs'>Supporting Documents</option>
                </select>
            </div>
            <div class='mb-4 col-span-2 md:col-span-1'>
                <label class='block text-gray-700 text-sm font-bold mb-2' for='image'>Upload Document</label>
                <input id='image' type='file' name='image' class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'>
            </div>
            <div class='flex items-center justify-between col-span-2 '>
                <button type='submit' class='bg-indigo-500 hover:bg-indigo-600 w-full text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline'>
                    Submit
                </button>
            </div>
        </form>
    </div>

  </div>
    
";

residentLayout($updateProfileContent);
?>

<script src='https://cdn.jsdelivr.net/npm/toastify-js'></script>

<script>
    // Set userId from localStorage
    document.getElementById('user_id').value = localStorage.getItem('userId') || '';

    document.getElementById('documentForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        
        // Custom validation for phone number
        const phoneInput = document.getElementById('phone');
        const phoneError = document.getElementById('phone-error');
        
        // Regex for validating 10-digit phone number
        const phonePattern = /^[0-9]{10}$/;

        // Clear previous error message
        phoneError.classList.add('hidden');

        if (phoneInput.value && !phonePattern.test(phoneInput.value)) {
            phoneError.classList.remove('hidden'); // Show error message
            showToast('Please enter a valid 10-digit phone number.', 'error');
            return; // Stop submission if invalid
        }

        try {
            const response = await fetch('http://localhost/group69/api/verification.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();

            if (response.ok) {
                showToast(result.message, 'success');
                this.reset(); // Reset the form fields

                // Proceed to PayMongo checkout after successful form submission
                redirectToCheckout();
            } else {
                showToast(result.error || 'Error occurred', 'error');
            }
        } catch (error) {
            showToast('Network error: ' + error.message, 'error');
        }
    });

    function redirectToCheckout() {
        const customerData = {
            name: localStorage.getItem("name") || "Default Name",
            email: localStorage.getItem("email") || "default@example.com"
        };

        fetch("http://localhost/group69/api/marriagePaymentApi.php", {
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

    function showToast(message, type) {
        Toastify({
            text: message,
            style: {
                background: type === 'success' ? 'linear-gradient(to right, #00b09b, #96c93d)' : 'linear-gradient(to right, #ff5f6d, #ffc371)',
            },
            duration: 3000,
        }).showToast();
    }
</script>

