@extends('layouts.app')

@section('title', 'Destination - Flights')

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
                <form action="{{ route('destination-flight.search') }}" method="POST">
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
        @if(isset($flights) && $flights->count())
            <h2 class="text-l text-gray-700 mb-4 px-4">
                <span class="font-semibold">{{ $origin }} → {{ $destination }}</span> –
                {{ $flights->count() }} penerbangan ditemukan pada tanggal {{ \Carbon\Carbon::parse($departureDate)->format('d M Y') }}
            </h2>
        @elseif(request()->has('origin'))
            <h2 class="text-l text-gray-700 mb-4 px-4">
                <span class="font-semibold">{{ $origin }} → {{ $destination }}</span> –
                Tidak ada penerbangan ditemukan untuk tanggal {{ \Carbon\Carbon::parse($departureDate)->format('d M Y') }}
            </h2>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-4">
            @if(isset($flights) && $flights->count())
                @foreach($flights as $flight)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                        <div class="p-4 flex-grow">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-semibold">{{ $flight->airline }}</h3>
                                <button onclick="openSaveModal('{{ $flight->flight_id }}')" 
                                        class="ml-auto text-gray-400 hover:text-primary transition duration-200" 
                                        title="Simpan ke Planning">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6 2a2 2 0 0 0-2 2v18l8-5.333L20 22V4a2 2 0 0 0-2-2H6z"/>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-sm text-gray-500">Dari {{ $flight->origin }} ke {{ $flight->destination }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                Berangkat: {{ \Carbon\Carbon::parse($flight->departure_time)->format('d M Y H:i') }}<br>
                                Tiba: {{ \Carbon\Carbon::parse($flight->arrival_time)->format('d M Y H:i') }}
                            </p>
                            <p class="text-primary font-bold mt-2">Rp{{ number_format($flight->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <!-- Modal Save to Planning -->
    <div id="saveModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg w-[90%] max-w-md p-6 relative">
            <button onclick="closeSaveModal()" class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-xl">
                &times;
            </button>
            <h2 class="text-lg font-bold mb-2">Item berhasil disimpan!</h2>
            <p class="text-sm text-gray-600 mb-4">Tambahkan item ini ke planning Anda:</p>

            <div id="planningList" class="space-y-3 max-h-60 overflow-y-auto">
                @foreach ($userPlannings ?? [] as $plan)
                    <div class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 cursor-pointer planning-option" data-list-id="{{ $plan->list_id }}">
                        <div class="flex items-center space-x-3">
                            <div>
                                <div class="font-semibold">{{ $plan->list_name }}</div>
                                <div class="text-sm text-gray-500">{{ $plan->departure_city }} → {{ $plan->destination_city }}</div>
                            </div>
                        </div>
                        @if ($plan->image)
                            <img src="data:image/jpeg;base64,{{ base64_encode($plan->image) }}"
                                 alt="Planning Image"
                                 class="w-12 h-12 object-cover rounded"/>
                        @else
                            <div class="w-12 h-12 bg-gray-300 flex items-center justify-center text-xs text-gray-600 rounded">
                                No Image
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('components.footer')

    <script src="js/script.js"></script>
    <script>
        let selectedFlightId = null;

        function openSaveModal(flightId) {
            selectedFlightId = flightId;
            const modal = document.getElementById('saveModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeSaveModal() {
            const modal = document.getElementById('saveModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function saveToPlan(flightId, listId) {
            fetch('/itinerary-flights', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    flight_id: flightId,
                    list_id: listId
                })
            }).then(res => {
                if (res.ok) {
                    alert('Item berhasil ditambahkan ke planning!');
                    closeSaveModal();
                } else {
                    alert('Gagal menyimpan item ke planning.');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.planning-option').forEach(el => {
                el.addEventListener('click', () => {
                    const listId = el.getAttribute('data-list-id');
                    if (selectedFlightId && listId) {
                        saveToPlan(selectedFlightId, listId);
                    }
                });
            });
        });
    </script>

</body>
</html>
@endsection
