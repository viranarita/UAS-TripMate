@vite(['resources/css/app.css', 'resources/css/style.css'])

<nav class="w-full bg-primary border-b border-slate-300 shadow-md z-40 relative mt-19">
    <div class="w-[90vw] max-w-4xl mx-auto h-16 flex items-center justify-center px-6">
        <div id="destination-nav" class="flex space-x-4 md:space-x-6 lg:space-x-8">

            <a href="{{ url('/destination-attraction') }}"
               class="text-base px-3 py-2 rounded-md transition 
               {{ request()->is('destination-attraction') ? 'bg-white text-primary' : 'text-white hover:bg-gray-200 hover:text-primary' }}">
                Attraction
            </a>

            <a href="{{ url('/destination-culinary') }}"
               class="text-base px-3 py-2 rounded-md transition 
               {{ request()->is('destination-culinary') ? 'bg-white text-primary' : 'text-white hover:bg-gray-200 hover:text-primary' }}">
                Culinary
            </a>

            <a href="{{ url('/destination-hotel') }}"
               class="text-base px-3 py-2 rounded-md transition 
               {{ request()->is('destination-hotel') ? 'bg-white text-primary' : 'text-white hover:bg-gray-200 hover:text-primary' }}">
                Hotel
            </a>

            <a href="{{ url('/destination-buses') }}"
               class="text-base px-3 py-2 rounded-md transition 
               {{ request()->is('destination-buses') ? 'bg-white text-primary' : 'text-white hover:bg-gray-200 hover:text-primary' }}">
                Buses
            </a>

            <a href="{{ url('/destination-flight') }}"
               class="text-base px-3 py-2 rounded-md transition 
               {{ request()->is('destination-flight') ? 'bg-white text-primary' : 'text-white hover:bg-gray-200 hover:text-primary' }}">
                Flight
            </a>

            <a href="{{ url('/destination-trains') }}"
               class="text-base px-3 py-2 rounded-md transition 
               {{ request()->is('destination-trains') ? 'bg-white text-primary' : 'text-white hover:bg-gray-200 hover:text-primary' }}">
                Trains
            </a>

            <a href="{{ url('/destination-package') }}"
               class="text-base px-3 py-2 rounded-md transition 
               {{ request()->is('destination-package') ? 'bg-white text-primary' : 'text-white hover:bg-gray-200 hover:text-primary' }}">
                Package
            </a>

        </div>            
    </div>
</nav>
