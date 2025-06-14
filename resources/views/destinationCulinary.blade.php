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
        @if(isset($culinaries) && $culinaries->count())
            <h2 class="text-l text-gray-700 mb-4 px-4">
                <span class="font-semibold">{{ $city }}</span> – {{ $culinaries->count() }} kuliner ditemukan
            </h2>
        @elseif(request()->has('city'))
            <h2 class="text-l text-gray-700 mb-4 px-4">
                <span class="font-semibold">{{ $city }}</span> – Tidak ada kuliner ditemukan
            </h2>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-4">
            @if(isset($culinaries) && $culinaries->count())
                @foreach($culinaries as $culinary)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if($culinary->image_url)
                            <img src="data:image/jpeg;base64,{{ base64_encode($culinary->image_url) }}" class="w-full h-48 object-cover" alt="{{ $culinary->name }}">
                        @else
                            <div class="w-full h-48 bg-gray-300 flex items-center justify-center text-gray-600">No Image</div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $culinary->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $culinary->location }}</p>
                            <p class="text-primary font-bold mt-2">{{ $culinary->price_range }}</p>
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
