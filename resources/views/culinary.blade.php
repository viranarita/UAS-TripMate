@php
    $pageTitle = 'Culinaries';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>Admin | Manage Culinaries</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body class="bg-gray-100">
    
    @include('components.headerAdmin')
    @include('components.sidebar')

    <section class="pt-24 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        <div class="flex justify-center mt-4">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                <form method="POST" action="{{ url('/culinary') }}" enctype="multipart/form-data" id="culinaryForm">
                    @csrf
                    <input type="hidden" name="culinary_id" id="culinaryId">
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
                            <label class="block text-gray-700 mb-2">Harga</label>
                            <select name="price_range" id="price_range" required class="w-full px-3 py-2 border rounded">
                                <option value="Murah">Murah</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Mahal">Mahal</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700">Gambar (JPG)</label>
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
                            <th class="p-2 border">Lokasi (Kota)</th>
                            <th class="p-2 border">Harga</th>
                            <th class="p-2 border">Gambar</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($culinaries as $item)
                            <tr>
                                <td class="p-2 border">{{ $item->culinary_id }}</td>
                                <td class="p-2 border">{{ $item->name }}</td>
                                <td class="p-2 border">{{ $item->location }}</td>
                                <td class="p-2 border">{{ $item->price_range }}</td>
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
                                        onclick="editCulinary(
                                            '{{ $item->culinary_id }}',
                                            '{{ addslashes($item->name) }}',
                                            '{{ addslashes($item->location) }}',
                                            '{{ $item->price_range }}',
                                            '{{ base64_encode($item->image_url) }}'
                                        )"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded">Edit</button>

                                    <form action="{{ url('/culinary/' . $item->culinary_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display:inline-block;">
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
    function editCulinary(id, name, location, price_range, imageData) {
        document.getElementById("culinaryId").value = id;
        document.getElementById("name").value = name;
        document.getElementById("location").value = location;
        document.getElementById("price_range").value = price_range;

        const form = document.getElementById("culinaryForm");
        form.action = '/culinary/' + id;
        document.getElementById('_method').value = 'PUT';
        document.getElementById("oldImage").value = imageData;

        const previewDiv = document.getElementById('imagePreview');
        previewDiv.innerHTML = `<img src="data:image/jpeg;base64,${imageData}" alt="Preview Gambar" class="w-40 h-auto rounded mt-2">`;

        document.getElementById('image_url').value = "";

        document.getElementById("addBtn").classList.add("hidden");
        document.getElementById("updateBtn").classList.remove("hidden");
    }

    function resetForm() {
        document.getElementById("culinaryId").value = "";
        document.getElementById("name").value = "";
        document.getElementById("location").value = "";
        document.getElementById("price_range").value = "Murah";
        document.getElementById("image_url").value = "";
        document.getElementById("oldImage").value = "";
        document.getElementById('_method').value = 'POST';
        document.getElementById("culinaryForm").action = "{{ url('/culinary') }}";
        document.getElementById('imagePreview').innerHTML = "";

        document.getElementById("addBtn").classList.remove("hidden");
        document.getElementById("updateBtn").classList.add("hidden");
    }

    document.getElementById('image_url').addEventListener('change', function(){
        const file = this.files[0];
        const previewDiv = document.getElementById('imagePreview');
        if(file){
            if(!file.name.toLowerCase().endsWith('.jpg') && !file.name.toLowerCase().endsWith('.jpeg')){
                alert('Masukkan file JPG saja.');
                this.value = "";
                previewDiv.innerHTML = "";
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e){
                previewDiv.innerHTML = `<img src="${e.target.result}" alt="Preview Gambar" class="w-40 h-auto rounded mt-2">`;
            };
            reader.readAsDataURL(file);
        } else {
            previewDiv.innerHTML = "";
        }
    });
    </script>

</body>
</html>
