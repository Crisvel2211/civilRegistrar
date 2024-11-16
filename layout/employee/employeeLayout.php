<?php


function employeeLayout($children) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CivilRegistrar</title>
         <link rel="icon" href="https://res.cloudinary.com/dn60f1sgi/image/upload/v1729892573/qcfavicon_pbm25c.png" type="image/x-icon">
         <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css" rel="stylesheet">
        <style>
        .active {
            display: flex;                       
            justify-content: flex-start;        
            align-items: center;              
            margin-top: 0.125rem;               
            gap: 1rem;                          
            padding: 0.5rem;                   
            border-radius: 0.375rem;            
            background-color: rgba(229, 231, 235, 0.12); 
            padding-left: 1.25rem;              
            padding-right: 1.25rem;             
            color: #ffffff;                     
        }

      </style>
    </head>
    <body>
    <div class="w-full gap-[4px] flex h-screen flex-col md:flex md:flex-row">
        <div class="bg-[#191f8a] md:w-[22%] hidden md:block transform translate-x-0 transition-transform duration-300 ease-in" id='sidebarpanel'>
            <div class="flex flex-col gap-1 w-full ">
                <div class='flex relative justify-evenly items-center w-full mt-6 px-4 mb-5'>
                    <div>
                        <img src="../../images/qclogo.png" alt='logo' class='cursor-pointer w-full h-[50px]'/>
                    </div>
                   
                </div>

                <!--menu-->
                <div class='border-t-[.01px] border-[#6b7280] w-full '>

<div class='flex flex-col w-[93%] mx-2 mt-6 mb-8'id="sidebar-link">
    <a href="http://localhost/civil-registrar/pages/employee/employeeDashboard.php" class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
            </svg>
        </div>
        <div>
            <h1 class='font-[500]'>Dashboard</h1>
        </div>
    </a>

    <a href="#" class="flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]" onclick="toggleCertificates(event)">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
        </div>
        <div class='flex justify-between items-center w-full'>
            <h1 class='font-[500] '>Certificates</h1>
            <span id="certificate-toggle-icon" class="text-[20px]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[20px] h-[20px]">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </span>
        </div>
    </a>

    <div id="certificate-submenu" class="hidden mt-2  flex-col gap-1 w-[90%] pl-10">
        <a href='http://localhost/civil-registrar/pages/employee/birthRegistration.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
            <h1 class='text-[13px] font-[600] pl-[2rem]'>Birth Certificate</h1>
        </a>
        <a href='http://localhost/civil-registrar/pages/employee/marriageRegistration.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
            <h1 class='text-[13px] font-[600] pl-[2rem]'>Marriage Certificate</h1>
        </a>
        <a href='http://localhost/civil-registrar/pages/employee/deathRegistration.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
            <h1 class='text-[13px] font-[600] pl-[2rem]'>Death Certificate</h1>
        </a>
    </div>

    <a href='http://localhost/civil-registrar/pages/employee/verifyDocuments.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
        </div>
        <div>
            <h1 class='font-[500]'>Verification</h1>
        </div>
    </a>

    <a href='http://localhost/civil-registrar/pages/employee/appointment.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
        </div>
        <div>
            <h1 class='font-[500]'>Appointment</h1>
        </div>
    </a>

    <a href='http://localhost/civil-registrar/pages/employee/IssuedCertificates.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class='font-[500]'>Issued Certificates</h1>
                            </div>
    </a>

