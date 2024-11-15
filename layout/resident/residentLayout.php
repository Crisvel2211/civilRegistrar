<?php


function residentLayout($children) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <title>CivilRegistrar</title>
        <link rel="icon" href="../../images/qcfavicon.svg" type="image/x-icon">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        html{
    scroll-behavior: smooth;
    font-family: "Inter", sans-serif;
  }
  
  .cardShadow{
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.25);
  }
  .card {
    background-image: url('../../images/coverVoice.svg');
    background-position: center;
    background-size: cover;
    object-fit: cover;
    height: 28rem;
    width: 23rem;
  }
  
  .voicescript::-webkit-scrollbar{
    width: 0px;
    height: 0px;
    cursor: pointer;
    
  }
  .voicescript::-webkit-scrollbar-thumb{
    background-color: transparent;
    
  }
  #usernameSection {
    overflow-y: auto; /* Enable vertical scrolling */
    max-height: 200px; /* Adjust this value as needed */
}


      </style>
    </head>
    <body>
        <div class="w-full gap-[4px] flex h-screen flex-col md:flex md:flex-row">
            <div class="bg-blue-900 md:w-[22%] hidden md:block transform translate-x-0 transition-transform duration-300 ease-in" id='sidebarpanel'>
                <div class="flex flex-col gap-1 w-full ">
                    <div class='flex relative justify-evenly items-center w-full mt-6 px-4 mb-5'>
                        <div>
                            <img src="../../images/qclogo.png" alt='logo' class='cursor-pointer w-full h-[50px]'/>
                        </div>
                       
                    </div>

                    <!--menu-->
                    <div class='border-t-[.01px] border-[#6b7280] w-full '>

    <div class='flex flex-col w-[93%] mx-2 mt-6 mb-8' id="sidebar-link">
        <a href="http://localhost/civil-registrar/pages/resident/residentDashboard.php" class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
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
            <a href='http://localhost/civil-registrar/pages/resident/birthRegistration.php' class="sidebar-link  flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                <h1 class='text-[13px] font-[600] pl-[2rem]'>Birth Certificate</h1>
            </a>
            <a href='http://localhost/civil-registrar/pages/resident/marriageRegistration.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                <h1 class='text-[13px] font-[600] pl-[2rem]'>Marriage Certificate</h1>
            </a>
            <a href='http://localhost/civil-registrar/pages/resident/deathRegistration.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                <h1 class='text-[13px] font-[600] pl-[2rem]'>Death Certificate</h1>
            </a>
            <a href='http://localhost/civil-registrar/pages/resident/multi.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                <h1 class='text-[13px] font-[600] pl-[2rem]'>Multi Certificate</h1>
            </a>
        </div>
        <a href='http://localhost/civil-registrar/pages/resident/verifyDocuments.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <div>
                <h1 class='font-[500]'>Verification </h1>
            </div>
        </a>

        <a href='http://localhost/civil-registrar/pages/resident/appointment.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <div>
                <h1 class='font-[500]'>Appointment </h1>
            </div>
        </a>
    </div>
    </div>
                </div>
            </div>

        <div class="bg-gray-200 md:w-[78%] w-full transform translate-x-0 transition-transform duration-300 ease-in-out mx-[1px] p-1 overflow-hidden overflow-y-scroll relative" id="contentpanel">
            <div class='bg-blue-600 box-shadow border-b-[1px] border-[#e1e0e4] dark:border-darkHeader border-solid rounded-[5px]' id='header'>
                <div class='flex p-3 justify-between items-center'>
                    <!-- Menu Icon -->
                    <div class='flex justify-start items-center'>
                        <button id='menuButton' class='hidden md:block text-[#6B737E] cursor-pointer hover:bg-slate-200 h-[35px] w-[35px] p-[5px] rounded-[50%]'>
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
                            <div id='notificationButton' class='relative w-[35px] h-[35px] text-[#93A3BC] font-semibold cursor-pointer hover:bg-slate-300 rounded-[50%] hover:bg-opacity-[.03] p-[7px]'>
                                <span class='w-[21px] h-[21px] font-semibold cursor-pointer'>
                                <i class="fas fa-bell" class="text-[22px] text-[#6B737E] cursor-pointer"></i>

                                </span>
                            </div>
                            <div id='notificationPanel' class='absolute bg-[#ffffff] right-[.5rem] w-[16.5rem] h-[16rem] mt-[12px] rounded-[15px] shadow-2xl z-[1000] hidden -bottom-[17rem]'>
                                <div class='flex justify-between items-center bg-[#5046e5] bg-cover rounded-t-[15px] p-[18px]'>
                                    <h1 class='text-[#fff] font-[600]'>Notifications</h1>
                                </div>
                                <div class='flex flex-col justify-center items-center w-full h-[12rem]'>
                                    <span class='w-[50px] h-[50px] text-[#93A3BC] font-semibold cursor-pointer bg-[#e1e7ff] rounded-[50%] p-4 mb-4'>
                                    <i class="fas fa-bell"></i>

                                    </span>
                                    <h1 class='text-[#2f3744] text-[16px]'>No notifications</h1>
                                    <p class='text-[12px] text-wrap text-center font-[400] text-[#324153]'>When you have notifications, they will appear here.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Profile -->
                        <div class='relative w-[35px] h-[35px] text-[#93A3BC] font-semibold cursor-pointer hover:bg-slate-300 rounded-[50%] hover:bg-opacity-[.03] p-[7px]' >

                         <!-- Dynamic Profile Image or Sign In Button -->
                         <div id="authDisplay"></div>
                            
                            

                            <div id='profilePanel' class='absolute bg-[#ffffff] right-[.5rem] w-[10rem] h-[10rem] mt-[12px] rounded-[5px] shadow-lg z-[1000] hidden'>
                                <div class='border-b-[.01px] border-[#e5e8eb] text-center'>
                                    <div class='p-2 my-[4px] w-full relative'>
                                        <p class='text-[14px] font-[400] text-[#324153]'>Signed in as</p>
                                        <p class='text-[12px] font-[400] text-[#324153]' id="email-display"></p>


                                    </div>
                                </div>
                                  <div class='border-b-[.01px] border-[#e5e8eb]'>
                                    <a href='http://localhost/civil-registrar/pages/resident/residentProfile.php' class='hover:bg-gray-900 hover:bg-opacity-[.12] cursor-pointer p-2 my-[4px] w-full flex justify-start items-center gap-4'>
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


              <!-- Voice Features -->

                     
    <div class="absolute bottom-8 right-8">
    <div id="voiceButton" class="bg-[#3448c5] w-[50px] h-[50px] hover:w-[60px] hover:h-[60px] transition duration-150 delay-150 ease-out cursor-pointer rounded-full flex justify-center items-center">
        <img src="../../images/voicelogo.png" alt="logo" class="w-[40px] h-[40px] rounded-full" id="voiceLogo" />
        <svg id="arrowDown" class="text-white text-[20px] hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <div id="voicePanel" class="absolute md:bottom-[6rem] md:right-[2.5rem] bottom-[6rem] right-[1rem] hidden">
        <div class="flex flex-col justify-start items-start gap-2 card md:h-[28rem] h-[10rem] md:w-[23rem] w-[17rem] h-[24rem] rounded-lg cardShadow p-4 relative">
            <div class="flex justify-center items-center gap-2 w-full">
                <img src="../../images/qclogo.png" alt='logo' class='cursor-pointer w-full h-[80px]' />
            </div>

             <!-- Username Section -->
             <div id="usernameSection" class="flex flex-col justify-start items-start w-full text-black text-[16px] mt-4 h-[200px] overflow-y-auto">
                <!-- Dynamic content will be injected here -->
            </div>

            <!-- Voice Script Section -->
            <div class="absolute bottom-0 left-0 right-0 bg-[#eae7e6] w-full h-auto rounded-br-lg rounded-bl-lg p-2">
                <div class="flex justify-evenly items-center w-full cursor-pointer gap-2">
                    <div id="homeButton" class="w-full h-auto flex justify-center items-center flex-col text-[#3448c5]" onclick="setMessage('homeButton')">
                        <i class="fas fa-smile w-[25px] h-[25px]"></i>
                        <p class="text-[12px]">Home</p>
                    </div>
                    <div id="voicesButton" class="w-full h-full flex justify-center items-center flex-col text-gray-600" onclick="setMessage('voicesButton')">
                        <i class="fas fa-volume-up w-[25px] h-[25px]"></i>
                        <p class="text-[12px]">Voices</p>
                    </div>
                    <div id="messagesButton" class="w-full h-full flex justify-center items-center flex-col text-gray-600" onclick="setMessage('messagesButton')">
                        <i class="fas fa-comment-dots w-[25px] h-[25px]"></i>
                        <p class="text-[12px]">Messages</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
    </div>




    
    

             
                

             <!--mobilesidebar-->

             <div class="absolute top-16 left-0 right-0 bg-blue-900 md:w-[22%] transform translate-x-0 transition-transform duration-300 ease-in mx-1 rounded-b-md hidden" id='mobilesidebarpanel'>
                <div class="flex flex-col gap-1 w-full ">
                    <div class='flex relative justify-evenly items-center w-full mt-6 px-4 mb-5'>
                        <div>
                            <img src="../../images/qclogo.png" alt='logo' class='cursor-pointer w-full h-[50px]'/>
                        </div>
                        
                    </div>

                    <!--menu-->
                    <div class='border-t-[.01px] border-[#6b7280] w-full '>

    <div class='flex flex-col w-[93%] mx-2 mt-6 mb-8' id="sidebar-link">
        <a href="http://localhost/civil-registrar/pages/resident/residentDashboard.php" class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
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
            <a href='http://localhost/civil-registrar/pages/resident/birthRegistration.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                <h1 class='text-[13px] font-[600] pl-[2rem]'>Birth Certificate</h1>
            </a>
            <a href='http://localhost/civil-registrar/pages/resident/marriageRegistration.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                <h1 class='text-[13px] font-[600] pl-[2rem]'>Marriage Certificate</h1>
            </a>
            <a href='http://localhost/civil-registrar/pages/resident/deathRegistration.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                <h1 class='text-[13px] font-[600] pl-[2rem]'>Death Certificate</h1>
            </a>
            <a href='http://localhost/civil-registrar/pages/resident/multi.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
                <h1 class='text-[13px] font-[600] pl-[2rem]'>Multi Certificate</h1>
            </a>
        </div>
        <a href='http://localhost/civil-registrar/pages/resident/verifyDocuments.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <div>
                <h1 class='font-[500]'>Verification </h1>
            </div>
        </a>

        <a href='http://localhost/civil-registrar/pages/resident/appointment.php' class="sidebar-link flex justify-start items-center mt-[.5rem] gap-4 p-2 dark:hover:bg-[#0314AA] rounded-md hover:bg-gray-100 hover:bg-opacity-[.12] px-5 text-[#9ca3af] hover:text-[#fff]">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-[25px] h-[25px]">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <div>
                <h1 class='font-[500]'>Appointment Schedule</h1>
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

