<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Death Registration Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Toastify CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
  <div class="bg-white shadow-xl rounded-lg p-8 max-w-4xl w-full">
    <h2 class="text-2xl font-bold mb-6 text-center">Death Registration Form</h2>
    <form id="deathForm" class="space-y-6">

      <!-- Deceased Information -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Deceased Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <input type="text" name="deceased_first_name" placeholder="First Name" class="input" required />
          <input type="text" name="deceased_middle_name" placeholder="Middle Name" class="input" required />
          <input type="text" name="deceased_last_name" placeholder="Last Name" class="input" required />
          <input type="text" name="deceased_nationality" placeholder="Nationality" class="input" required />
          <input type="date" name="deceased_date_of_birth" class="input" required />
          <input type="text" name="deceased_place_of_birth" placeholder="Place of Birth" class="input" required />
        </div>
      </div>

      <!-- Death Information -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Death Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <input type="date" name="deceased_date_of_death" placeholder="Date of Death" class="input" required />
          <input type="text" name="deceased_place_of_death" placeholder="Place of Death" class="input" required />
          <input type="text" name="cause_of_death" placeholder="Cause of Death" class="input" required />
        </div>
      </div>

      <!-- Certifier Information -->
      <div>
        <h3 class="text-lg font-semibold mb-2">Certifier Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" name="certifier_name" placeholder="Certifier Name" class="input" required />
        </div>
      </div>

      <div class="text-center mt-6">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">Submit</button>
      </div>
    </form>
  </div>

  <!-- Toastify JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.js"></script>

  <script>
    function showToast(message, type) {
      Toastify({
        text: message,
        style: {
          background: type === 'success'
            ? "linear-gradient(to right, #00b09b, #96c93d)"
            : "linear-gradient(to right, #ff5f6d, #ffc371)"
        },
        duration: 3000,
        close: true
      }).showToast();
    }

    document.getElementById('deathForm').addEventListener('submit', async function (e) {
      e.preventDefault();
      const form = e.target;
      const formData = new FormData(form);
      const data = {};
      formData.forEach((value, key) => {
        data[key] = value;
      });

      try {
        const response = await fetch('https://civilregistrar.lgu2.com/api/integratedDeath.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
          showToast('Death record submitted successfully!', 'success');
          form.reset();
        } else {
          showToast(result.message || 'Submission failed!', 'error');
        }
      } catch (error) {
        showToast('An error occurred during submission.', 'error');
        console.error(error);
      }
    });
  </script>

  <style>
    .input {
      @apply border border-gray-300 rounded-lg px-3 py-2 w-full;
    }
  </style>
</body>
</html>