</div>
</div>
            </div>
        </div>

        <div class="bg-gray-200 md:w-[78%] w-full transform translate-x-0 transition-transform duration-300 ease-in-out mx-[1px] p-1 overflow-hidden overflow-y-scroll relative" id="contentpanel">
            <div class='bg-[#191f8a] box-shadow border-b-[1px] border-[#e1e0e4] dark:border-darkHeader border-solid rounded-[5px]' id='header'>
                <div class='flex p-3 justify-between items-center'>
                    <!-- Menu Icon -->
                    <div class='flex justify-start items-center'>
                        <button id='menuButton' class='hidden md:block  text-[#6B737E] cursor-pointer hover:bg-slate-200 h-[35px] w-[35px] p-[5px] rounded-[50%]'>
                            <i class="fas fa-bars text-[24px]"></i>
                        </button>
                        <button class='block md:hidden text-[#6B737E] cursor-pointer hover:bg-slate-200 h-[35px] w-[35px] p-[5px] rounded-[50%]' id='mobilemenuButton'>
                            <i class="fas fa-bars text-[24px]"></i>
                        </button>
                    </div>
                    <!-- Notifications and Profile sections -->
                    <!-- ... -->
                      <!-- Notifications -->
                    <div class='flex justify-evenly items-center gap-4 pr-[1rem]'>
                    <div class='flex justify-end items-center gap-2 relative'>
    <!-- Notification Bell Icon -->
    <div id='notificationButton' class='relative w-[35px] h-[35px] text-[#93A3BC] font-semibold cursor-pointer hover:bg-slate-300 rounded-[50%] hover:bg-opacity-[.03] p-[7px]'>
        <span class='w-[21px] h-[21px] font-semibold cursor-pointer'>
            <i class="fas fa-bell text-[22px] text-[#6B737E] cursor-pointer"></i>
            <span id="notificationCount" class="absolute top-0 right-0  text-red-800 text-xs rounded-full px-1"></span>
        </span>
    </div>

    <!-- Notification Panel -->
    <div id='notificationPanel' class='absolute bg-[#ffffff] right-[.5rem] w-[16.5rem] h-[16rem] mt-[12px] rounded-[15px] shadow-2xl z-[1000] hidden -bottom-[17rem]'>
        <div class='flex justify-between items-center bg-[#5046e5] bg-cover rounded-t-[15px] p-[18px]'>
            <h1 class='text-[#fff] font-[600]'>Notifications</h1>
        </div>
        <div id="notificationList" class='flex flex-col justify-start items-center w-full h-[12rem] overflow overflow-hidden overflow-y-scroll p-4'>
            <!-- Notification items will be injected here -->
            <h1 class='text-[#2f3744] text-[16px]'>No notifications</h1>
        </div>
    </div>
</div>

                        <!-- Profile -->
                        <div class='relative w-[35px] h-[35px] text-[#93A3BC] font-semibold cursor-pointer hover:bg-slate-300 rounded-[50%] hover:bg-opacity-[.03] p-[7px]' >
                            
                            <!-- Dynamic Profile Image or Sign In Button -->
                         <div id="authDisplay"></div>
                            

                            <div id='profilePanel' class='absolute bg-[#ffffff] right-[.5rem] w-[10rem] h-[10rem] mt-[12px] rounded-[5px] shadow-lg z-[1000] hidden'>
                                <div class='border-b-[.01px] border-[#e5e8eb]'>
                                    <div class='hover:bg-gray-900 hover:bg-opacity-[.12] cursor-pointer p-2 my-[4px] w-full'>
                                        <p class='text-[14px] font-[400] text-[#324153]'>Signed in as</p>
                                        <p class='text-[12px] font-[400] text-[#324153]' id="email-display"></p>
                                    </div>
                                </div>
                                  <div class='border-b-[.01px] border-[#e5e8eb]'>
                                    <a href='http://localhost/civil-registrar/pages/employee/employeeProfile.php' class='hover:bg-gray-900 hover:bg-opacity-[.12] cursor-pointer p-2 my-[4px] w-full flex justify-start items-center gap-4'>
                                        <img src='../../images/profile-icon.svg' alt='profile-icon' class='w-[21px] h-[21px] font-semibold cursor-pointer'/>
                                        <p class='text-[14px] font-[400] text-[#324153]'>Profile</p>
                                    </a>
                                  </div>
                                   <div class=''>
                                    <div class='hover:bg-gray-900 hover:bg-opacity-[.12] cursor-pointer p-2 my-[4px] w-full flex justify-start items-center gap-4' onclick="showLogoutModal()">
                                        <img src='../../images/logout.svg' alt='profile-icon' class='w-[21px] h-[21px] font-semibold cursor-pointer'/>
                                        <p class='text-[14px] font-[400] text-[#324153]'>Sign out</p>
                                    </div>
                                   </div>
                              </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div>
                <?php echo $children; ?>
            </div>
   
            </div>
          <!--mobilesidebar-->
            <div class="absolute top-16 left-0 right-0 bg-blue-900 md:w-[22%] transform translate-x-0 transition-transform duration-300 ease-in mx-1 rounded-b-md hidden" id='mobilesidebarpanel'>
            <div class="flex flex-col gap-1 w-full ">
                <div class='flex relative justify-evenly items-center w-full mt-6 px-4 mb-5'>
                    <div>
                        <img src="../../images/qclogo.png" alt='logo' class='cursor-pointer w-full h-[50px]'/>
                    </div>
                    <div>
                        <h1 class='text-[#e3e4e9] text-[25px] text-center font-bold'>Civil Registrar</h1>
                    </div>
                </div>

                <!--menu-->
                <div class='border-t-[.01px] border-[#6b7280] w-full '>

                <div class='flex flex-col w-[93%] mx-2 mt-6 mb-8' id="sidebar-link">
                        <a href="http://localhost/civil-registrar/pages/employee/employeeDashboard.php" class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class='font-[500]'>Dashboard</h1>
                            </div>
                        </a>

                        <a href="#" class="flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]" onclick="mobiletoggleCertificates(event)">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                            <div class='flex justify-between items-center w-full'>
                                <h1 class='font-[500] '>Certificates</h1>
                                <span id="certificate-toggle-icon" class="text-[20px]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[20px] h-[20px]">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </span>
                            </div>
                        </a>

                        <div id="mobilecertificate-submenu" class="hidden mt-2  flex-col gap-1 w-[90%] pl-10">
                            <a href='http://localhost/civil-registrar/pages/employee/birthRegistration.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                                <h1 class='text-[13px] font-[600] pl-[2rem]'>Birth Certificate</h1>
                            </a>
                            <a href='http://localhost/civil-registrar/pages/employee/marriageRegistration.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                                <h1 class='text-[13px] font-[600] pl-[2rem]'>Marriage Certificate</h1>
                            </a>
                            <a href='http://localhost/civil-registrar/pages/employee/deathRegistration.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                                <h1 class='text-[13px] font-[600] pl-[2rem]'>Death Certificate</h1>
                            </a>
                        </div>
                        
                        <a href='http://localhost/civil-registrar/pages/employee/verifyDocuments.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class='font-[500]'>Verification</h1>
                            </div>
                        </a>

                        <a href='http://localhost/civil-registrar/pages/employee/appointment.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class='font-[500]'>Appointment Schedule</h1>
                            </div>
                        </a>

                        <a href='http://localhost/civil-registrar/pages/employee/IssuedCertificates.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </div>
                            <div>
                                <h1 class='font-[500]'>Issued Certificates</h1>
                            </div>
                        </a>

                </div>
