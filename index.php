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
            <div class="swiper-pagination"></div>
        </div>

        <div class="container mx-auto h-auto md:mt-10 mt-1 md:mb-10 mb-3">
        <div class="flex flex-col justify-start items-start gap-10 px-2 md:px-0">
            <div>
                <h1 class="font-[600] text-[25px] md:text-[30px] md:leading-[40px] leading-[32px] md:mt-10 mt-4 md:mb-4 mb-1">
                    Discover Civil Registration <br />Insights
                </h1>
                <p>Stay informed with our latest articles and resources.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 -mt-6 md:-mt-0">
                <?php foreach ($cardArray as $card): ?>
                    <div class="cursor-pointer bg-gray-300 p-2 rounded-sm">
                        <img src="<?php echo htmlspecialchars($card['image']); ?>" alt="image" class="rounded-sm"/>
                        <h2 class="font-[600]"><?php echo htmlspecialchars($card['title']); ?></h2>
                        <p class="text-[13px]"><?php echo htmlspecialchars($card['description']); ?></p>
                        <div class="flex justify-start items-start gap-2 mt-4">
                            <img src="<?php echo htmlspecialchars($card['userPic']); ?>" alt="user" class="w-5 h-5 rounded-[100%]"/>
                            <div>
                                <p class="text-[11px] font-[500]"><?php echo htmlspecialchars($card['user']); ?></p>
                                <div class="flex justify-center items-center gap-3">
                                    <p class="text-[10px]"><?php echo htmlspecialchars($card['date']); ?></p>
                                    <p class="text-[8px]"><?php echo htmlspecialchars($card['time']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
      </div>

      <div class='container mx-auto h-auto md:mt-10 mt-3 md:mb-[8rem] mb-[3rem]'>
        <div class="w-full grid md:grid-cols-2 grid-cols-1  h-auto md:mt-[8rem] mt-[4rem] px-2 md:px-0">
            <div class="flex justify-center items-center">
               <div class="w-full h-auto flex md:justify-start md:items-start justify-center items-center ">
                <img src='images/content2.jpg' alt='images' class=' md:w-[90%] w-full md:h-[355px] h-[270px] rounded-sm'/>
               </div>
            </div>

            <div class="flex flex-col justify-center items-start">
                <h1 class="font-[900] md:text-[30px] text-[25px] md:leading-[40px] leading-[32px] mb-3 pt-6 text-center md:text-start md:pt-0">Welcome to the Local Civil<br />Registrar System - Simplifying Registration, Verification, and Issuance</h1>
                <p class="text-[15px] text-justify">Our system streamlines the process of registering, verifying, and issuing certificates, making it quick and convenient for individuals and organizations.</p>
                <div class="flex justify-center items-center gap-10 mt-6">

                    <div class="flex flex-col justify-center items-center bg-secondary dark:bg-darksecondary text-text dark:text-darktext shadow-md py-10 rounded-sm cursor-pointer">
                       <div class="flex justify-center items-center">
                         <MdAppRegistration class="text-[18px]99"/>
                        </div>
                        <h1 class="font-[700] text-[16px] mb-2 text-center">Efficient Registration</h1>
                        <p class="text-[13px] leading-4 text-center">Register births, marriages, and deaths with ease, ensuring accurate and reliable records.</p>

                    </div>

                    <div class="flex flex-col justify-center items-center bg-secondary dark:bg-darksecondary text-text dark:text-darktext shadow-md py-10 rounded-sm cursor-pointer">

                        <div class="flex justify-center items-center">
                         <FaUserLock class="text-[18px] "/>
                        </div>
                        
                       
                        <h1 class="font-[700] text-[16px] mb-2 text-center">Secure Verification</h1>
                        <p class="text-[13px] leading-4 text-center">Verify the authenticity of certificates quickly and securely, preventing fraud and misuse.</p>

                    </div>
                </div>
                               
            </div>


           
            
        </div>

    </div>

      <div class='container mx-auto h-auto md:mt-10 mt-1 mb-10 '>
       <div class="grid grid-cols-1 md:grid-cols-3 place-items-center gap-10 px-2 md:px-0"> 
          <div class="md:col-span-3 col-span-1">
            <h1 class="font-[900] text-[30px] leading-[40px] mb-3 text-center hidden md:block">Register, Verify, and Request Certificates <br/>with Ease</h1>

            <h1 class="font-[900] text-[25px] leading-[32px] mb-3 text-center md:hidden">Register, Verify, and Request Certificates with Ease</h1>

          </div>

          <div class="p-6 rounded-md bg-secondary dark:bg-darksecondary shadow-md cursor-pointer w-full h-[260px] text-text dark:text-darktext">
            <div class="flex justify-center items-center mb-4">
             <MdAppRegistration class="text-[18px]"/>
            </div>
            <div class="flex flex-col justify-center items-center">
              <h2 class="font-[700] text-center mb-3">Simple and Efficient Certificate  <br/>Management</h2>
            </div>
            <div>
              <p class="text-justify text-[14px]">Our Local Civil Registrar System provides a step-by-step guide on how to register, verify, and request the issuance of certificates. With our user-friendly interface, you can easily navigate through the process and complete your tasks hassle-free.</p>
              <div class="flex justify-center items-center gap-1 mt-2 text-[13px]">
                <button class="">Request</button>
                <MdKeyboardArrowRight/>
              </div>
            </div>

          </div>

          

          <div class="p-6 rounded-md bg-secondary dark:bg-darksecondary shadow-md cursor-pointer w-full h-[260px] text-text dark:text-darktext">
            <div class="flex justify-center items-center mb-4">
             <FaUserLock  class="text-[18px]"/>
            </div>
            <div class="flex flex-col justify-center items-center">
              <h2 class="font-[700] text-center mb-3">Fast and Reliable Certificate<br/>Verification</h2>
            </div>
            <div>
              <p class="text-justify text-[14px]">With our advanced verification system, you can quickly validate the authenticity of certificates. Say goodbye to manual verification processes and enjoy the convenience of our automated solution.</p>
              <div class="flex justify-center items-center gap-1 mt-2 text-[13px]">
                <button class="">Verify</button>
                <MdKeyboardArrowRight/>
              </div>
            </div>

          </div>
         
          <div class="p-6 rounded-md bg-secondary dark:bg-darksecondary shadow-md cursor-pointer w-full h-[260px] text-text dark:text-darktext">
            <div class="flex justify-center items-center mb-4">
             <MdAppRegistration class="text-[18px]"/>
            </div>
            <div class="flex flex-col justify-center items-center">
              <h2 class="font-[700] text-center mb-3">Creating Certificates and Issuing <br/>them is an easy task.</h2>
            </div>
            <div>
              <p class="text-justify text-[14px]">Requesting certificates has never been easier. Our system streamlines the issuance process, ensuring that you receive your certificates promptly. Experience hassle-free certificate management today.</p>
              <div class="flex justify-center items-center gap-1 mt-2 text-[13px]">
                <button class="">Request</button>
                <MdKeyboardArrowRight/>
              </div>
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
