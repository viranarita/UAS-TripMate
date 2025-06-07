@vite(['resources/css/app.css', 'resources/css/style.css'])

<header class="absolute top-0 left-0 w-full lg:w-[calc(100%-16rem)] lg:ml-64 flex items-center justify-between z-10 bg-primary px-7">
    <div class="p-7">
        <p class="font-bold text-2xl text-white">{{ $pageTitle ?? 'Dashboard' }}</p>
    </div>
    <div id="headerTitle" class="flex items-center space-x-4 p-7">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 448 512" fill="currentColor" class="text-white">
            <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/>
        </svg>
        <p class="font-semibold text-lg text-white">Admin</p>
    </div>
    <script>
        function updateHeader(title) {
            document.getElementById("headerTitle").textContent = title;
        }
    </script>
</header>
