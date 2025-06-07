@php
    $pageTitle = 'Buses';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>Admin | Manage Buses</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body class="bg-gray-100">

    @include('components.headerAdmin')
    @include('components.sidebar')

    <section class="pt-24 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        <div class="flex justify-center mt-4">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">

                {{-- Form untuk tambah / update --}}
                <form method="POST" action="{{ url('/buses') }}" id="busForm">
                    @csrf
                    @method('POST') 

                    <input type="hidden" name="bus_id" id="bus_id" />

                    <div class="grid grid-cols-1 gap-8">
                        <div>
                            <label class="block text-gray-700" for="bus_name">Nama Bus</label>
                            <input type="text" name="bus_name" id="bus_name" required
                                class="w-full px-3 py-2 border rounded" />
                        </div>

                        <div>
                            <label class="block text-gray-700" for="bus_class">Kelas Bus</label>
                            <select name="bus_class" id="bus_class" required
                                class="w-full px-3 py-2 border rounded">
                                <option value="VIP">VIP</option>
                                <option value="Eksekutif">Eksekutif</option>
                                <option value="Ekonomi">Ekonomi</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700" for="departure_time">Waktu Keberangkatan</label>
                            <input type="datetime-local" name="departure_time" id="departure_time" required
                                class="w-full px-3 py-2 border rounded" />
                        </div>

                        <div>
                            <label class="block text-gray-700" for="arrival_time">Waktu Kedatangan</label>
                            <input type="datetime-local" name="arrival_time" id="arrival_time" required
                                class="w-full px-3 py-2 border rounded" />
                        </div>

                        <div>
                            <label class="block text-gray-700" for="origin">Asal</label>
                            <input type="text" name="origin" id="origin" required
                                class="w-full px-3 py-2 border rounded" />
                        </div>

                        <div>
                            <label class="block text-gray-700" for="destination">Tujuan</label>
                            <input type="text" name="destination" id="destination" required
                                class="w-full px-3 py-2 border rounded" />
                        </div>

                        <div>
                            <label class="block text-gray-700" for="price">Harga</label>
                            <input type="number" name="price" id="price" required step="0.01" min="0"
                                class="w-full px-3 py-2 border rounded" />
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

        {{-- Tabel data buses --}}
        <div class="flex justify-center mt-4 mb-4">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="p-2 border">ID</th>
                            <th class="p-2 border">Nama</th>
                            <th class="p-2 border">Kelas</th>
                            <th class="p-2 border">Keberangkatan</th>
                            <th class="p-2 border">Kedatangan</th>
                            <th class="p-2 border">Asal</th>
                            <th class="p-2 border">Tujuan</th>
                            <th class="p-2 border">Harga</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buses as $bus)
                            <tr>
                                <td class="p-2 border">{{ $bus->bus_id }}</td>
                                <td class="p-2 border">{{ $bus->bus_name }}</td>
                                <td class="p-2 border">{{ $bus->bus_class }}</td>
                                <td class="p-2 border">{{ \Carbon\Carbon::parse($bus->departure_time)->format('Y-m-d H:i') }}</td>
                                <td class="p-2 border">{{ \Carbon\Carbon::parse($bus->arrival_time)->format('Y-m-d H:i') }}</td>
                                <td class="p-2 border">{{ $bus->origin }}</td>
                                <td class="p-2 border">{{ $bus->destination }}</td>
                                <td class="p-2 border">Rp{{ number_format($bus->price, 2, ',', '.') }}</td>
                                <td class="p-2 border space-x-2">
                                    <button type="button"
                                        onclick="editBus(
                                            '{{ $bus->bus_id }}',
                                            '{{ addslashes($bus->bus_name) }}',
                                            '{{ $bus->bus_class }}',
                                            '{{ $bus->departure_time }}',
                                            '{{ $bus->arrival_time }}',
                                            '{{ addslashes($bus->origin) }}',
                                            '{{ addslashes($bus->destination) }}',
                                            '{{ $bus->price }}'
                                        )"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded">Edit
                                    </button>
                                    <form action="{{ url('/buses/' . $bus->bus_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
    function editBus(id, name, busClass, departure, arrival, origin, destination, price, imageData) {
        // Isi input form
        document.getElementById("bus_id").value = id;
        document.getElementById("bus_name").value = name;
        document.getElementById("bus_class").value = busClass;
        document.getElementById("departure_time").value = formatDateTimeLocal(departure);
        document.getElementById("arrival_time").value = formatDateTimeLocal(arrival);
        document.getElementById("origin").value = origin;
        document.getElementById("destination").value = destination;
        document.getElementById("price").value = price;

        // Set form action & method
        const form = document.getElementById("busForm");
        form.action = "/buses/" + id;
        form.method = "POST";

        // _method hidden input (buat PUT)
        let methodInput = document.querySelector('input[name="_method"]');
        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            form.appendChild(methodInput);
        }
        methodInput.value = 'PUT';

        // Simpan gambar lama ke hidden input old_image
        const oldImageInput = document.getElementById("oldImage");
        if(oldImageInput) {
            oldImageInput.value = imageData;
        } else {
            const newOldImageInput = document.createElement('input');
            newOldImageInput.type = 'hidden';
            newOldImageInput.id = 'oldImage';
            newOldImageInput.name = 'old_image';
            newOldImageInput.value = imageData;
            form.appendChild(newOldImageInput);
        }

        // Tampilkan preview gambar lama (base64)
        const previewDiv = document.getElementById('imagePreview');
        if (previewDiv) {
            if(imageData) {
                previewDiv.innerHTML = `<img src="data:image/jpeg;base64,${imageData}" alt="Preview Gambar" class="w-40 h-auto rounded mt-2">`;
            } else {
                previewDiv.innerHTML = "";
            }
        }

        // Kosongkan input file image_url
        const fileInput = document.getElementById('image_url');
        if(fileInput) fileInput.value = "";

        // Toggle tombol
        document.getElementById("addBtn").classList.add("hidden");
        document.getElementById("updateBtn").classList.remove("hidden");
    }

    function resetForm() {
        const form = document.getElementById("busForm");
        form.reset();

        // Reset action & method ke create
        form.action = "{{ url('/buses') }}";
        form.method = "POST";

        // Reset _method input ke POST
        let methodInput = document.querySelector('input[name="_method"]');
        if(methodInput) {
            methodInput.value = 'POST';
        }

        // Reset oldImage input dan preview gambar
        const oldImageInput = document.getElementById("oldImage");
        if(oldImageInput) oldImageInput.value = "";

        const previewDiv = document.getElementById('imagePreview');
        if(previewDiv) previewDiv.innerHTML = "";

        // Toggle tombol
        document.getElementById("addBtn").classList.remove("hidden");
        document.getElementById("updateBtn").classList.add("hidden");
    }

    // Format datetime local helper (sama seperti milikmu)
    function formatDateTimeLocal(dateTimeString) {
        const dt = new Date(dateTimeString);
        const pad = n => n.toString().padStart(2, '0');

        const year = dt.getFullYear();
        const month = pad(dt.getMonth() + 1);
        const day = pad(dt.getDate());
        const hours = pad(dt.getHours());
        const minutes = pad(dt.getMinutes());

        return `${year}-${month}-${day}T${hours}:${minutes}`;
    }


</script>


</body>
</html>
