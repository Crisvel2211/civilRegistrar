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
            height: 100%;
        }

        .card .p-5 {
            flex-grow: 1;
        }

        .card-img {
            object-fit: cover;
            height: 200px;
            width: 100%;
        }

        .price-tag {
            font-size: 1.125rem;
            color: #16a34a;
            font-weight: 600;
        }

        .dropdown {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 250px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 8px;
            overflow: hidden;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-item {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            color: #333;
            cursor: pointer;
            transition: background-color 0.3s;
            border-bottom: 1px solid #e5e7eb;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
        }

        .dropdown-button {
            width: 100%;
            text-align: left;
            padding: 12px;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            color: #333;
            cursor: pointer;
            transition: all 0.3s;
        }

        .dropdown-button:hover {
            background-color: #f3f4f6;
        }

        /* Hover effect to display details */
        .service-item:hover .service-details {
            display: block;
        }

        .service-details {
            display: none;
            padding: 10px;
            background-color: #f3f4f6;
            border-radius: 8px;
            margin-top: 5px;
            font-size: 0.95rem;
            color: #555;
        }
        .service-item {
    border: 1px solid transparent; /* Initially no border */
    transition: all 0.3s ease-in-out; /* Smooth transition for color and border */
}


.service-item:hover .service-name {
    color: #4F46E5; /* Change text color on hover */
    transition: color 0.3s ease-in-out;
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
                <?php
                $services = [
                    [
                        'title' => 'Birth Registration Services',
                        'image' => './images/announcement.jpg',
                        'items' => [
                            ['name' => 'Registration of Regular and Timely Certificate of Live Birth', 'price' => '₱1,500', 'details' => 'Regular registration for certificates completed on time.'],
                            ['name' => 'Registration of Regular and Timely Certificate of Live Birth via QC Birth Registration Online', 'price' => '₱1,800', 'details' => 'Online registration for regular certificates.'],
                            ['name' => 'Delayed Registration of Certificate of Live Birth', 'price' => '₱2,000', 'details' => 'Late registration of birth certificates.'],
                            ['name' => 'Delayed Registration of Certificate of Live Birth via QC Birth Registration Online', 'price' => '₱2,300', 'details' => 'Online delayed registration for birth certificates.']
                        ]
                    ],
                    [
                        'title' => 'Marriage Registration Services',
                        'image' => './images/announcement.jpg',
                        'items' => [
                            ['name' => 'Application and Issuance of Marriage License', 'price' => '₱2,500', 'details' => 'Application for a marriage license and its issuance.'],
                            ['name' => 'Registration of Regular and Timely Certificate of Marriage', 'price' => '₱1,800', 'details' => 'Marriage certificate registration for regular and timely submissions.'],
                            ['name' => 'Delayed Registration of Certificate of Marriage', 'price' => '₱2,200', 'details' => 'Late registration of marriage certificates.']
                        ]
                    ],
                    [
                        'title' => 'Death Registration Services',
                        'image' => './images/announcement.jpg',
                        'items' => [
                            ['name' => 'Registration of Regular and Timely Certificate of Death', 'price' => '₱1,500', 'details' => 'Death certificate registration for timely submissions.'],
                            ['name' => 'Delayed Registration of Certificate of Death', 'price' => '₱2,000', 'details' => 'Late registration of death certificates.'],
                            ['name' => 'Request for Exhumation Permit', 'price' => '₱2,500', 'details' => 'Request for permit to exhume remains.'],
                            ['name' => 'Request for Burial Permit', 'price' => '₱1,200', 'details' => 'Request for a permit to bury deceased.'],
                            ['name' => 'Request for Cremation Permit', 'price' => '₱2,500', 'details' => 'Request for a cremation permit.'],
                            ['name' => 'Cremation Service', 'price' => '₱10,000', 'details' => 'Service for cremating the deceased.']
                        ]
                    ],
                    [
                        'title' => 'Issuance of Civil Registry Documents',
                        'image' => './images/announcement.jpg',
                        'items' => [
                            ['name' => 'Request and Issuance of Certified True Copy of Birth Certificate', 'price' => '₱300', 'details' => 'Request and issuance of certified true copy of birth certificate.'],
                            ['name' => 'Request and Issuance of Certified True Copy of Marriage Certificate', 'price' => '₱300', 'details' => 'Request and issuance of certified true copy of marriage certificate.'],
                            ['name' => 'Request and Issuance of Certified True Copy of Death Certificate', 'price' => '₱300', 'details' => 'Request and issuance of certified true copy of death certificate.'],
                            ['name' => 'Request and Issuance of Certified True Copy of Birth, Marriage, and Death Certificate via Civil Registry Online Services', 'price' => '₱500', 'details' => 'Request and issuance of certified true copy of certificates through online services.']
                        ]
                    ],
                    [
                        'title' => 'Legal and Administrative Services',
                        'image' => './images/announcement.jpg',
                        'items' => [
                            ['name' => 'Admission of Paternity (R.A. 9255)', 'price' => '₱5,000', 'details' => 'Allows illegitimate children to use the surname of the father.'],
                            ['name' => 'Legitimation with Admission of Paternity (R.A. 9858)', 'price' => '₱6,000', 'details' => 'Includes supplemental report for legal recognition.'],
                            ['name' => 'R.A. 9048 - Petition for Change of First Name (CFN)', 'price' => '₱4,000', 'details' => 'Petition for a change of first name under R.A. 9048.'],
                            ['name' => 'R.A. 9048 - Petition for Correction of Clerical Error (CCE)', 'price' => '₱4,500', 'details' => 'Petition for correction of clerical errors in birth, marriage, or death certificates.'],
                            ['name' => 'R.A. 10172 - Petition for Correction of Sex and/or Day and/or Month in the Date of Birth', 'price' => '₱5,000', 'details' => 'Petition for correction of sex or birth date details in civil registry documents.']
                        ]
                    ]
                ];
                

                foreach ($services as $service) {
                    echo '<div class="card-wrapper p-2">';
                    echo '<div class="card flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">';
                    echo '<div class="overflow-hidden rounded-t-lg"><img src="' . $service['image'] . '" alt="' . $service['title'] . '" class="card-img w-full h-52 object-cover"></div>';
                    echo '<div class="p-5 card-description">';
                    echo '<h3 class="text-2xl font-semibold text-gray-800 mb-8 text-center">' . $service['title'] . '</h3>';
                    echo '<div class="space-y-2">';

                    foreach ($service['items'] as $item) {
                        echo '<div class="service-item">';
                        echo '<div class="flex justify-between items-center">';
                        echo '<i class="fas fa-info-circle text-gray-500 mr-2"></i>';
                        echo '<span class="text-gray-700 font-medium border p-2 border-[#4F46E5] rounded-md w-full cursor-pointer">' . $item['name'] . '</span>';
                       
                        echo '</div>';
                        echo '<div class="service-details">';
                        echo '<span class="text-gray-600">' . $item['details'] . '</span>';
                        echo '<span class="price-tag pl-4">' . $item['price'] . '</span>';
                        echo '</div>';
                        echo '</div>';
                    }

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <?php include './layout/footer.php'; ?>
    </div>
</body>
</html>