let openVoice = false;
let recognition;

// Function to handle voice button click
document.getElementById('voiceButton').onclick = function() {
    openVoice = !openVoice; // Toggle state
    document.getElementById('voicePanel').classList.toggle('hidden', !openVoice); // Show or hide the panel
    document.getElementById('arrowDown').classList.toggle('hidden', !openVoice); // Show/hide the arrow
    document.getElementById('voiceLogo').classList.toggle('hidden', openVoice); // Show/hide the logo
    setActiveState('homeButton'); // Set default active state to Home
    setVoiceButtonColor(); // Set the voice button color
};

// Initialize SpeechRecognition
function initializeSpeechRecognition() {
    if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
        recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.interimResults = true;
        recognition.lang = 'en-US';

        // Handle results
        recognition.onresult = function(event) {
            const transcript = Array.from(event.results)
                .map(result => result[0].transcript)
                .join('');
            document.getElementById('transcript').textContent = transcript; // Display transcript
            processVoiceCommand(transcript.trim().toLowerCase()); // Process the command
        };

        // Handle errors
        recognition.onerror = function(event) {
            console.error('Speech recognition error:', event.error);
        };
    } else {
        console.error('Speech Recognition API not supported in this browser.');
    }
}

// Call initializeSpeechRecognition when the document is loaded
document.addEventListener('DOMContentLoaded', function() {
    setMessage('homeButton'); // Sets default view to Home
    initializeSpeechRecognition(); // Initialize speech recognition
});

