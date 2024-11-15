<?php
// Include the layout file (ensure the path is correct)
include '../../layout/resident/residentLayout.php';

// Define the content for the Civil Registrar multi-step form
$multiContent = "
<div class='flex items-center justify-center min-h-screen bg-gradient-to-b from-blue-900 via-purple-700 to-pink-700 p-4'>
  <div class='w-full max-w-md p-6 bg-white rounded-lg shadow-md'>
    <header class='text-3xl font-bold text-center mb-6'>Civil Registrar Form</header>
    <div class='flex justify-between mb-6'>
      <div class='text-center'>
        <p class='font-medium text-sm mb-2'>Personal</p>
        <div class='w-8 h-8 rounded-full border-2 border-black mx-auto flex items-center justify-center relative bullet' data-step='1'>
          <span class='step-number text-base font-medium'>1</span>
          <i class='fas fa-check absolute text-green-500 hidden check-icon flex items-center justify-center'></i>
        </div>
      </div>
      <div class='text-center'>
        <p class='font-medium text-sm mb-2'>Contact</p>
        <div class='w-8 h-8 rounded-full border-2 border-black mx-auto flex items-center justify-center relative bullet' data-step='2'>
          <span class='step-number text-base font-medium'>2</span>
          <i class='fas fa-check absolute text-green-500 hidden check-icon flex items-center justify-center'></i>
        </div>
      </div>
      <div class='text-center'>
        <p class='font-medium text-sm mb-2'>Details</p>
        <div class='w-8 h-8 rounded-full border-2 border-black mx-auto flex items-center justify-center relative bullet' data-step='3'>
          <span class='step-number text-base font-medium'>3</span>
          <i class='fas fa-check absolute text-green-500 hidden check-icon flex items-center justify-center'></i>
        </div>
      </div>
      <div class='text-center'>
        <p class='font-medium text-sm mb-2'>Finish</p>
        <div class='w-8 h-8 rounded-full border-2 border-black mx-auto flex items-center justify-center relative bullet' data-step='4'>
          <span class='step-number text-base font-medium'>4</span>
          <i class='fas fa-check absolute text-green-500 hidden check-icon flex items-center justify-center'></i>
        </div>
      </div>
    </div>

    <form class='form-outer'>
      <div class='page slide-page space-y-4'>
        <div>
          <label class='block text-left font-medium'>First Name</label>
          <input type='text' class='w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 required'>
        </div>
        <div>
          <label class='block text-left font-medium'>Last Name</label>
          <input type='text' class='w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 required'>
        </div>
        <button type='button' class='w-full py-2 mt-4 text-white bg-pink-500 rounded-lg next' id='firstNext'>Next</button>
      </div>

      <!-- Contact Information Page -->
      <div class='page hidden space-y-4'>
        <div>
          <label class='block text-left font-medium'>Email</label>
          <input type='email' class='w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 required'>
        </div>
        <div>
          <label class='block text-left font-medium'>Phone</label>
          <input type='tel' class='w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 required'>
        </div>
        <div class='flex justify-between'>
          <button type='button' class='px-6 py-2 mt-4 text-white bg-gray-400 rounded-lg prev'>Previous</button>
          <button type='button' class='px-6 py-2 mt-4 text-white bg-pink-500 rounded-lg next'>Next</button>
        </div>
      </div>

      <!-- Additional Details Page -->
      <div class='page hidden space-y-4'>
        <div>
          <label class='block text-left font-medium'>Birth Date</label>
          <input type='date' class='w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 required'>
        </div>
        <div>
          <label class='block text-left font-medium'>Gender</label>
          <select class='w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 required'>
            <option value=''>Select Gender</option>
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
          </select>
        </div>
        <div class='flex justify-between'>
          <button type='button' class='px-6 py-2 mt-4 text-white bg-gray-400 rounded-lg prev'>Previous</button>
          <button type='button' class='px-6 py-2 mt-4 text-white bg-pink-500 rounded-lg next'>Next</button>
        </div>
      </div>

      <!-- Final Confirmation Page -->
      <div class='page hidden space-y-4'>
        <div>
          <label class='block text-left font-medium'>Status</label>
          <select class='w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 required'>
            <option value=''>Select Status</option>
            <option>Single</option>
            <option>Married</option>
            <option>Divorced</option>
            <option>Widowed</option>
          </select>
        </div>
        <div class='flex justify-between'>
          <button type='button' class='px-6 py-2 mt-4 text-white bg-gray-400 rounded-lg prev'>Previous</button>
          <button type='button' class='w-full py-2 mt-4 text-white bg-green-500 rounded-lg submit'>Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
";

residentLayout($multiContent);
?>

<!-- JavaScript for Multi-Step Form -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const pages = document.querySelectorAll('.page');
  const nextButtons = document.querySelectorAll('.next');
  const prevButtons = document.querySelectorAll('.prev');
  const bullets = document.querySelectorAll('.bullet');
  const submitButton = document.querySelector('.submit');
  let current = 0;

  function validateFields(page) {
    const requiredFields = page.querySelectorAll('.required');
    let allFilled = true;
    requiredFields.forEach(field => {
      if (field.value.trim() === '') {
        allFilled = false;
        field.classList.add('border-red-500');
      } else {
        field.classList.remove('border-red-500');
      }
    });
    return allFilled;
  }

  function updateBullets(step) {
    const bullet = bullets[step];
    bullet.classList.add('border-green-500');
    bullet.querySelector('.step-number').classList.add('hidden');
    bullet.querySelector('.fa-check').classList.remove('hidden');
  }

  function showPage(index) {
    pages.forEach((page, i) => {
      page.classList.toggle('hidden', i !== index);
    });
    window.scrollTo(0, 0);
  }

  nextButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const currentPage = pages[current];
      if (validateFields(currentPage)) {
        updateBullets(current);
        current += 1;
        showPage(current);
      } else {
        alert("Please fill in all required fields.");
      }
    });
  });

  prevButtons.forEach((button) => {
    button.addEventListener('click', () => {
      if (current > 0) {
        current -= 1;
        showPage(current);
      }
    });
  });

  submitButton.addEventListener('click', () => {
    const currentPage = pages[current];
    if (validateFields(currentPage)) {
      updateBullets(current);
      alert("Your Form Successfully Signed up!");
      document.querySelector('form').reset();
      bullets.forEach((bullet) => {
        bullet.classList.remove('border-green-500');
        bullet.querySelector('.step-number').classList.remove('hidden');
        bullet.querySelector('.fa-check').classList.add('hidden');
      });
      current = 0;
      showPage(current);
    } else {
      alert("Please fill in all required fields.");
    }
  });

  showPage(current);
});
</script>
