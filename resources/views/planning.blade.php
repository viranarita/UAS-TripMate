@extends('layouts.app')

@section('title', 'Planning')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>Planning | TripMate</title>
    <link rel="stylesheet" href="style.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">

    <script>
        const IS_LOGGED_IN = {{ Auth::check() ? 'true' : 'false' }};
    </script>

    <section class="pt-24 w-full">
        <div class="container mx-auto flex flex-col lg:flex-row justify-center items-start gap-8 min-h-screen">
            <!-- FORM -->
            <div class="w-full lg:w-1/2 p-8 bg-white rounded-2xl shadow-xl">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Plan Your Trip</h2>
                <form method="POST" action="{{ url('/planning') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
                    @csrf
                    <input type="hidden" name="list_id" id="list_id">
                    <div class="grid grid-cols-1 gap-8">
                        <div>
                            <label class="block text-gray-700">Itinerary Name</label>
                            <input type="text" name="list_name" id="list_name" required class="w-full px-3 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700">Departure Date</label>
                            <input type="date" name="departure_date" id="departure_date" required class="w-full px-3 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700">Return Date</label>
                            <input type="date" name="return_date" id="return_date" required class="w-full px-3 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700">Trip Days</label>
                            <input type="text" id="trip_days" readonly class="w-full px-3 py-2 border rounded bg-gray-100">
                        </div>
                        <div>
                            <label class="block text-gray-700">Departure City</label>
                            <select name="departure_city" id="departure_city" required class="w-full px-3 py-2 border rounded">
                                <option value="">Pilih Kota</option>
                                <option value="Surabaya">Surabaya</option>
                                <option value="Jakarta">Jakarta</option>
                                <option value="Bandung">Bandung</option>
                                <option value="Yogyakarta">Yogyakarta</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700">Destination City</label>
                            <select name="destination_city" id="destination_city" required class="w-full px-3 py-2 border rounded">
                                <option value="">Pilih Kota</option>
                                <option value="Surabaya">Surabaya</option>
                                <option value="Jakarta">Jakarta</option>
                                <option value="Bandung">Bandung</option>
                                <option value="Yogyakarta">Yogyakarta</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700">Gambar</label>
                            <input type="file" name="image" id="image" accept=".jpg,.jpeg" class="w-full px-3 py-2 border rounded">
                            <!-- Preview gambar -->
                            <div id="imagePreview" class="mt-2">
                                <!-- nanti diisi gambar -->
                            </div>
                        </div>
                    </div>
    
                    <div class="mt-4 flex justify-between">
                        <button type="submit" name="tambah" id="addBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah</button>
                        <button type="submit" name="update" id="updateBtn" class="bg-green-500 text-white px-4 py-2 rounded hidden">Update</button>
                        <button type="button" onclick="resetForm()" class="bg-gray-400 text-white px-4 py-2 rounded">Reset</button>
                    </div>
                </form>
            </div>
    
            <!-- TABEL -->
            {{-- <div class="w-full lg:w-1/2 bg-white p-4 rounded-2xl shadow-xl overflow-x-auto">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Your Plan</h2>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-red-600 text-white">
                            <th class="p-2 border">Nama</th>
                            <th class="p-2 border">Pergi</th>
                            <th class="p-2 border">Kembali</th>
                            <th class="p-2 border">Durasi</th>
                            <th class="p-2 border">Asal</th>
                            <th class="p-2 border">Tujuan</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plans as $plan)
                        <tr class="text-center hover:bg-gray-100 cursor-pointer" onclick='editData(@json($plan))'>
                            <td class="p-2 border">{{ $plan->list_name }}</td>
                            <td class="p-2 border">{{ $plan->departure_date }}</td>
                            <td class="p-2 border">{{ $plan->return_date }}</td>
                            <td class="p-2 border">{{ (new \Carbon\Carbon($plan->departure_date))->diffInDays(new \Carbon\Carbon($plan->return_date)) }}</td>
                            <td class="p-2 border">{{ $plan->departure_city }}</td>
                            <td class="p-2 border">{{ $plan->destination_city }}</td>
                            <td class="p-2 border">
                                <form method="POST" action="{{ url('/planning/' . $plan->list_id) }}" onsubmit="return confirm('Hapus itinerary ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}
        </div>
    </section>
    
    <script>
    function editData(data) {
        document.getElementById("list_id").value = data.list_id;
        document.getElementById("list_name").value = data.list_name;
        document.getElementById("departure_date").value = data.departure_date;
        document.getElementById("return_date").value = data.return_date;
        document.getElementById("departure_city").value = data.departure_city;
        document.getElementById("destination_city").value = data.destination_city;
        calculateDays();
    
        document.getElementById("addBtn").classList.add("hidden");
        document.getElementById("updateBtn").classList.remove("hidden");
    }
    
    function resetForm() {
        document.getElementById("list_id").value = "";
        document.getElementById("list_name").value = "";
        document.getElementById("departure_date").value = "";
        document.getElementById("return_date").value = "";
        document.getElementById("trip_days").value = "";
        document.getElementById("departure_city").value = "";
        document.getElementById("destination_city").value = "";
    
        document.getElementById("addBtn").classList.remove("hidden");
        document.getElementById("updateBtn").classList.add("hidden");
    }
    
    document.getElementById('departure_date').addEventListener('change', calculateDays);
    document.getElementById('return_date').addEventListener('change', calculateDays);
    
    function calculateDays() {
        const dep = new Date(document.getElementById('departure_date').value);
        const ret = new Date(document.getElementById('return_date').value);
        const tripDaysInput = document.getElementById('trip_days');

        if (!isNaN(dep) && !isNaN(ret)) {
            if (ret >= dep) {
                const diffDays = Math.ceil((ret - dep) / (1000 * 60 * 60 * 24));
                tripDaysInput.value = diffDays;
                tripDaysInput.classList.remove("border-red-500");
            } else {
                tripDaysInput.value = "";
                tripDaysInput.classList.add("border-red-500");
                alert("Tanggal kembali harus lebih besar dari tanggal pergi.");
            }
        } else {
            tripDaysInput.value = "";
            tripDaysInput.classList.remove("border-red-500");
        }
    }
    function validateForm() {
        const dep = new Date(document.getElementById('departure_date').value);
        const ret = new Date(document.getElementById('return_date').value);

        if (!IS_LOGGED_IN) {
            alert("Harap login terlebih dahulu.");
            return false;
        }

        if (ret < dep) {
            alert("Tanggal kembali harus setelah atau sama dengan tanggal pergi.");
            return false;
        }

        return true;
    }

    </script>

</body>
</html>

@endsection
