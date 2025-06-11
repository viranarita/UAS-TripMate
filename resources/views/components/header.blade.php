@vite(['resources/css/app.css', 'resources/css/style.css'])

<!-- Header Section Start -->
<header class="bg-white fixed top-0 left-0 w-full flex items-center z-50 border-b border-gray-200 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo dan Menu -->
        <div class="px-4 flex items-center space-x-8">
            <a href="#home" class="font-bold text-lg text-primary py-6">TripMate</a>
            
            {{-- Cek kalau bukan admin (misal pake gate atau user role) --}}
            @if (!Auth::check() || (Auth::user() && !Auth::user()->is_admin))
            <nav class="hidden lg:flex space-x-8">
                <a href="{{ url('/') }}" class="text-base text-dark hover:text-primary {{ request()->is('/') ? 'text-primary font-semibold' : '' }}">Home</a>
                <a href="{{ url('/destination') }}" class="text-base text-dark hover:text-primary {{ request()->is('destination') ? 'text-primary font-semibold' : '' }}">Destination</a>
                <a href="{{ url('/cardplanning') }}" class="text-base text-dark hover:text-primary {{ request()->is('cardplanning') ? 'text-primary font-semibold' : '' }}">Planning</a>
            </nav>
            @endif
        </div>

        <!-- Tombol Sign In & Register (Hanya di Desktop) -->
        @if (!Auth::check())
        <div class="hidden lg:flex items-center space-x-4">
            <a href="{{ url('/login') }}" class="text-base text-dark hover:text-primary">Sign In</a>
            <a href="{{ url('/register') }}" class="text-base text-dark py-2 mx-8 lg:mx-4 lg:px-4 lg:py-2 lg:border lg:border-primary lg:rounded-full lg:hover:bg-primary lg:hover:text-white lg:transition lg:duration-300">Create Account</a>
        </div>
        @else
        <div class="hidden lg:flex items-center space-x-4">
            <span class="inline-block text-base text-white py-2 mx-8 lg:mx-4 lg:px-4 lg:py-2 lg:border lg:border-primary lg:rounded-full bg-primary">
                Hai, {{ Auth::user()->name }} 👋
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-base text-dark hover:text-primary">Logout</button>
            </form>
        </div>
        @endif

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
            @if (!Auth::check() || (Auth::user() && !Auth::user()->is_admin))
            <li><a href="{{ url('/') }}" class="text-base text-dark hover:text-primary {{ request()->is('/') ? 'text-primary font-semibold' : '' }}">Home</a></li>
            <li><a href="{{ url('/destination') }}" class="text-base text-dark hover:text-primary {{ request()->is('destination') ? 'text-primary font-semibold' : '' }}">Destination</a></li>
            <li><a href="{{ url('/cardplanning') }}" class="text-base text-dark hover:text-primary {{ request()->is('planning') ? 'text-primary font-semibold' : '' }}">Planning</a></li>
            @endif

            @if (!Auth::check())
            <li><a href="{{ url('/login') }}" class="text-base text-dark hover:text-primary block">Sign In</a></li>
            <li><a href="{{ url('/register') }}" class="text-base text-dark hover:text-primary block">Create Account</a></li>
            @else
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-base text-dark hover:text-primary">Logout</button>
                </form>
            </li>
            @endif
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
