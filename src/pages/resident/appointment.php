<?php
// Include the layout file
include '../../layout/resident/residentLayout.php';

$updateProfileContent = "
    <div class='min-h-screen'>
        <div class='container mx-auto p-6'>
            <div class='mb-8'>
                <h1 class='text-3xl font-bold text-center'>Civil Registrar Appointment Schedule</h1>
            </div>
            
            <div class='grid grid-cols-3 gap-6'>
                <!-- Card 1: Birth Registration -->
                <div class='bg-blue-500 text-white rounded-md shadow-lg p-4 flex flex-col'>
                    <h2 class='text-xl font-semibold mb-2'>Birth Registration</h2>  
                    <div class='flex justify-between'>
                        <p class='font-medium'>Time:</p>
                        <p>09:00 AM</p>
                    </div>
                    <div class='flex justify-between'>
                        <p class='font-medium'>Date:</p>
                        <p>2024-10-01</p>
                    </div> 
                    <div class='mt-2'>
                        <p class='font-medium'>Purpose of Appointment:</p>
                        <p>Register a newborn's birth certificate.</p>
                    </div>
                    <div class='mt-2'>
                        <p class='font-medium'>Requirements:</p>
                        <img src='../../../images/content1.jpg' alt='Birth Registration Requirements' class='w-full h-24 object-cover rounded-md mt-1'>
                    </div>
                </div>

                <!-- Card 2: Death Registration -->
                <div class='bg-green-500 text-white rounded-md shadow-lg p-4 flex flex-col'>
                    <h2 class='text-xl font-semibold mb-2'>Death Registration</h2>  
                    <div class='flex justify-between'>
                        <p class='font-medium'>Time:</p>
                        <p>10:30 AM</p>
                    </div>
                    <div class='flex justify-between'>
                        <p class='font-medium'>Date:</p>
                        <p>2024-10-02</p>
                    </div> 
                    <div class='mt-2'>
                        <p class='font-medium'>Purpose of Appointment:</p>
                        <p>Register a death certificate.</p>
                    </div>
                    <div class='mt-2'>
                        <p class='font-medium'>Requirements:</p>
                        <img src='../../../images/content1.jpg' alt='Death Registration Requirements' class='w-full h-24 object-cover rounded-md mt-1'>
                    </div>
                </div>

                <!-- Card 3: Marriage Registration -->
                <div class='bg-purple-500 text-white rounded-md shadow-lg p-4 flex flex-col'>
                    <h2 class='text-xl font-semibold mb-2'>Marriage Registration</h2>  
                    <div class='flex justify-between'>
                        <p class='font-medium'>Time:</p>
                        <p>01:00 PM</p>
                    </div>
                    <div class='flex justify-between'>
                        <p class='font-medium'>Date:</p>
                        <p>2024-10-03</p>
                    </div> 
                    <div class='mt-2'>
                        <p class='font-medium'>Purpose of Appointment:</p>
                        <p>Register a marriage certificate.</p>
                    </div>
                    <div class='mt-2'>
                        <p class='font-medium'>Requirements:</p>
                        <img src='../../../images/content1.jpg' alt='Marriage Registration Requirements' class='w-full h-24 object-cover rounded-md mt-1'>
                    </div>
                </div>
            </div>
        </div>
    </div>
";

residentLayout($updateProfileContent);
?>
