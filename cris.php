

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <title>Prenatal Laboratory Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .others-input {
            display: none;
            margin-top: 10px;
        }

        .container h1 {
            text-align: center;
        }

        /* Success message style */
        .success-message {
            display: none;
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            margin: 20px 0;
            border: 1px solid #d6e9c6;
            border-radius: 5px;
        }
    </style>
    <
</head>
<body>
    <div class="container">
        <h1>Prenatal Laboratory Form</h1>
        
        <!-- Success Message -->
        <div id="successMessage" class="success-message">
            Your submission was successful! Thank you for your submission.
        </div>

        <form id="prenatalForm" action="" method="POST">
            <h2>Laboratory Information</h2>
            <label for="labName">Laboratory Name:</label>
            <input type="text" id="labName" name="labName" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="patientId">Patient ID:</label>
            <input type="text" id="patientId" name="patientId" required>

            <h2>Patient Information</h2>
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
                <option value="Other">Other</option>
            </select>

            <label for="contactNumber">Contact Number:</label>
            <input type="tel" id="contactNumber" name="contactNumber" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>

            <label for="patientAddress">Address:</label>
            <input type="text" id="patientAddress" name="patientAddress" required>

            <label for="obgynName">Obstetrician/Gynecologist Name:</label>
            <input type="text" id="obgynName" name="obgynName" required>

            <label for="obgynContact">OB/GYN Contact Information:</label>
            <input type="text" id="obgynContact" name="obgynContact" required>

            <label for="lmp">Last Menstrual Period (LMP):</label>
            <input type="date" id="lmp" name="lmp" required>

            <label for="edd">Estimated Due Date (EDD):</label>
            <input type="date" id="edd" name="edd" required>

            <label for="gravida">Gravida:</label>
            <input type="number" id="gravida" name="gravida" required>

            <label for="para">Para:</label>
            <input type="number" id="para" name="para" required>

            <label for="previousPregnancies">Previous Pregnancies:</label>
            <input type="text" id="previousPregnancies" name="previousPregnancies" required>

            <label for="previousComplications">Previous Complications:</label>
            <input type="text" id="previousComplications" name="previousComplications">

            <h2>Prenatal Lab Tests Requested</h2>

            <label for="bloodTests">Blood Work:</label>
            <select id="bloodTests" name="bloodTests[]" onchange="toggleOthersInput(this, 'othersBloodInput')" required>
                <option value="">Select</option>
                <option value="CBC">Complete Blood Count (CBC)</option>
                <option value="BloodType">Blood Type & Rh Factor</option>
                <option value="Hemoglobin">Hemoglobin & Hematocrit</option>
                <option value="Glucose">Glucose Screening</option>
                <option value="Rubella">Rubella Immunity</option>
                <option value="HIV">HIV Screening</option>
                <option value="Hepatitis">Hepatitis B & C</option>
                <option value="Syphilis">Syphilis Test</option>
                <option value="TORCH">TORCH Panel</option>
                <option value="Others">Others</option>
            </select>
            <input type="text" id="othersBloodInput" name="othersBlood" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="urineTests">Urine Tests:</label>
            <select id="urineTests" name="urineTests[]" onchange="toggleOthersInput(this, 'othersUrineInput')" required>
                <option value="">Select</option>
                <option value="Urinalysis">Urinalysis</option>
                <option value="Proteinuria">Proteinuria</option>
                <option value="UrineCulture">Urine Culture</option>
                <option value="Others">Others</option>
            </select>
            <input type="text" id="othersUrineInput" name="othersUrine" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="diseaseScreening">Infectious Disease Screening:</label>
            <select id="diseaseScreening" name="diseaseScreening[]" onchange="toggleOthersInput(this, 'othersDiseaseInput')" required>
                <option value="">Select</option>
                <option value="GBS">Group B Streptococcus (GBS)</option>
                <option value="Chlamydia">Chlamydia</option>
                <option value="Gonorrhea">Gonorrhea</option>
                <option value="Others">Others</option>
            </select>
            <input type="text" id="othersDiseaseInput" name="othersDisease" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="geneticScreening">Genetic Screening (Optional):</label>
            <select id="geneticScreening" name="geneticScreening[]" onchange="toggleOthersInput(this, 'othersGeneticInput')" required>
                <option value="">Select</option>
                <option value="Carrier">Carrier Screening</option>
                <option value="CysticFibrosis">Cystic Fibrosis</option>
                <option value="DownSyndrome">Down Syndrome</option>
                <option value="Trisomy">Trisomy 18 & 13</option>
                <option value="Others">Others</option>
            </select>
            <input type="text" id="othersGeneticInput" name="othersGenetic" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="ultrasound">Ultrasound and Imaging:</label>
            <select id="ultrasound" name="ultrasound[]" onchange="toggleOthersInput(this, 'othersUltrasoundInput')" required>
                <option value="">Select</option>
                <option value="FetalUltrasound">Fetal Ultrasound</option>
                <option value="NTScan">Nuchal Translucency (NT) Scan</option>
                <option value="Others">Others</option>
            </select>
            <input type="text" id="othersUltrasoundInput" name="othersUltrasound" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="notes">Other Tests/Notes:</label>
            <textarea id="notes" name="notes"></textarea>

            <h2>Physician's Notes and Recommendations</h2>
            <textarea id="physicianNotes" name="physicianNotes"></textarea>

            <button type="submit">Submit</button>
            <a href="manage-prenatal.php" class="btn btn-secondary" style="margin-left: 10px;">Back</a>
        </form>
    </div>
</body>
</html>
