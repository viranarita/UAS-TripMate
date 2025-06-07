@php
    $pageTitle = 'Hotels';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>Admin | Manage Hotels</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body class="bg-gray-100">
    
    @include('components.headerAdmin')
    @include('components.sidebar')

    <section class="pt-24 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        <div class="flex justify-center mt-4">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                <form method="POST" action="{{ url('/hotel') }}" enctype="multipart/form-data" id="hotelForm">
                    @csrf
                    <input type="hidden" name="hotel_id" id="hotelId">
                    <input type="hidden" name="old_image" id="oldImage">
                    <input type="hidden" name="_method" id="_method" value="POST">

                    <div class="grid grid-cols-1 gap-8">
                        <div>
                            <label class="block text-gray-700">Nama</label>
                            <input type="text" name="name" id="name" required class="w-full px-3 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700">Lokasi (Kota)</label>
                            <input type="text" name="location" id="location" required class="w-full px-3 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700">Harga per Malam</label>
                            <input type="number" name="price_per_night" id="price_per_night" required class="w-full px-3 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700">Gambar (JPG saja)</label>
                            <input type="file" name="image_url" id="image_url" accept=".jpg,.jpeg" class="w-full px-3 py-2 border rounded">
                            <div id="imagePreview" class="mt-2"></div>
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
                        <tr class="bg-red-600 text-white">
                            <th class="p-2 border">ID</th>
                            <th class="p-2 border">Nama</th>
                            <th class="p-2 border">Lokasi</th>
                            <th class="p-2 border">Harga</th>
                            <th class="p-2 border">Gambar</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hotels as $item)
                        <tr>
                            <td class="p-2 border">{{ $item->hotel_id }}</td>
                            <td class="p-2 border">{{ $item->name }}</td>
                            <td class="p-2 border">{{ $item->location }}</td>
                            <td class="p-2 border">Rp{{ number_format($item->price_per_night, 2, ',', '.') }}</td>
                            <td class="p-2 border">
                                @if($item->image_url)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($item->image_url) }}" alt="gambar" class="w-20 h-auto">
                                @else
                                    <span class="text-gray-500">Tidak ada</span>
                                @endif
                            </td>
                            <td class="p-2 border text-center space-x-2">
                                <button type="button" 
                                    onclick="editHotel(
                                        '{{ $item->hotel_id }}',
                                        '{{ addslashes($item->name) }}',
                                        '{{ addslashes($item->location) }}',
                                        '{{ $item->price_per_night }}',
                                        '{{ base64_encode($item->image_url) }}'
                                    )"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded">Edit</button>

                                <form action="{{ url('/hotel/' . $item->hotel_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
    function editHotel(id, name, location, price, imageData) {
        document.getElementById("hotelId").value = id;
        document.getElementById("name").value = name;
        document.getElementById("location").value = location;
        document.getElementById("price_per_night").value = price;
        document.getElementById("oldImage").value = imageData;
        document.getElementById("imagePreview").innerHTML = `<img src="data:image/jpeg;base64,${imageData}" class="w-40 h-auto rounded mt-2">`;

        document.getElementById("hotelForm").action = "/hotel/" + id;
        document.getElementById("_method").value = "PUT";

        document.getElementById("addBtn").classList.add("hidden");
        document.getElementById("updateBtn").classList.remove("hidden");
    }

    function resetForm() {
        document.getElementById("hotelId").value = "";
        document.getElementById("name").value = "";
        document.getElementById("location").value = "";
        document.getElementById("price_per_night").value = "";
        document.getElementById("image_url").value = "";
        document.getElementById("oldImage").value = "";
        document.getElementById("_method").value = "POST";
        document.getElementById("hotelForm").action = "{{ url('/hotel') }}";
        document.getElementById("imagePreview").innerHTML = "";

        document.getElementById("addBtn").classList.remove("hidden");
        document.getElementById("updateBtn").classList.add("hidden");
    }

    document.getElementById("image_url").addEventListener("change", function () {
        const file = this.files[0];
        const preview = document.getElementById("imagePreview");
        if (file) {
            if (!file.name.toLowerCase().endsWith(".jpg") && !file.name.toLowerCase().endsWith(".jpeg")) {
                alert("Masukkan file JPG saja.");
                this.value = "";
                preview.innerHTML = "";
                return;
            }
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.innerHTML = `<img src="${e.target.result}" class="w-40 h-auto rounded mt-2">`;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = "";
        }
    });
    </script>
</body>
</html>
