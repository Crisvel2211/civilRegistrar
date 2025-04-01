<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="icon" href="images/qcfavicon.svg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Custom Styles */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #4b5563;
        }

        .section-heading {
            color: #191f8a;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .section-subheading {
            color: #4b5563;
            font-size: 1.125rem;
            margin-top: 0.5rem;
        }

        .section-content {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            height: 550px;
        }
        

        .card-title {
            color: #191f8a;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .card-text {
            color: #6b7280;
            font-size: 1.125rem;
            margin-bottom: 1rem;
        }

        .card-text:last-child {
            margin-bottom: 0;
        }

        .list-items {
            list-style-type: disc;
            margin-left: 1.5rem;
            color: #6b7280;
            font-size: 1.125rem;
            line-height: 1.8;
        }

        .list-items li {
            margin-bottom: 0.5rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer {
            background-color: #191f8a;
            color: #fff;
            padding: 1.5rem 0;
            text-align: center;
        }

        @media (max-width: 768px) {
            .section-heading {
                font-size: 2rem;
            }

            .section-subheading {
                font-size: 1rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .card-text {
                font-size: 1rem;
            }
        }
    </style>

</head>
<body>

    <div class="min-h-screen flex flex-col">
        <!-- Navbar Section -->
        <?php include './layout/navbar.php'; ?>

        <!-- About Us Content -->
        <section class="container mx-auto my-16 px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-extrabold text-gray-800 text-center mb-5">About Us</h2>
                <p class="text-lg text-gray-600 text-center mb-6">
                    Explore the Comprehensive Services We Offer to Meet Your Civil Registration Needs.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="section-content bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="card-title">Our Mission</h3>
                    <p class="card-text">
                        Our mission is to provide essential civil registration services that support individuals and families through life's major milestones. We make registration for births, marriages, and deaths efficient, secure, and seamless.
                    </p>
                    <p class="card-text">
                        With a focus on customer-centric service, we are committed to simplifying legal documentation processes and ensuring every client’s needs are met with professionalism and care.
                    </p>
                </div>

                <div class="section-content bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="card-title">Our Vision</h3>
                    <p class="card-text">
                        Our vision is to be the most reliable and accessible provider of civil registration services, offering both traditional and digital solutions to ensure a smooth experience for our clients.
                    </p>
                    <p class="card-text">
                        We aim to blend technology with customer service to create an accessible, fast, and secure process for all our clients, bringing the future of civil registration to life.
                    </p>
                </div>

                <div class="section-content bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="card-title">Why Choose Us?</h3>
                    <ul class="list-items">
                        <li>Comprehensive Civil Registration Services (Birth, Marriage, Death Certificates).</li>
                        <li>Easy-to-use, fully online registration platform for convenience.</li>
                        <li>Secure and transparent processes with real-time status updates.</li>
                        <li>Expert team committed to providing personalized customer support.</li>
                        <li>Fast processing times to ensure timely and accurate document issuance.</li>
                        <li>Seamless integration of digital technologies to enhance service delivery.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Footer Section -->
        <?php include './layout/footer.php'; ?>
    </div>

</body>
</html>