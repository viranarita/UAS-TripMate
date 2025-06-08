@vite(['resources/css/app.css', 'resources/css/style.css'])

<aside class="bg-white fixed top-0 left-0 h-full w-64 shadow-lg flex-col z-10 hidden lg:flex">

    <div class="flex-col h-full overflow-y-auto hidden lg:flex">
        
        <div class="p-7 border-b border-gray-200">
            <a href="#home" class="font-bold text-2xl text-primary">TripMate</a>
        </div>

        <div>
            <div class="p-7 space-y-3 border-b border-gray-200">
                <a href="/dashboard" class="text-base text-dark hover:text-primary">Dashboard</a>
            </div>
            
            <div class="p-7 space-y-3 border-b border-gray-200">
                <a href="/users" class="text-base text-dark hover:text-primary">Manage User</a>
            </div>

            <div class="flex flex-col border-b border-gray-200 w-full">
                <button onclick="showMenu1()" class="p-7 text-left text-dark flex justify-between items-center w-full py-5">
                    <p class="text-base text-dark hover:text-primary">Manage Places</p>
                    <svg id="icon1" class="transform transition-transform duration-300" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 15L12 9L6 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>

                <div id="menu1" class="hidden flex-col w-full space-y-1 p-7 pt-0">
                    <button class="flex justify-start items-center text-gray-600 hover:text-primary focus:bg-gray-700 rounded px-3 py-2 w-full md:w-52">
                        <a href="/attraction" class="text-base leading-4">Attractions</a>
                    </button>
                    <button class="flex justify-start items-center text-gray-600 hover:text-primary focus:bg-gray-700 rounded px-3 py-2 w-full md:w-52">
                        <a href="/culinary" class="text-base leading-4">Culinaries</a>
                    </button>
                    <button class="flex justify-start items-center text-gray-600 hover:text-primary focus:bg-gray-700 rounded px-3 py-2 w-full md:w-52">
                        <a href="/hotel" class="text-base leading-4">Hotels</a>
                    </button>
                </div>
            </div>

            <div class="flex flex-col border-b border-gray-200 w-full">
                <button onclick="showMenu2()" class="p-7 text-left text-dark flex justify-between items-center w-full py-5">
                    <p class="text-base text-dark hover:text-primary">Manage Transportation</p>
                    <svg id="icon2" class="transform transition-transform duration-300" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 15L12 9L6 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>

                <div id="menu2" class="hidden flex-col w-full space-y-1 p-7 pt-0">
                    <button class="flex justify-start items-center text-gray-600 hover:text-primary focus:bg-gray-700 rounded px-3 py-2 w-full md:w-52">
                        <a href="/buses" class="text-base leading-4">Buses</a>
                    </button>
                    <button class="flex justify-start items-center text-gray-600 hover:text-primary focus:bg-gray-700 rounded px-3 py-2 w-full md:w-52">
                        <a href="/flights" class="text-base leading-4">Flights</a>
                    </button>
                    <button class="flex justify-start items-center text-gray-600 hover:text-primary focus:bg-gray-700 rounded px-3 py-2 w-full md:w-52">
                        <a href="/trains" class="text-base leading-4">Trains</a>
                    </button>
                </div>
            </div>
            
            <div class="p-7 space-y-3 border-b border-gray-200">
                <a href="/packages" class="text-base text-dark hover:text-primary">Manage Packages</a>
            </div>

        </div>

        <div class="absolute bottom-0 w-full p-7 border-t border-gray-200 bg-white">
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" name="logout" class="text-base text-dark hover:text-primary w-full">Logout</button>
            </form>
        </div>

    </div>

</aside>

<script>
function showMenu1() {
    const menu = document.getElementById("menu1");
    const icon = document.getElementById("icon1");
    menu.classList.toggle("hidden");
    icon.classList.toggle("rotate-180");
}
function showMenu2() {
    const menu = document.getElementById("menu2");
    const icon = document.getElementById("icon2");
    menu.classList.toggle("hidden");
    icon.classList.toggle("rotate-180");
}
</script>
