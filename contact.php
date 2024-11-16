<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="icon" href="images/qcfavicon.svg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .contact-form input, .contact-form textarea {
            border-radius: 0.375rem;
        }

        /* Button hover effects */
        .contact-form button:hover {
            background-color: #4F46E5;
            transition: background-color 0.3s ease-in-out;
        }

        .contact-form input:focus, .contact-form textarea:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.3);
        }

        /* Form container styling */
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        /* Form heading */
        .form-heading {
            color: #191f8a;
            font-size: 2rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 1rem;
        }

        /* Form fields styling */
        .input-field {
            padding: 1rem;
            border: 2px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 1rem;
            width: 100%;
            margin-bottom: 1rem;
        }

        .input-field:focus {
            border-color: #191f8a;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.3);
        }

        /* Textarea styling */
        .textarea-field {
            padding: 1rem;
            border: 2px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 1rem;
            width: 100%;
            resize: vertical;
            margin-bottom: 1rem;
        }

        .textarea-field:focus {
            border-color: #191f8a;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.3);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .form-container {
                padding: 1.5rem;
            }   
            .form-heading {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex flex-col">
        <?php include './layout/navbar.php'; ?>

        <section class="container mx-auto my-16 px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-extrabold text-gray-800 text-center mb-5">Contact us</h2>
                <p class="text-lg text-gray-600 text-center mb-6">
                    Have any questions? Reach out to us below.
                </p>
            </div>

            <!-- Contact Form -->
            <div class="form-container">
                <form action="/submit-contact-form" method="POST" class="contact-form space-y-6">
                    <div>
                        <label for="name" class="block text-gray-700">Full Name</label>
                        <input type="text" id="name" name="name" required class="input-field" placeholder="Enter your full name">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-gray-700">Email Address</label>
                        <input type="email" id="email" name="email" required class="input-field" placeholder="Enter your email">
                    </div>

                    <div>
                        <label for="message" class="block text-gray-700">Message</label>
                        <textarea id="message" name="message" rows="4" required class="textarea-field" placeholder="Enter your message"></textarea>
                    </div>

                    <div>
                        <button type="submit" class="w-full bg-[#191f8a] text-white py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#191f8a] transition-all">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <?php include './layout/footer.php'; ?>
    </div>

</body>
</html>
