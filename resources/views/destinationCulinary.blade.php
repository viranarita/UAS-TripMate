@extends('layouts.app')

@section('title', 'Destination - Culinaries')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>TripMate</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body class="bg-gray-100">

    @include('components.navbardestination')

    <!-- Form Pencarian -->
    <section class="pt-8 pb-8 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        <div class="flex">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                <form action="{{ route('destination-culinary.search') }}" method="POST">
                    @csrf
                    <div>
                        <label class="block text-gray-700">Nama Kota</label>
                        <input type="text" id="city" name="city" required
                            value="{{ old('city', $city ?? '') }}"
                            class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="mt-4 flex justify-center">
                        <button type="submit" id="addBtn" class="bg-primary text-white px-4 py-2 rounded">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </section>


    <!-- Hasil Pencarian -->
    <section class="pb-8 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        @if(isset($culinary) && $culinary->count())
            <h2 class="text-l text-gray-700 mb-4 px-4">
                <span class="font-semibold">{{ $city }}</span> – {{ $culinary->count() }} kuliner ditemukan
            </h2>
        @elseif(request()->has('city'))
            <h2 class="text-l text-gray-700 mb-4 px-4">
                <span class="font-semibold">{{ $city }}</span> – Tidak ada kuliner ditemukan
            </h2>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-4">
            @if(isset($culinary) && $culinary->count())
                @foreach($culinary as $item)
                @php
                    $symbolDisplay = '';
                    switch(strtolower($item->price_range)) {
                        case 'murah':
                            $symbolDisplay = '<span class="text-primary">$</span><span class="text-gray-500">$</span><span class="text-gray-500">$</span>';
                            break;
                        case 'sedang':
                            $symbolDisplay = '<span class="text-primary">$</span><span class="text-primary">$</span><span class="text-gray-500">$</span>';
                            break;
                        case 'mahal':
                            $symbolDisplay = '<span class="text-primary">$</span><span class="text-primary">$</span><span class="text-primary">$</span>';
                            break;
                    }
                @endphp
                <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                    @if($item->image_url)
                        <div class="w-full h-[200px]">
                            <img src="data:image/jpeg;base64,{{ base64_encode($item->image_url) }}"
                                alt="{{ $item->name }}"
                                class="w-full h-full object-cover"/>
                        </div>
                    @else
                        <div class="w-full h-[200px] bg-gray-300 flex items-center justify-center text-gray-600">
                            No Image
                        </div>
                    @endif
                    <div class="p-4 flex-grow">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold">{{ $item->name }}</h3>
                            <button class="ml-auto text-gray-400 hover:text-primary transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6 2a2 2 0 0 0-2 2v18l8-5.333L20 22V4a2 2 0 0 0-2-2H6z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <p class="text-sm text-gray-500">{{ $item->location }}</p>
                        <p class="font-bold mt-2">{!! $symbolDisplay !!}</p>
                    </div>
                </div>                
            @endforeach        
            @endif
        </div>        
    </section>

    @include('components.footer')

    <script src="js/script.js"></script>
</body>
</html>
@endsection
