@vite(['resources/css/app.css', 'resources/css/style.css'])

<!-- Header Section Start -->
<header class="bg-white fixed top-0 left-0 w-full flex items-center z-50">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo dan Menu -->
        <div class="px-4 flex items-center space-x-8">
            <a href="#home" class="font-bold text-lg text-primary py-6">TripMate</a>
            <nav class="hidden lg:flex space-x-8">
                <a href="/" class="text-base text-dark hover:text-primary">Home</a>
                <a href="/destination" class="text-base text-dark hover:text-primary">Destination</a>
                <a href="/planning" class="text-base text-dark hover:text-primary">Planning</a>
            </nav>
        </div>

        <!-- Tombol Sign In & Register (Hanya di Desktop) -->
        <div class="hidden lg:flex items-center space-x-4">
            <a href="/login" class="text-base text-dark hover:text-primary">Sign In</a>
            <a href="/register" class="text-base text-dark py-2 mx-8 lg:mx-4 lg:px-4 lg:py-2 lg:border lg:border-primary lg:rounded-full lg:hover:bg-primary lg:hover:text-white lg:transition lg:duration-300">Create Account</a>
        </div>

        <!-- Tombol Hamburger (Hanya di Mobile) -->
        <button id="hamburger" class="lg:hidden">
            <span class="hamburger-line origin-top-left transition duration-300 ease-in-out"></span>
            <span class="hamburger-line transition duration-300 ease-in-out"></span>
            <span class="hamburger-line origin-bottom-left transition duration-300 ease-in-out"></span>
        </button>
    </div>

    <!-- Mobile Menu -->
    <nav id="nav-menu" class="hidden absolute bg-white shadow-lg rounded-lg max-w-[250px] w-full right-4 top-full lg:hidden">
        <ul class="block text-left space-y-4 p-5">
            <li><a href="/index" class="text-base text-dark hover:text-primary">Home</a></li>
            <li><a href="/destination" class="text-base text-dark hover:text-primary">Destination</a></li>
            <li><a href="/planning" class="text-base text-dark hover:text-primary">Planning</a></li>
            <li><a href="/login" class="text-base text-dark hover:text-primary block">Sign In</a></li>
            <li><a href="/register" class="text-base text-dark hover:text-primary block">Create Account</a></li>
        </ul>
    </nav>
</header>
<!-- Header Section End -->
<script>
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');
  
    hamburger.addEventListener('click', function () {
      navMenu.classList.toggle('hidden');
    });
  </script>
  