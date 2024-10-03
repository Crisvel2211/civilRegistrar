<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Announcement</title>
</head>
<body>
    <h1>Create Announcement</h1>
    <form id="announcementForm" enctype="multipart/form-data">
        <div>
            <input type="text" name="title" placeholder="Title" required>
        </div>
        <div>
            <textarea name="description" placeholder="Description" required></textarea>
        </div>
        <div>
            <input type="text" name="posted_by" placeholder="Posted By" required>
        </div>
        <div>
            <input type="file" name="image" accept="image/*" required>
        </div>
        <div>
            <input type="submit" value="Submit Announcement">
        </div>
    </form>

    <script>
    document.getElementById('announcementForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
        const formData = new FormData(this); // Create FormData object from the form

        // Log the form data for debugging
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        // Check if all required fields are filled
        if (!formData.get('title') || !formData.get('description') || !formData.get('posted_by') || !formData.get('image')) {
            alert('Please fill all required fields.');
            return;
        }

        fetch('http://localhost/civil-registrar/api/announcements.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw new Error(err.message); });
            }
            return response.json(); // Parse the JSON response
        })
        .then(data => {
            alert(data.message); // Display success or error message
            if (data.message === 'Announcement created successfully') {
                this.reset(); // Clear the form on success
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error creating announcement: ' + error.message);
        });
    });
</script>

</body>
</html>
