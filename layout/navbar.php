<div class="bg-blue-600">
    <div class="container mx-auto">
        <nav class="flex justify-between items-center p-2 relative">
            <div>
                <img src="images/qclogo.png" alt='logo' class='cursor-pointer w-full h-[49px]' />
            </div>

            <form class="hidden md:flex border justify-between items-center rounded-sm p-[2px] px-2 bg-white w-[30%]">
                <input type="text" placeholder="search..." class="outline-none p-[2px] rounded-sm bg-white w-[95%]" />
                <i class="fas fa-search cursor-pointer"></i>
            </form>

            <div class="justify-center items-center gap-4 md:flex">
                <a href="/aboutUs" class="font-[500] hidden md:flex">Services</a>
                <a href="/aboutUs" class="font-[500] hidden md:flex">About</a>
                <a href="/contactUs" class="font-[500] hidden md:flex">Contact us</a>

                <!-- Dynamic Profile Image or Sign In Button -->
                <div id="authDisplay"></div>
            </div>
        </nav>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const authDisplay = document.getElementById('authDisplay');
        const profileImage = localStorage.getItem('profileImage');
        const navigate = localStorage.getItem('role');

        if (profileImage) {
            // User is authenticated, show profile image from localStorage
            authDisplay.innerHTML = `<a href="/civil-registrar/pages/${navigate}/${navigate}Dashboard.php">
            <img src="${profileImage}" alt="Profile" class="w-[21px] h-[21px] font-semibold cursor-pointer rounded-[100%]" /></a>
            `;
        } else {
            // No profile image, show sign-in button
            authDisplay.innerHTML = `<a href="/civil-registrar/pages/login.php" class="font-[500] border px-2 py-1 rounded-md">Sign In</a>`;
        }
    });
</script>
