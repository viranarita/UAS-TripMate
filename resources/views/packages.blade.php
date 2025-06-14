@php
    $pageTitle = 'Packages';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>Admin | Manage Packages</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body class="bg-gray-100">

    @include('components.headerAdmin')
    @include('components.sidebar')

    <section class="pt-24 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        <div class="flex justify-center mt-4">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                <form method="POST" action="{{ url('/packages') }}" id="packageForm">
                    @csrf
                    <input type="hidden" name="package_id" id="packageId">
                    <input type="hidden" name="_method" id="_method" value="POST">

                    <div class="grid grid-cols-1 gap-8">
                        <div>
                            <label class="block text-gray-700">Nama Paket</label>
                            <input type="text" name="name" id="name" required class="w-full px-3 py-2 border rounded" />
                        </div>
                        <div>
                            <label class="block text-gray-700">Detail</label>
                            <textarea name="details" id="details" required class="w-full px-3 py-2 border rounded"></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700">Harga</label>
                            <input type="number" step="0.01" name="price" id="price" required class="w-full px-3 py-2 border rounded" />
                        </div>
                        <div>
                            <label class="block text-gray-700">Kota</label>
                            <input type="text" name="city" id="city" required class="w-full px-3 py-2 border rounded" />
                        </div>
                        <div>
                            <label class="blocktext-gray-700">Tanggal Keberangkatan</label>
                            <input type="date" name="departure_date" id="departure_date" required class="w-full px-3 py-2 border rounded" />
                        </div>  
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700">Durasi Hari</label>
                                <input type="number" name="days" id="days" min="1" required class="w-full px-3 py-2 border rounded" />
                            </div>
                            <div>
                                <label class="block text-gray-700">Durasi Malam</label>
                                <input type="number" name="nights" id="nights" min="0" required class="w-full px-3 py-2 border rounded" />
                            </div> 
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

        <div class="flex justify-center mt-4 mb-4">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="p-2 border">ID</th>
                            <th class="p-2 border">Nama Paket</th>
                            <th class="p-2 border">Detail</th>
                            <th class="p-2 border">Harga</th>
                            <th class="p-2 border">Kota</th>
                            <th class="p-2 border">Keberangkatan</th>
                            <th class="p-2 border">Durasi</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $item)
                            <tr>
                                <td class="p-2 border">{{ $item->package_id }}</td>
                                <td class="p-2 border">{{ $item->name }}</td>
                                <td class="p-2 border">{{ $item->details }}</td>
                                <td class="p-2 border">Rp{{ number_format($item->price, 2, ',', '.') }}</td>
                                <td class="p-2 border">{{ $item->city }}</td>
                                <td class="p-2 border">{{ \Carbon\Carbon::parse($item->departure_date)->format('d-m-Y') }}</td>
                                <td class="p-2 border">{{ $item->days }} hari {{ $item->nights }} malam</td>
                                <td class="p-2 border text-center space-x-2">
                                    <button
                                        type="button"
                                        onclick="editPackage(
                                            '{{ $item->package_id }}',
                                            '{{ addslashes($item->name) }}',
                                            '{{ addslashes($item->details) }}',
                                            '{{ $item->price }}',
                                            '{{ addslashes($item->city) }}',
                                            '{{ $item->days }}',
                                            '{{ $item->nights }}',
                                            '{{ $item->departure_date }}'
                                        )"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded">Edit</button>

                                    <form action="{{ url('/packages/' . $item->package_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script>
    function editPackage(id, name, details, price, city, days, nights) {
        document.getElementById("packageId").value = id;
        document.getElementById("name").value = name;
        document.getElementById("details").value = details;
        document.getElementById("price").value = price;
        document.getElementById("city").value = city;
        document.getElementById("days").value = days;
        document.getElementById("nights").value = nights;
        document.getElementById("departure_date").value = departure_date;

        const form = document.getElementById("packageForm");
        form.action = '/packages/' + id;
        document.getElementById('_method').value = 'PUT';

        document.getElementById("addBtn").classList.add("hidden");
        document.getElementById("updateBtn").classList.remove("hidden");
    }


    function resetForm() {
        document.getElementById("packageId").value = "";
        document.getElementById("name").value = "";
        document.getElementById("details").value = "";
        document.getElementById("price").value = "";
        document.getElementById("city").value = "";
        document.getElementById("days").value = "";
        document.getElementById("nights").value = "";
        document.getElementById("departure_date").value = "";
        document.getElementById('_method').value = 'POST';

        document.getElementById("packageForm").action = "{{ url('/package') }}";

        document.getElementById("addBtn").classList.remove("hidden");
        document.getElementById("updateBtn").classList.add("hidden");
    }
    </script>
</body>
</html>
