@extends('layouts.app')

@section('title', 'Destination - Attraction')

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

    <section class="pt-8 pb-8 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        <div class="flex">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                <form id="attraction-search-form" action="{{ route('destination-attraction.search') }}" method="POST">
                    @csrf
                    <div>
                        <label class="block text-gray-700">Nama Kota</label>
                        <input type="text" id="city" name="city" required class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="mt-4 flex justify-center">
                        <button type="submit" id="searchBtn" class="bg-primary text-white px-4 py-2 rounded">Cari</button>
                    </div>    
                </form>                
            </div>
        </div>
    </section>

    <section class="pb-8 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        @if(isset($attractions) && $attractions->count())
            <h2 class="text-l text-gray-700 mb-4 px-4">
                <span class="font-semibold">{{ $city }}</span> – {{ $attractions->count() }} tempat wisata ditemukan
            </h2>
        @elseif(request()->has('city'))
            <h2 class="text-l text-gray-700 mb-4 px-4">
                <span class="font-semibold">{{ $city }}</span> – Tidak ada tempat wisata ditemukan
            </h2>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-4">
            @if(isset($attractions) && $attractions->count())
                @foreach($attractions as $attraction)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                        @if($attraction->image_url)
                            <div class="w-full h-[200px]">
                                <img src="data:image/jpeg;base64,{{ base64_encode($attraction->image_url) }}"
                                    alt="{{ $attraction->name }}"
                                    class="w-full h-full object-cover"/>
                            </div>
                        @else
                            <div class="w-full h-[200px] bg-gray-300 flex items-center justify-center text-gray-600">
                                No Image
                            </div>
                        @endif
                        <div class="p-4 flex-grow">
                            <h3 class="text-lg font-semibold">{{ $attraction->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $attraction->location }}</p>
                            <p class="text-primary font-bold mt-2">Rp{{ number_format($attraction->price, 0, ',', '.') }}</p>
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
