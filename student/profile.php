<!DOCTYPE html>
<html lang="en">
<head>
    <title>Editable Profile with Picture Upload</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        input[type="file"] {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

<!-- Profile Card Wrapper -->
<div class="w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden">

    <!-- Header Section -->
    <div class="bg-blue-500 h-28 md:h-36 relative">
        <div class="absolute -bottom-12 left-4 md:left-8 group">
            <div class="w-24 h-24 md:w-28 md:h-28 rounded-full bg-gray-100 border-4 border-white overflow-hidden relative cursor-pointer">
                <img id="profileImage" src="https://via.placeholder.com/150" alt="Profile Picture" class="w-full h-full object-cover">
                <label for="profileImageInput" class="absolute inset-0 bg-black bg-opacity-50 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer text-xs">
                    Change Picture
                </label>
                <input type="file" id="profileImageInput" accept="image/*" onchange="handleImageChange(event)">
            </div>
        </div>
    </div>

    <!-- Main Profile Content -->
    <div class="p-6 pt-16 md:pt-20">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800" id="profileName">Juan Dela Cruz</h2>
                <p class="text-sm text-gray-500">User ID: <span id="profileID">#2025001</span></p>
            </div>
            <div class="mt-4 md:mt-0">
                <button id="editProfileBtn" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition" onclick="toggleEdit()">
                    Edit Profile
                </button>
            </div>
        </div>

        <!-- View Mode -->
        <div id="viewMode" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div><p class="text-gray-500 text-sm">Username</p><p class="text-gray-800 font-medium" id="profileUsername">juandelacruz</p></div>
            <div><p class="text-gray-500 text-sm">Role</p><p class="text-gray-800 font-medium" id="profileRole">Student</p></div>
            <div><p class="text-gray-500 text-sm">Section</p><p class="text-gray-800 font-medium" id="profileSection">Section A</p></div>
            <div><p class="text-gray-500 text-sm">Year Level</p><p class="text-gray-800 font-medium" id="profileYearLevel">Grade 10</p></div>
            <div><p class="text-gray-500 text-sm">Subject</p><p class="text-gray-800 font-medium" id="profileSubject">Mathematics</p></div>
            <div><p class="text-gray-500 text-sm">Account Created</p><p class="text-gray-800 font-medium" id="profileCreatedAt">March 5, 2025</p></div>
        </div>

        <!-- Edit Mode (hidden by default) -->
        <form id="editMode" class="hidden mt-6 grid grid-cols-1 md:grid-cols-2 gap-6" onsubmit="saveProfile(event)">
            <div><p class="text-gray-500 text-sm">Username</p><input type="text" id="editUsername" class="w-full border rounded p-2 text-gray-700"></div>
            <div><p class="text-gray-500 text-sm">Role</p><input type="text" id="editRole" class="w-full border rounded p-2 text-gray-700"></div>
            <div><p class="text-gray-500 text-sm">Section</p><input type="text" id="editSection" class="w-full border rounded p-2 text-gray-700"></div>
            <div><p class="text-gray-500 text-sm">Year Level</p><input type="text" id="editYearLevel" class="w-full border rounded p-2 text-gray-700"></div>
            <div><p class="text-gray-500 text-sm">Subject</p><input type="text" id="editSubject" class="w-full border rounded p-2 text-gray-700"></div>
            <div class="col-span-2 text-right mt-4">
                <button type="button" class="bg-gray-500 text-white px-6 py-2 rounded-md mr-2" onclick="cancelEdit()">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md">Save Changes</button>
            </div>
        </form>

    </div>
</div>

<script>
    // Sample Data (can be replaced by actual fetched data)
    const profileData = {
        id: '2025001',
        lastname: 'Dela Cruz',
        firstname: 'Juan',
        username: 'juandelacruz',
        role: 'Student',
        section: 'Section A',
        year_level: 'Grade 10',
        subject: 'Mathematics',
        created_at: '2025-03-05'
    };

    function loadProfile() {
        document.getElementById('profileID').innerText = '#' + profileData.id;
        document.getElementById('profileName').innerText = `${profileData.firstname} ${profileData.lastname}`;
        document.getElementById('profileUsername').innerText = profileData.username;
        document.getElementById('profileRole').innerText = profileData.role;
        document.getElementById('profileSection').innerText = profileData.section;
        document.getElementById('profileYearLevel').innerText = profileData.year_level;
        document.getElementById('profileSubject').innerText = profileData.subject;
        document.getElementById('profileCreatedAt').innerText = new Date(profileData.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        
        document.getElementById('editUsername').value = profileData.username;
        document.getElementById('editRole').value = profileData.role;
        document.getElementById('editSection').value = profileData.section;
        document.getElementById('editYearLevel').value = profileData.year_level;
        document.getElementById('editSubject').value = profileData.subject;
    }

    function toggleEdit() {
        document.getElementById('viewMode').classList.toggle('hidden');
        document.getElementById('editMode').classList.toggle('hidden');
        document.getElementById('editProfileBtn').innerText = 
            document.getElementById('editMode').classList.contains('hidden') ? 'Edit Profile' : 'Cancel Edit';
    }

    function cancelEdit() {
        loadProfile(); // Reset fields
        toggleEdit();
    }

    function saveProfile(event) {
        event.preventDefault();
        profileData.username = document.getElementById('editUsername').value;
        profileData.role = document.getElementById('editRole').value;
        profileData.section = document.getElementById('editSection').value;
        profileData.year_level = document.getElementById('editYearLevel').value;
        profileData.subject = document.getElementById('editSubject').value;
        loadProfile();
        toggleEdit();
    }

    function handleImageChange(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            document.getElementById('profileImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    // Initial load
    loadProfile();
</script>

</body>
</html>
