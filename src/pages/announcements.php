<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-blue-600 text-white p-4 text-center">
        <h1 class="text-2xl font-semibold">Announcements</h1>
    </header>
    
    <main class="p-6">
        <!-- Form for creating/updating announcements -->
        <form id="announcement-form" class="bg-white p-6 rounded shadow-md">
            <input type="hidden" id="announcement-id">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                <input type="text" id="title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                <textarea id="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
            </div>
            
            <div class="mb-4">
                <label for="posted_by" class="block text-sm font-medium text-gray-700">Posted By (User ID):</label>
                <input type="number" id="posted_by" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Save Announcement</button>
        </form>

        <!-- Table to display announcements -->
        <table id="announcements-table" class="mt-6 w-full bg-white border border-gray-300 rounded shadow-md">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted By</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Announcements will be inserted here by JavaScript -->
            </tbody>
        </table>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('announcement-form');
            const announcementsTable = document.getElementById('announcements-table').getElementsByTagName('tbody')[0];

            // Function to fetch announcements from the API
            function fetchAnnouncements() {
                fetch('http://localhost/civil-registrar/api/announcements.php')
                    .then(response => response.json())
                    .then(data => {
                        announcementsTable.innerHTML = '';
                        data.forEach(announcement => {
                            const row = announcementsTable.insertRow();
                            row.insertCell(0).textContent = announcement.id;
                            row.insertCell(1).textContent = announcement.title;
                            row.insertCell(2).textContent = announcement.description;
                            row.insertCell(3).textContent = announcement.posted_by_name;

                            const actionsCell = row.insertCell(4);
                            actionsCell.innerHTML = `
                                <button onclick="editAnnouncement(${announcement.id})" class="bg-blue-500 text-white py-1 px-2 rounded">Edit</button>
                                <button onclick="deleteAnnouncement(${announcement.id})" class="bg-red-500 text-white py-1 px-2 rounded">Delete</button>
                            `;
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching announcements:', error);
                        showToast('Error fetching announcements', 'error');
                    });
            }

            // Function to handle form submission
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const id = document.getElementById('announcement-id').value;
                const title = document.getElementById('title').value;
                const description = document.getElementById('description').value;
                const posted_by = document.getElementById('posted_by').value;

                const method = id ? 'PUT' : 'POST';
                const url = `http://localhost/civil-registrar/api/announcements.php`;

                fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        id: id,
                        title: title,
                        description: description,
                        posted_by: posted_by
                    })
                })
                .then(response => response.json())
                .then(data => {
                    showToast(data.message || data.error, data.error ? 'error' : 'success');
                    fetchAnnouncements();
                    form.reset();
                })
                .catch(error => {
                    console.error('Error saving announcement:', error);
                    showToast('Error saving announcement', 'error');
                });
            });

            // Function to handle edit button click
            window.editAnnouncement = function(id) {
                fetch(`http://localhost/civil-registrar/api/announcements.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length) {
                            const announcement = data[0];
                            document.getElementById('announcement-id').value = announcement.id;
                            document.getElementById('title').value = announcement.title;
                            document.getElementById('description').value = announcement.description;
                            document.getElementById('posted_by').value = announcement.posted_by;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching announcement:', error);
                        showToast('Error fetching announcement', 'error');
                    });
            }

            // Function to handle delete button click
            window.deleteAnnouncement = function(id) {
                if (confirm('Are you sure you want to delete this announcement?')) {
                    fetch('http://localhost/civil-registrar/api/announcements.php', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({ id: id })
                    })
                    .then(response => response.json())
                    .then(data => {
                        showToast(data.message || data.error, data.error ? 'error' : 'success');
                        fetchAnnouncements();
                    })
                    .catch(error => {
                        console.error('Error deleting announcement:', error);
                        showToast('Error deleting announcement', 'error');
                    });
                }
            }

            // Function to show toast notifications
            function showToast(message, type) {
                Toastify({
                    text: message,
                    style: {
                        background: type === 'error' ? 'linear-gradient(to right, #ff5f6d, #ffc371)' : 'linear-gradient(to right, #00b09b, #96c93d)',
                    },
                    className: type === 'error' ? 'error' : 'success',
                    duration: 3000
                }).showToast();
            }

            // Initial fetch of announcements
            fetchAnnouncements();
        });
    </script>
</body>
</html>