</div>
            </div>
           </div>
               
        </div>
    </div>

    <!-- Logout Modal -->
    <div id="logoutModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-[65%] md:w-[25%]  p-6">
            <h2 class="text-xl font-semibold mb-4">Confirm Logout</h2>
            <p class="text-gray-600 mb-6">Are you sure you want to log out?</p>
            <div class="flex justify-between gap-4">
                <button onclick="closeLogoutModal()" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Cancel</button>
                <p class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 cursor-pointer" onclick="logout()">Sign out</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>

        // Function to display the logout modal
        function showLogoutModal() {
            document.getElementById("logoutModal").classList.remove("hidden");
        }

        // Function to hide the logout modal
        function closeLogoutModal() {
            document.getElementById("logoutModal").classList.add("hidden");
        }

        // Logout Function with Modal
    function logout() {
        localStorage.clear();
        showToast('You have successfully logged out.', 'success');
        window.location.href = 'http://localhost/civil-registrar/index.php';
    }

         function showToast(message, type) {
            Toastify({
                text: message,
                style: {
                    background: type === 'success' ? 'linear-gradient(to right, #00b09b, #96c93d)' : 'linear-gradient(to right, #ff5f6d, #ffc371)'
                },
                duration: 3000
            }).showToast();
        }
          
        function toggleCertificates(event) {
            event.preventDefault();
            const submenu = document.getElementById('certificate-submenu');
            const toggleIcon = document.getElementById('certificate-toggle-icon');

            // Toggle submenu visibility
            submenu.classList.toggle('hidden');
            
            // Update toggle icon
            if (submenu.classList.contains('hidden')) {
                toggleIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[20px] h-[20px]"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"/></svg>';
            } else {
                toggleIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[20px] h-[20px]"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 15l-7-7-7 7"/></svg>';
            }
        }

        function mobiletoggleCertificates(event) {
            event.preventDefault();
            const submenu = document.getElementById('mobilecertificate-submenu');
            const toggleIcon = document.getElementById('certificate-toggle-icon');

            // Toggle submenu visibility
            submenu.classList.toggle('hidden');
            
            // Update toggle icon
            if (submenu.classList.contains('hidden')) {
                toggleIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[20px] h-[20px]"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"/></svg>';
            } else {
                toggleIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[20px] h-[20px]"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 15l-7-7-7 7"/></svg>';
            }
        }
        
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarLinks = document.querySelectorAll(".sidebar-link");
            const currentPath = window.location.pathname;

            sidebarLinks.forEach(link => {
                if (link.href === window.location.href) {
                    link.classList.add("active");
                }
            });
        });
        const modal = document.getElementById("mobilesidebarpanel");
    const openModalButton = document.getElementById("mobilemenuButton");

    // Function to toggle modal visibility
    const toggleModal = () => {
      modal.classList.toggle("hidden");
    };


    document.addEventListener("DOMContentLoaded", function () {
        const authDisplay = document.getElementById('authDisplay');
        const profileImage = localStorage.getItem('profileImage'); // Base64 image stored, or null

        if (profileImage) {
            // User is authenticated, show profile image from localStorage
            authDisplay.innerHTML = `<img src="${profileImage}" alt="Profile" class='w-[21px] h-[21px] font-semibold cursor-pointer rounded-[100%]' id='profileButton'/>`;
        }
    });

    // Open/Close modal on button click
    openModalButton.addEventListener("click", toggleModal);
        document.addEventListener('DOMContentLoaded', () => {
            const notificationButton = document.getElementById('notificationButton');
            const profileButton = document.getElementById('profileButton');
            const notificationPanel = document.getElementById('notificationPanel');
            const profilePanel = document.getElementById('profilePanel');
           
            const sidebarPanel = document.getElementById('sidebarpanel');
            const menuButton = document.getElementById('menuButton');
            const contentPanel = document.getElementById('contentpanel');

            // Toggle sidebar visibility
            menuButton.addEventListener('click', () => {
                sidebarPanel.classList.toggle('-translate-x-full');
                sidebarPanel.classList.toggle('translate-x-0');

                // Adjust content panel width
                contentPanel.classList.toggle('md:-ml-[22.2%]');
                contentPanel.classList.toggle('md:w-full');
                contentPanel.classList.toggle('md:mr-[1px]');
            });

            // Toggle notification panel visibility
            notificationButton.addEventListener('click', () => {
                notificationPanel.classList.toggle('hidden');
                profilePanel.classList.add('hidden'); // Hide profile panel if open
            });

            // Toggle profile panel visibility
            profileButton.addEventListener('click', (event) => {
                event.stopPropagation(); // Prevents the event from bubbling up
                profilePanel.classList.toggle('hidden');
                notificationPanel.classList.add('hidden'); // Hide notification panel if open
            });

        

            // Hide panels if clicking outside
            document.addEventListener('click', (event) => {
                if (!event.target.closest('#notificationButton') && !event.target.closest('#notificationPanel')) {
                    notificationPanel.classList.add('hidden');
                }
                if (!event.target.closest('#profileButton') && !event.target.closest('#profilePanel')) {
                    profilePanel.classList.add('hidden');
                } if (!event.target.closest('#mobilemenuButton') && !event.target.closest('#mobilesidebarpanel')) {
                    mobilesidebarpanel.classList.add('hidden');
                }
            });
        });
        // Get the email from localStorage
            const email = localStorage.getItem('email');

            // If email exists, display it, otherwise do nothing
            if (email) {
                document.getElementById('email-display').textContent = email;
            }

           


    


    
       

    // Function to load notifications

    document.addEventListener('DOMContentLoaded', function() {
    // Function to load notifications
    function loadNotifications() {
        const employeeId = localStorage.getItem('userId'); // Assuming notifications are employee-specific

        if (!employeeId) {
            console.error('No employee ID found in local storage.');
            showToast('No employee ID found. Please log in again.', 'error');
            return;
        }

        fetch(`http://localhost/civil-registrar/api/notifications.php?employee_id=${employeeId}`)
            .then(response => response.json())
            .then(notifications => {
                const notificationList = document.getElementById('notificationList');
                const notificationCount = document.getElementById('notificationCount');

                if (!notificationCount) {
                    console.error('Notification count element not found.');
                    return;
                }

                notificationList.innerHTML = ''; // Clear previous notifications
                notificationCount.textContent = ''; // Reset notification count

                if (notifications.length > 0) {
                    // Set the notification count
                    notificationCount.textContent = notifications.length;

                    // Loop through notifications and append them to the panel
                    notifications.forEach(notification => {
                        const notificationItem = document.createElement('div');
                        notificationItem.className = 'w-full p-2 text-[#2f3744] text-[14px] mb-2 border-b border-gray-200';
                        notificationItem.innerHTML = `
                            <span>${notification.message}</span>
                           
                        `;
                        notificationList.appendChild(notificationItem);
                    });
                } else {
                    // Display no notifications message if none exist
                    notificationList.innerHTML = `
                        <div class='text-center'>
                            <h1 class='text-[#2f3744] text-[16px]'>No notifications</h1>
                            <p class='text-[12px] text-[#324153]'>When you have notifications, they will appear here.</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                showToast('Error loading notifications!', 'error');
            });
    }

    // Load notifications immediately on page load
    loadNotifications();

    // Optional: Function to display toast messages (e.g., success or error)
    function showToast(message, type) {
        alert(`${type.toUpperCase()}: ${message}`);
    }
});


    
    </script>
    </body>
    </html>
    <?php
}
?>
