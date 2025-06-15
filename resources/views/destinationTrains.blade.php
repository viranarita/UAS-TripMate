@extends('layouts.app')

@section('title', 'Destination - Trains')

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
                <form action="{{ route('destination-trains.search') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700">Kota Asal</label>
                        <input type="text" name="origin" required value="{{ old('origin', $origin ?? '') }}"
                               class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Kota Tujuan</label>
                        <input type="text" name="destination" required value="{{ old('destination', $destination ?? '') }}"
                               class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Kelas Kereta</label>
                        <select name="train_type" class="w-full px-3 py-2 border rounded">
                            <option value="">-- Semua Kelas --</option>
                            <option value="Ekonomi" {{ (old('train_type', $trainType ?? '') == 'Ekonomi') ? 'selected' : '' }}>Ekonomi</option>
                            <option value="Bisnis" {{ (old('train_type', $trainType ?? '') == 'Bisnis') ? 'selected' : '' }}>Bisnis</option>
                            <option value="Eksekutif" {{ (old('train_type', $trainType ?? '') == 'Eksekutif') ? 'selected' : '' }}>Eksekutif</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Tanggal Keberangkatan</label>
                        <input type="date" name="departure_date" required value="{{ old('departure_date', $departureDate ?? '') }}"
                               class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="pb-8 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        @if(isset($trains) && $trains->count())
            <h2 class="text-l text-gray-700 mb-4 px-4">
                <span class="font-semibold">{{ $origin }} → {{ $destination }}</span> –
                {{ $trains->count() }} kereta ditemukan pada tanggal {{ \Carbon\Carbon::parse($departureDate)->format('d M Y') }}
            </h2>
        @elseif(request()->has('origin'))
            <h2 class="text-l text-gray-700 mb-4 px-4">
                <span class="font-semibold">{{ $origin }} → {{ $destination }}</span> –
                Tidak ada kereta ditemukan untuk tanggal {{ \Carbon\Carbon::parse($departureDate)->format('d M Y') }}
            </h2>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-4">
            @if(isset($trains) && $trains->count())
                @foreach($trains as $train)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                        <div class="p-4 flex-grow">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-semibold">{{ $train->train_name }} ({{ $train->train_type }})</h3>
                                <button class="ml-auto text-gray-400 hover:text-primary transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6 2a2 2 0 0 0-2 2v18l8-5.333L20 22V4a2 2 0 0 0-2-2H6z"/>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-sm text-gray-500">Dari {{ $train->origin }} ke {{ $train->destination }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                Berangkat: {{ \Carbon\Carbon::parse($train->departure_time)->format('d M Y H:i') }}<br>
                                Tiba: {{ \Carbon\Carbon::parse($train->arrival_time)->format('d M Y H:i') }}
                            </p>
                            <p class="text-primary font-bold mt-2">Rp{{ number_format($train->price, 0, ',', '.') }}</p>
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
