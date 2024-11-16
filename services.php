<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Civil Registrar Services</title>
    <link rel="icon" href="images/qcfavicon.svg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <style>

         body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #4b5563;
        }
        /* Custom styles */
        .card-wrapper:hover {
            border: 2px solid #4F46E5; /* Indigo border on hover */
            border-radius: 0.75rem; /* Rounded corners */
            transition: border 0.3s ease-in-out;
        }

        .card:hover .card-img {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.3s ease-in-out;
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card .p-5 {
            flex-grow: 1; /* Allow description to take up remaining space */
        }

        .card-img {
            object-fit: cover;
        }

        .card-description {
            min-height: 140px; /* Ensure all descriptions have a minimum height */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Ensures description texts are spaced nicely */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <?php include './layout/navbar.php'; ?>

        <div class="container mx-auto my-12 px-6">
            <h2 class="text-4xl font-extrabold text-gray-800 text-center mb-5">Our Services</h2>
            <p class="text-lg text-gray-600 text-center mb-6">
                Essential civil registrar services for birth, marriage, and death documentation.
            </p>


            

            <div class="grid gap-10 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                <!-- Birth Registration -->
                <div class="card-wrapper p-2">
                    <div class="card flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="overflow-hidden rounded-t-lg">
                            <img src="./images/announcement.jpg" alt="Birth Registration" class="card-img w-full h-52 object-cover">
                        </div>
                        <div class="p-5 card-description">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-3">Birth Registration</h3>
                            <p class="text-gray-600">Register your newborn quickly and efficiently with our simple process. We ensure that all necessary documents are submitted, verified, and a birth certificate is issued, making sure your child’s legal recognition is completed seamlessly and securely.</p>
                        </div>
                    </div>
                </div>

                <!-- Marriage Registration -->
                <div class="card-wrapper p-2">
                    <div class="card flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="overflow-hidden rounded-t-lg">
                            <img src="./images/announcement.jpg" alt="Marriage Registration" class="card-img w-full h-52 object-cover">
                        </div>
                        <div class="p-5 card-description">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-3">Marriage Registration</h3>
                            <p class="text-gray-600">Simplify your marriage registration process with our professional service. We handle all paperwork and verification steps efficiently, ensuring your marriage is legally documented, allowing you to move forward with your new life together with confidence.</p>
                        </div>
                    </div>
                </div>

                <!-- Death Registration -->
                <div class="card-wrapper p-2">
                    <div class="card flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="overflow-hidden rounded-t-lg">
                            <img src="./images/announcement.jpg" alt="Death Registration" class="card-img w-full h-52 object-cover">
                        </div>
                        <div class="p-5 card-description">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-3">Death Registration</h3>
                            <p class="text-gray-600">Our death registration service provides the necessary legal documentation following the loss of a loved one. We ensure that the death certificate and related paperwork are processed promptly, with care and respect, to handle this sensitive time efficiently.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include './layout/footer.php'; ?>
    </div>
</body>
</html>
