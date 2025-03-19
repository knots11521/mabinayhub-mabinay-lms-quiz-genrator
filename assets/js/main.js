        function openEditModal(id, lastname, firstname, username) {
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_lastname").value = lastname;
            document.getElementById("edit_firstname").value = firstname;
            document.getElementById("edit_username").value = username;

            const modal = document.getElementById("editUserModal");
            const modalContent = document.getElementById("editModalContent");

            modal.classList.remove("hidden");
            document.body.classList.add("overflow-hidden");

            // Trigger animation
            setTimeout(() => {
                modalContent.classList.remove("opacity-0", "scale-95");
                modalContent.classList.add("opacity-100", "scale-100");
            }, 10);
        }

        function closeEditModal() {
            const modal = document.getElementById("editUserModal");
            const modalContent = document.getElementById("editModalContent");

            // Trigger closing animation
            modalContent.classList.remove("opacity-100", "scale-100");
            modalContent.classList.add("opacity-0", "scale-95");

            setTimeout(() => {
                modal.classList.add("hidden");
                document.body.classList.remove("overflow-hidden");
            }, 300);
        }


        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function checkScreenSize() {
            if (window.innerWidth >= 768) {
                document.getElementById('sidebar').classList.remove('-translate-x-full');
                document.getElementById('overlay').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                document.getElementById('sidebar').classList.add('-translate-x-full');
            }
        }
        // information js
        function showUserInfo(lastname, firstname, username, role, section, yearLevel, subject) {
            document.getElementById('info_lastname').textContent = lastname || 'N/A';
            document.getElementById('info_firstname').textContent = firstname || 'N/A';
            document.getElementById('info_username').textContent = username || 'N/A';
            document.getElementById('info_role').textContent = role || 'N/A';
            document.getElementById('info_section').textContent = section || 'N/A';
            document.getElementById('info_year_level').textContent = yearLevel || 'N/A';
            document.getElementById('info_subject').textContent = subject || 'N/A';

            const modal = document.getElementById('userInfoModal');
            const modalContent = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // Add animation (fade + scale in)
            setTimeout(() => {
                modalContent.classList.remove('opacity-0', 'scale-95');
                modalContent.classList.add('opacity-100', 'scale-100');
            }, 10); // Slight delay to trigger transition
        }

        function closeUserInfoModal() {
            const modal = document.getElementById('userInfoModal');
            const modalContent = document.getElementById('modalContent');

            // Add animation (fade + scale out)
            modalContent.classList.remove('opacity-100', 'scale-100');
            modalContent.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }, 300); // Wait for animation to complete
        }




        window.addEventListener('resize', checkScreenSize);