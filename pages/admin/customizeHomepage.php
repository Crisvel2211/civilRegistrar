<?php
// Include the layout file
include '../../layout/admin/adminLayout.php';

// Define the content for the home page
$homeContent = "
<div class='container mx-auto w-full md:mt-1 px-[8px] h-[88vh] overflow-y-scroll'>
 <div class='container mx-auto'>
    <div class='flex justify-start items-center gap-[10px] w-full h-auto mt-2 '>
        <i class='fas fa-tasks text-[#93A3BC] text-[25px]'></i>
        <h1 class='font-bold text-gray-700 text-[21px]'>Homepage crud</h1>
    </div>

    

</div>
</div>
";

// Call the layout function with the home page content
adminLayout($homeContent);
?>

