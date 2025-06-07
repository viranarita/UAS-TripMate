@php
    $pageTitle = 'Flights';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>Admin | Manage Flights</title>
    <link rel="stylesheet" href="style.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">

    @include('components.headerAdmin')
    @include('components.sidebar')

    <section class="pt-24 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        <!-- Form Input -->
        <div class="flex justify-center mt-4">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                <form method="POST" id="flightForm" action="{{ route('flights.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="flightId" id="flightId">

                    <div class="grid grid-cols-1 gap-8">
                        <div>
                            <label class="block text-gray-700">Maskapai</label>
                            <input type="text" name="airline" id="airline" required class="w-full px-3 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700">Waktu Keberangkatan</label>
                            <input type="datetime-local" name="departure_time" id="departure_time" required class="w-full px-3 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700">Waktu Kedatangan</label>
                            <input type="datetime-local" name="arrival_time" id="arrival_time" required class="w-full px-3 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700">Asal</label>
                            <input type="text" name="origin" id="origin" required class="w-full px-3 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700">Tujuan</label>
                            <input type="text" name="destination" id="destination" required class="w-full px-3 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700">Harga</label>
                            <input type="number" name="price" id="price" required class="w-full px-3 py-2 border rounded" step="0.01">
                        </div>
                    </div>

                    <div class="mt-4 flex justify-between">
                        <button type="submit" id="addBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah</button>
                        <button type="submit" id="updateBtn" class="bg-green-500 text-white px-4 py-2 rounded hidden">Update</button>
                        <button type="button" onclick="resetForm()" class="bg-gray-400 text-white px-4 py-2 rounded">Reset</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel -->
        <div class="flex justify-center mt-4 mb-4">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="p-2 border">ID</th>
                            <th class="p-2 border">Maskapai</th>
                            <th class="p-2 border">Keberangkatan</th>
                            <th class="p-2 border">Kedatangan</th>
                            <th class="p-2 border">Asal</th>
                            <th class="p-2 border">Tujuan</th>
                            <th class="p-2 border">Harga</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($flights as $flight)
                        <tr>
                            <td class="p-2 border">{{ $flight->flight_id }}</td>
                            <td class="p-2 border">{{ $flight->airline }}</td>
                            <td class="p-2 border">{{ $flight->departure_time }}</td>
                            <td class="p-2 border">{{ $flight->arrival_time }}</td>
                            <td class="p-2 border">{{ $flight->origin }}</td>
                            <td class="p-2 border">{{ $flight->destination }}</td>
                            <td class="p-2 border">{{ $flight->price }}</td>
                            <td class="p-2 border">
                                <div class="flex gap-2">
                                    <button 
                                        onclick="editFlight(
                                            '{{ $flight->flight_id }}',
                                            '{{ $flight->airline }}',
                                            '{{ $flight->departure_time }}',
                                            '{{ $flight->arrival_time }}',
                                            '{{ $flight->origin }}',
                                            '{{ $flight->destination }}',
                                            '{{ $flight->price }}'
                                        )"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-3 py-1 rounded transition duration-200"
                                    >Edit</button>
    
                                    <form method="POST" action="{{ route('flights.destroy', $flight->flight_id) }}" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded transition duration-200"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>                       
                </table>
            </div>
        </div>
    </section>

    <script>
        function editFlight(flight_id, airline, departure_time, arrival_time, origin, destination, price) {
            document.getElementById("flightForm").action = `/flights/${flight_id}`;
            document.getElementById("formMethod").value = "PUT";

            document.getElementById("flightId").value = flight_id;
            document.getElementById("airline").value = airline;
            document.getElementById("departure_time").value = departure_time.replace(" ", "T");
            document.getElementById("arrival_time").value = arrival_time.replace(" ", "T");
            document.getElementById("origin").value = origin;
            document.getElementById("destination").value = destination;
            document.getElementById("price").value = price;

            document.getElementById("addBtn").classList.add("hidden");
            document.getElementById("updateBtn").classList.remove("hidden");
        }

        function resetForm() {
            document.getElementById("flightForm").action = "{{ route('flights.store') }}";
            document.getElementById("formMethod").value = "POST";

            document.getElementById("flightId").value = "";
            document.getElementById("airline").value = "";
            document.getElementById("departure_time").value = "";
            document.getElementById("arrival_time").value = "";
            document.getElementById("origin").value = "";
            document.getElementById("destination").value = "";
            document.getElementById("price").value = "";

            document.getElementById("addBtn").classList.remove("hidden");
            document.getElementById("updateBtn").classList.add("hidden");
        }
    </script>

</body>
</html>
