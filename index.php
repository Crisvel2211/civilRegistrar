<?php
// Example data for the slides
$slides = [
    [
        'heading' => 'Streamlining Civil Registration for a Better Future',
        'text' => 'Welcome to the Local Civil Registrar System, where we simplify the process of registration, verification, and issuance of certificates. Our user-friendly platform ensures a hassle-free experience for all.',
        'image' => 'images/content2.jpg',
    ],
    [
        'heading' => 'Simplified and Hassle-free Process',
        'text' => 'Our platform makes it easier than ever to manage civil registration tasks. Whether you are registering for a birth, marriage, or any other certificate, we’ve got you covered.',
        'image' => 'images/content2.jpg',
    ],
    [
        'heading' => 'Secure and Reliable Services',
        'text' => 'We prioritize the security of your personal information, offering a reliable and trustworthy service to meet all your civil registration needs.',
        'image' => 'images/content2.jpg',
    ]
];
?>

<?php 
$cardArray = [
    [
        'image' => 'images/content1.jpg',
        'title' => 'Card Title 1',
        'description' => 'Card description 1',
        'userPic' => 'images/content2.jpg',
        'user' => 'User 1',
        'date' => '2024-09-26',
        'time' => '10:00 AM'
    ],
    [
        'image' => 'images/content1.jpg',
        'title' => 'Card Title 1',
        'description' => 'Card description 1',
        'userPic' => 'images/content2.jpg',
        'user' => 'User 1',
        'date' => '2024-09-26',
        'time' => '10:00 AM'
    ],
    [
        'image' => 'images/content1.jpg',
        'title' => 'Card Title 3',
        'description' => 'Card description 3',
        'userPic' => 'images/content2.jpg',
        'user' => 'User 3',
        'date' => '2024-09-24',
        'time' => '12:00 PM'
    ],
    [
        'image' => 'images/content1.jpg',
        'title' => 'Card Title 4',
        'description' => 'Card description 4',
        'userPic' => 'images/content2.jpg',
        'user' => 'User 4',
        'date' => '2024-09-23',
        'time' => '01:00 PM'
    ]
];
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Civil Registrar</title>
    <link rel="icon" href="images/qcfavicon.svg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    
    <style>
        body {
            overflow-x: hidden;
        }

        .swiper-container {
            width: 100%;
        }

        .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100vw;
        }

        .swiper-pagination-bullet {
            background-color: #000;
            opacity: 0.6;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="h-auto w-full">
        <?php include './layout/navbar.php'; ?>

        <!-- Slider Section -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($slides as $slide): ?>
                    <div class="swiper-slide">
                        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 h-auto mt-4 px-2 md:px-0">
                            <div class="flex flex-col justify-center items-start p-5">
                                <h1 class="font-[900] md:text-[45px] text-[30px] md:leading-[46px] leading-[32px] mb-3">
                                    <?php echo htmlspecialchars($slide['heading']); ?>
                                </h1>
                                <p class="text-[16px]"><?php echo htmlspecialchars($slide['text']); ?></p>
                                <div class="flex justify-center md:justify-start items-center gap-3 mt-6">
                                    <button class="p-2 bg-blue-600 rounded-sm text-white">Get Started</button>
                                    <button class="p-2 border border-gray-500 rounded-sm">Learn More</button>
                                </div>
                            </div>
                            <div class="flex justify-center items-center p-5">
                                <div class="w-full md:h-[430px] h-[400px] flex justify-center items-center">
                                    <img src="<?php echo htmlspecialchars($slide['image']); ?>" alt="Slide Image" class="md:w-[90%] w-full h-[290px] md:h-[400px] rounded-sm"/>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination "></div>
        </div>



      <div class='container mx-auto h-auto md:mt-[18rem] mt-10 md:mb-10 mb-3'>
        <div class="w-full grid md:grid-cols-2 grid-cols-1  h-auto md:mt-[8rem] mt-[4rem] px-2 md:px-0">
            <div class="flex justify-center items-center order-last md:order-first p-4">
               <div class="w-full h-auto flex md:justify-start md:items-start justify-center items-center ">
                <img src='images/content2.jpg' alt='images' class=' md:w-[90%] w-full md:h-[355px] h-[270px] rounded-sm'/>
               </div>
            </div>

            <div class="flex flex-col justify-center items-start order-first md:order-last p-4">
                <h1 class="font-[900] md:text-[30px] text-[25px] md:leading-[40px] leading-[32px] mb-3 pt-6 text-center md:text-start md:pt-0">Welcome to the E-Local Civil<br />Registrar System - Simplifying Registration, Verification, and Issuance</h1>
                <p class="text-[15px] text-justify">Our system streamlines the process of registering, verifying, and issuing certificates, making it quick and convenient for individuals and organizations.</p>
                <div class="flex justify-center items-center gap-10 mt-6">

                    <div class="flex flex-col justify-center items-center bg-gray-200 text-text dark:text-darktext shadow-md py-10 rounded-sm cursor-pointer">
                    <div class="flex justify-center items-center mb-2">
                        <i class="fas fa-registered text-[24px] text-blue-600"></i>
                    </div>
                        <h1 class="font-[700] text-[16px] mb-2 text-center">Efficient Registration</h1>
                        <p class="text-[13px] leading-4 text-center">Register births, marriages, and deaths with ease, ensuring accurate and reliable records.</p>

                    </div>

                    <div class="flex flex-col justify-center items-center bg-gray-200 text-text dark:text-darktext shadow-md py-10 rounded-sm cursor-pointer">

                    <div class="flex justify-center items-center mb-2">
                        <i class="fas fa-user-lock text-[24px] text-green-600"></i>
                    </div>
                        
                       
                        <h1 class="font-[700] text-[16px] mb-2 text-center">Secure Verification</h1>
                        <p class="text-[13px] leading-4 text-center">Verify the authenticity of certificates quickly and securely, preventing fraud and misuse.</p>

                    </div>
                </div>
                               
            </div>


           
            
        </div>

    </div>

    <div class="container mx-auto h-auto md:mt-[6rem] md:mb-[6rem] mt-10  mb-3">
    <div class="flex flex-col justify-start items-start gap-10 px-2 md:px-0">
        <div class="flex flex-col justify-center items-center text-center mx-auto mb-10">
            <h1 class="font-[900] md:text-[30px] text-[25px] md:leading-[40px] leading-[32px] mb-3 pt-6 text-center md:text-start md:pt-0">
                Discover Our Civil Registration Services
            </h1>
            <p class="text-[15px] text-justify">Explore the key services we offer to simplify your civil registration needs.</p>
        </div>

        <!-- Service Cards Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 md:gap-10 -mt-6 md:-mt-0">
            <!-- Card 1 -->
            <div class="cursor-pointer bg-gray-200 p-5 rounded-sm shadow-md hover:shadow-lg transition duration-300 ease-in-out">
                <div class="flex justify-center items-center mb-4">
                    <i class="fas fa-registered text-[24px] text-blue-600"></i>
                </div>
                <h2 class="font-[600] text-xl text-center mb-3">Efficient Birth Registration</h2>
                <p class="text-justify text-[14px] mb-5">Our registrar system guides you through registering and requesting certificates with ease. Navigate the process seamlessly, ensuring tasks are completed without stress, supported by a clear, user-friendly interface for efficient results.</p>
                <button class="w-full py-2 bg-blue-600 text-white rounded-sm">Learn More</button>
            </div>

            <!-- Card 2 -->
            <div class="cursor-pointer bg-gray-200 p-5 rounded-sm shadow-md hover:shadow-lg transition duration-300 ease-in-out">
                <div class="flex justify-center items-center mb-4">
                    <i class="fas fa-user-lock text-[24px] text-green-600"></i>
                </div>
                <h2 class="font-[600] text-xl text-center mb-3">Secure Certificate Verification</h2>
                <p class="text-justify text-[14px] mb-5">Verify certificate authenticity swiftly with our automated system, eliminating manual steps and ensuring reliable validation. Enjoy the benefits of a streamlined, accurate process tailored for convenience and peace of mind.</p>
                <button class="w-full py-2 bg-green-600 text-white rounded-sm">Verify Now</button>
            </div>

            <!-- Card 3 -->
            <div class="cursor-pointer bg-gray-200 p-5 rounded-sm shadow-md hover:shadow-lg transition duration-300 ease-in-out">
                <div class="flex justify-center items-center mb-4">
                    <i class="fas fa-user-plus text-[24px] text-yellow-600"></i>
                </div>
                <h2 class="font-[600] text-xl text-center mb-3">Simple Certificate Requests</h2>
                <p class="text-justify text-[14px] mb-5">Easily request certificates with our streamlined system, which simplifies the process and ensures prompt issuance. Manage your requests seamlessly and experience smooth, hassle-free certificate handling for peace of mind.</p>
                <button class="w-full py-2 bg-yellow-600 text-white rounded-sm">Request Certificate</button>
            </div>
        </div>
    </div>
</div>


        <?php include './layout/footer.php'; ?>
    </div>

    <!-- Swiper JS Initialization -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 10,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            loop: true, // Adds looping for continuous slides
        });
    </script>
</body>
</html>
