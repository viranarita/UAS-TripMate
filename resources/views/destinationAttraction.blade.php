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

    <!-- Form Pencarian -->
    <section class="pt-8 pb-8 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        <div class="flex">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                <form action="{{ route('destination-attraction.search') }}" method="POST">
                    @csrf
                    <div>
                        <label class="block text-gray-700">Nama Kota</label>
                        <input type="text" id="city" name="city" required
                            value="{{ old('city', $city ?? '') }}"
                            class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="mt-4 flex justify-center">
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Hasil Pencarian -->
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
            @foreach($attractions ?? [] as $item)
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
                            <h3 class="text-lg font-semibold truncate">{{ $item->name }}</h3>
                            <button onclick="openSaveModal('{{ $item->attraction_id }}')"
                                    class="ml-auto text-gray-400 hover:text-primary transition duration-200"
                                    title="Simpan ke Planning">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6 2a2 2 0 0 0-2 2v18l8-5.333L20 22V4a2 2 0 0 0-2-2H6z"/>
                                </svg>
                            </button>
                        </div>
                        <p class="text-sm text-gray-500">{{ $item->location }}</p>
                        <p class="text-primary font-bold mt-2">Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
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
        let selectedAttractionId = null;

        function openSaveModal(attractionId) {
            selectedAttractionId = attractionId;
            const modal = document.getElementById('saveModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeSaveModal() {
            const modal = document.getElementById('saveModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function saveToPlan(attractionId, listId) {
            fetch('/itinerary-attractions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    attraction_id: attractionId,
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

        // Event listener ke semua item planning
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.planning-option').forEach(el => {
                el.addEventListener('click', () => {
                    const listId = el.getAttribute('data-list-id');
                    if (selectedAttractionId && listId) {
                        saveToPlan(selectedAttractionId, listId);
                    }
                });
            });
        });
    </script>
    
</body>
</html>
@endsection
