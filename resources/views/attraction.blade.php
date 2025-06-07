@php
    $pageTitle = 'Attractions';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>Admin | Manage Attractions</title>
    <link rel="stylesheet" href="style.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    
    @include('components.headerAdmin')
    @include('components.sidebar')

    <section class="pt-24 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        <div class="flex justify-center mt-4">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                <form method="POST" action="{{ url('/attraction') }}" enctype="multipart/form-data" id="attractionForm">
                    @csrf
                    <input type="hidden" name="attraction_id" id="attractionId">
                    <input type="hidden" name="old_image" id="oldImage"> <!-- untuk simpan gambar lama -->
                    <input type="hidden" name="_method" id="_method" value="POST"> <!-- default POST -->
                
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
                            <label class="block text-gray-700">Harga</label>
                            <input type="number" name="price" id="price" required class="w-full px-3 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700">Gambar (JPG saja)</label>
                            <input type="file" name="image_url" id="image_url" accept=".jpg,.jpeg" class="w-full px-3 py-2 border rounded">
                            <!-- Preview gambar -->
                            <div id="imagePreview" class="mt-2">
                                <!-- nanti diisi gambar -->
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
                        <tr class="bg-red-600 text-white">
                            <th class="p-2 border">ID</th>
                            <th class="p-2 border">Nama</th>
                            <th class="p-2 border">Lokasi (Kota)</th>
                            <th class="p-2 border">Harga</th>
                            <th class="p-2 border">Gambar</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attractions as $item)
                            <tr>
                                <td class="p-2 border">{{ $item->attraction_id }}</td>
                                <td class="p-2 border">{{ $item->name }}</td>
                                <td class="p-2 border">{{ $item->location }}</td>
                                <td class="p-2 border">Rp{{ number_format($item->price, 2, ',', '.') }}</td>
                                <td class="p-2 border">
                                    @if($item->image_url)
                                        <img src="data:image/jpeg;base64,{{ base64_encode($item->image_url) }}" alt="gambar" class="w-20 h-auto">
                                    @else
                                        <span class="text-gray-500">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="p-2 border text-center space-x-2">
                                    <button 
                                    type="button" 
                                    onclick="editAttraction(
                                        '{{ $item->attraction_id }}', 
                                        '{{ addslashes($item->name) }}', 
                                        '{{ addslashes($item->location) }}', 
                                        '{{ $item->price }}', 
                                        '{{ base64_encode($item->image_url) }}'
                                    )" 
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded"
                                    > Edit </button>

                                    <form action="{{ url('/attraction/' . $item->attraction_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
    function editAttraction(id, name, location, price, imageData) {
        document.getElementById("attractionId").value = id;
        document.getElementById("name").value = name;
        document.getElementById("location").value = location;
        document.getElementById("price").value = price;

        // Set action form ke /attraction/{id} dan method PUT
        const form = document.getElementById("attractionForm");
        form.action = '/attraction/' + id;
        document.getElementById('_method').value = 'PUT';

        // Simpan gambar lama (base64) ke hidden input old_image
        document.getElementById("oldImage").value = imageData;

        // Tampilkan preview gambar lama
        const previewDiv = document.getElementById('imagePreview');
        previewDiv.innerHTML = `
            <img src="data:image/jpeg;base64,${imageData}" alt="Preview Gambar" class="w-40 h-auto rounded mt-2">
        `;

        // Kosongkan file input
        document.getElementById('image_url').value = "";

        document.getElementById("addBtn").classList.add("hidden");
        document.getElementById("updateBtn").classList.remove("hidden");
    }

    function resetForm() {
        document.getElementById("attractionId").value = "";
        document.getElementById("name").value = "";
        document.getElementById("location").value = "";
        document.getElementById("price").value = "";
        document.getElementById("image_url").value = "";
        document.getElementById("oldImage").value = "";
        document.getElementById('_method').value = 'POST';

        document.getElementById("attractionForm").action = "{{ url('/attraction') }}";

        document.getElementById('imagePreview').innerHTML = "";

        document.getElementById("addBtn").classList.remove("hidden");
        document.getElementById("updateBtn").classList.add("hidden");
    }

    // Preview gambar saat pilih file baru
    document.getElementById('image_url').addEventListener('change', function(){
        const fileInput = this;
        const previewDiv = document.getElementById('imagePreview');
        if(fileInput.files && fileInput.files[0]){
            const file = fileInput.files[0];
            if(!file.name.toLowerCase().endsWith('.jpg') && !file.name.toLowerCase().endsWith('.jpeg')){
                alert('Masukkan file JPG saja.');
                fileInput.value = "";
                previewDiv.innerHTML = "";
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e){
                previewDiv.innerHTML = `
                    <img src="${e.target.result}" alt="Preview Gambar" class="w-40 h-auto rounded mt-2">
                    
                `;
            };
            reader.readAsDataURL(file);
        } else {
            // Kalau file dihapus, hapus preview
            previewDiv.innerHTML = "";
        }
    });
</script>


</body>
</html>