// Process voice commands
function processVoiceCommand(command) {
    let reply = ''; // Default empty reply

    if (command.includes("ml")) {
        reply = 'Hello! How can I assist you today?';
        speak(reply);
    } else if (command.includes("home")) {
        reply = 'Navigating to Home.';
        speak(reply);
        setMessage('homeButton');
    } else if (command.includes("show voices")) {
        reply = 'Displaying available voices.';
        speak(reply);
    } else if (command.includes("log out")) {
        reply = 'Logging out.';
        speak('Logging out.');
        // Call your logout function here
        logout();
        setMessage('voicesButton');
    } else if (command.includes("open messages")) {
        reply = 'Opening messages section.';
        speak(reply);
        setMessage('messagesButton');
    }

    // Display the reply in the transcript or response section
    if (reply) {
        document.getElementById('transcript').textContent = reply;
    }
}

// Display content based on active section
function setMessage(activeButton = 'homeButton') {
    const messageSection = document.getElementById('usernameSection');
    messageSection.innerHTML = ''; // Clear previous content
    const username = localStorage.getItem('name');

    if (activeButton === 'messagesButton') {
        messageSection.innerHTML = `
            <h1 class="text-white">Hi <span>${username} 👋</span></h1>
            <div class="voicescript bg-white rounded-md text-black p-2 cursor-pointer text-justify mt-1 overflow-y-auto">
                <p>This is a message section. You can write messages here.</p>
            </div>`;
        setActiveState('messagesButton');
    } else if (activeButton === 'voicesButton') {
        messageSection.innerHTML = `
            <h1 class="text-white" >Voices Available</h1>
            <div class="voicescript bg-white rounded-md text-black p-2 cursor-pointer text-justify mt-1 overflow-y-auto">
                <p>Here you can explore different voice options and settings.</p>
                <p>Use the dropdown menu to select a voice.(ml,open messages,log out,show voices,home)</p>
                <button id="startRecognition" class="mt-2 bg-green-500 text-white p-2 rounded">Start Listening</button>
                <button id="stopRecognition" class="mt-2 bg-red-500 text-white p-2 rounded hidden">Stop Listening</button>
                <div id="transcript" class="mt-2 p-2 bg-gray-100 rounded"></div>
            </div>`;
        setActiveState('voicesButton');

        // Start recognition when the button is clicked
        document.getElementById('startRecognition').onclick = function() {
            recognition.start();
            this.classList.add('hidden');
            document.getElementById('stopRecognition').classList.remove('hidden');
        };

        // Stop recognition
        document.getElementById('stopRecognition').onclick = function() {
            recognition.stop();
            this.classList.add('hidden');
            document.getElementById('startRecognition').classList.remove('hidden');
        };
    } else {
        messageSection.innerHTML = `
            <h1 class="text-white">Welcome Back!</h1>
            <div class="voicescript bg-white rounded-md text-black p-2 cursor-pointer text-justify mt-1 overflow-y-auto">
                <p>This is Home section. You can write messages here.</p>
            </div>`;
        setActiveState('homeButton');
    }
}

