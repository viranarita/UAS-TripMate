@extends('layouts.app')

@section('title', 'Destination - Packages')

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
                <form action="{{ route('destination-package.search') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700">Tujuan</label>
                        <input type="text" name="city" required value="{{ old('city', $city ?? '') }}" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Tanggal Keberangkatan</label>
                        <input type="date" name="departure_date" required value="{{ old('departure_date', $departureDate ?? '') }}"
                               class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Durasi Paket (Hari)</label>
                        <input type="number" name="duration_days" min="1" value="{{ old('duration_days', $durationDays ?? '') }}"
                               class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Cari Paket</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Hasil Pencarian -->
    <section class="pb-8 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        @if(request()->has('city'))
            @if(isset($packages) && $packages->count())
                <h2 class="text-l text-gray-700 mb-4 px-4">
                    <span class="font-semibold">{{ $city }}</span> –
                    {{ $packages->count() }} paket ditemukan untuk tanggal {{ \Carbon\Carbon::parse($departureDate)->format('d M Y') }}
                    @if(!empty($durationDays)) dengan durasi {{ $durationDays }} hari @endif
                </h2>
            @else
                @php
                    $otherPackages = isset($city)
                        ? \App\Models\Packages::where('city', 'like', '%' . $city . '%')->get()
                        : collect();
                @endphp
                @if($otherPackages->count())
                    <h2 class="text-l text-gray-700 mb-4 px-4">
                        <span class="font-semibold">{{ $city ?? '-' }}</span> – 
                        Tidak ada paket ditemukan untuk tanggal {{ \Carbon\Carbon::parse($departureDate)->format('d M Y') }}
                        @if(!empty($durationDays)), dengan durasi {{ $durationDays }} hari @endif.
                        <br>Coba ubah tanggal keberangkatan atau durasi.
                    </h2>
                @else
                    <h2 class="text-l text-gray-700 mb-4 px-4">
                        Tidak ada paket ditemukan ke kota <span class="font-semibold">{{ $city ?? '-' }}</span>.
                        <br>Coba masukkan tujuan lain.
                    </h2>
                @endif
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-4">
                @if(isset($packages) && $packages->count())
                    @foreach($packages as $package)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                            <div class="p-4 flex-grow">
                                <h3 class="text-lg font-semibold">{{ $package->package_name ?? 'Paket Liburan' }}</h3>
                                <p class="text-sm text-gray-500">Tujuan: {{ $package->city }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Keberangkatan: {{ \Carbon\Carbon::parse($package->departure_date)->format('d M Y') }}<br>
                                    Durasi: {{ $package->days }} hari
                                </p>
                                <p class="text-primary font-bold mt-2">Rp{{ number_format($package->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @endif
    </section>    

    @include('components.footer')

    <script src="js/script.js"></script>

</body>
</html>
@endsection
