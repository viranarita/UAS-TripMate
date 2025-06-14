@extends('layouts.app')

@section('title', 'Destination - Hotel')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>TripMate</title>
    <link rel="stylesheet" href="style.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">

    @include('components.navbardestination')

    <section class="pt-8 pb-8 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        <div class="flex">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                <form id="hotel-search-form" action="{{ route('destination-hotel.search') }}" method="POST">
                    @csrf
                    <div>
                        <label class="block text-gray-700">Nama Kota</label>
                        <input type="text" id="city" name="city" required class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-gray-700">Durasi (malam)</label>
                        <select id="duration" name="duration" required class="w-full px-3 py-2 border rounded">
                            <option value="1">1 malam</option>
                            <option value="2">2 malam</option>
                            <option value="3">3 malam</option>
                            <option value="4">4 malam</option>
                            <option value="5">5 malam</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700">Jumlah Kamar</label>
                        <input type="number" id="rooms" name="rooms" min="1" value="1" required class="w-full px-3 py-2 border rounded">
                    </div>
                
                    <div class="mt-4 flex justify-center">
                        <button type="submit" id="addBtn" class="bg-primary text-white px-4 py-2 rounded">Cari</button>
                    </div>    
                </form>                
            </div>
        </div>
    </section>
    <section class="pb-8 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        @if(isset($hotels) && $hotels->count())
            <h2 class="text-l text-gray-700 mb-4 px-4">
                <span class="font-semibold">{{ $city }}</span> – {{ $hotels->count() }} hotel ditemukan
            </h2>
        @elseif(request()->has('city'))
            <h2 class="text-l text-gray-700 mb-4 px-4">
                <span class="font-semibold">{{ $city }}</span> – Tidak ada hotel ditemukan
            </h2>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @if(isset($hotels) && $hotels->count())
                @foreach($hotels as $hotel)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if($hotel->image_url)
                            <img src="data:image/jpeg;base64,{{ base64_encode($hotel->image_url) }}" class="w-full h-48 object-cover" alt="{{ $hotel->name }}">
                        @else
                            <div class="w-full h-48 bg-gray-300 flex items-center justify-center text-gray-600">No Image</div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $hotel->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $hotel->location }}</p>
                            <p class="text-primary font-bold mt-2">Rp{{ number_format($hotel->price_per_night, 0, ',', '.') }} / malam</p>
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