// Function to set the active state of the buttons
function setActiveState(activeId) {
    const buttons = ['homeButton', 'voicesButton', 'messagesButton'];
    buttons.forEach(id => {
        const button = document.getElementById(id);
        if (id === activeId) {
            button.classList.add('text-[#3448c5]'); // Active color
            button.classList.remove('text-gray-600'); // Remove inactive color
        } else {
            button.classList.remove('text-[#3448c5]'); // Remove active color
            button.classList.add('text-gray-600'); // Inactive color
        }
    });
}

// Function to set the voice button color
function setVoiceButtonColor() {
    const voiceButton = document.getElementById('voiceButton');
    voiceButton.classList.toggle('bg-red-600', openVoice); // Change to red if voice panel is open
    voiceButton.classList.toggle('bg-[#3448c5]', !openVoice); // Revert to original color if closed
}

// Close the voice panel when clicking outside of it
document.addEventListener('click', function(event) {
    const voiceButton = document.getElementById('voiceButton');
    const voicePanel = document.getElementById('voicePanel');

    // Check if the click was outside the voice button and the voice panel
    if (openVoice && !voiceButton.contains(event.target) && !voicePanel.contains(event.target)) {
        openVoice = false; // Set the open state to false
        voicePanel.classList.add('hidden'); // Hide the voice panel
        document.getElementById('arrowDown').classList.add('hidden'); // Hide the arrow
        document.getElementById('voiceLogo').classList.remove('hidden'); // Show the logo
        setVoiceButtonColor(); // Set the voice button color
    }
});

// Function to speak responses
function speak(text) {
    const utterance = new SpeechSynthesisUtterance(text);
    window.speechSynthesis.speak(utterance);
}
  
 


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
    

        
    const modal = document.getElementById("mobilesidebarpanel");
    const openModalButton = document.getElementById("mobilemenuButton");


    document.addEventListener("DOMContentLoaded", function () {
        const authDisplay = document.getElementById('authDisplay');
        const profileImage = localStorage.getItem('profileImage'); // Base64 image stored, or null

        if (profileImage) {
            // User is authenticated, show profile image from localStorage
            authDisplay.innerHTML = `<img src="${profileImage}" alt="Profile" class='w-[21px] h-[21px] font-semibold cursor-pointer rounded-[100%]' id='profileButton'/>`;
        }
    });

    // Function to toggle modal visibility
    const toggleModal = () => {
      modal.classList.toggle("hidden");
    };

    // Open/Close modal on button click
    openModalButton.addEventListener("click", toggleModal);

    
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
                }
                if (!event.target.closest('#mobilemenuButton') && !event.target.closest('#mobilesidebarpanel')) {
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




    </script>
    </body>
    </html>
    <?php
}
?>
