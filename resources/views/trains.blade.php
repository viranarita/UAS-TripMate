@php
    $pageTitle = 'Trains';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>Admin | Manage Trains</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body class="bg-gray-100">

@include('components.headerAdmin')
@include('components.sidebar')

<section class="pt-24 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
    <div class="flex justify-center mt-4">
        <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
            <form method="POST" action="{{ url('/trains') }}" id="trainForm">
                @csrf
                <input type="hidden" name="train_id" id="trainId">
                <input type="hidden" name="_method" id="_method" value="POST">

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-gray-700">Nama Kereta</label>
                        <input type="text" name="train_name" id="train_name" required class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-gray-700">Jenis Kereta</label>
                        <select name="train_type" id="train_type" required class="w-full px-3 py-2 border rounded">
                            <option value="Eksekutif">Eksekutif</option>
                            <option value="Bisnis">Bisnis</option>
                            <option value="Ekonomi">Ekonomi</option>
                        </select>
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
                        <input type="number" name="price" id="price" required step="0.01" class="w-full px-3 py-2 border rounded">
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
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Jenis</th>
                        <th class="p-2 border">Keberangkatan</th>
                        <th class="p-2 border">Kedatangan</th>
                        <th class="p-2 border">Asal</th>
                        <th class="p-2 border">Tujuan</th>
                        <th class="p-2 border">Harga</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trains as $item)
                        <tr>
                            <td class="p-2 border">{{ $item->train_id }}</td>
                            <td class="p-2 border">{{ $item->train_name }}</td>
                            <td class="p-2 border">{{ $item->train_type }}</td>
                            <td class="p-2 border">{{ $item->departure_time }}</td>
                            <td class="p-2 border">{{ $item->arrival_time }}</td>
                            <td class="p-2 border">{{ $item->origin }}</td>
                            <td class="p-2 border">{{ $item->destination }}</td>
                            <td class="p-2 border">Rp{{ number_format($item->price, 2, ',', '.') }}</td>
                            <td class="p-2 border text-center space-x-2">
                                <button 
                                    type="button" 
                                    onclick="editTrain(
                                        '{{ $item->train_id }}',
                                        '{{ addslashes($item->train_name) }}',
                                        '{{ $item->train_type }}',
                                        '{{ $item->departure_time }}',
                                        '{{ $item->arrival_time }}',
                                        '{{ addslashes($item->origin) }}',
                                        '{{ addslashes($item->destination) }}',
                                        '{{ $item->price }}'
                                    )"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded"
                                >Edit</button>

                                <form action="{{ url('/trains/' . $item->train_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display:inline-block;">
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
function editTrain(id, name, type, dep, arr, origin, dest, price) {
    document.getElementById("trainId").value = id;
    document.getElementById("train_name").value = name;
    document.getElementById("train_type").value = type;
    document.getElementById("departure_time").value = formatDateTimeLocal(dep);
    document.getElementById("arrival_time").value = formatDateTimeLocal(arr);
    document.getElementById("origin").value = origin;
    document.getElementById("destination").value = dest;
    document.getElementById("price").value = price;

    const form = document.getElementById("trainForm");
    form.action = '/trains/' + id;
    document.getElementById('_method').value = 'PUT';

    document.getElementById("addBtn").classList.add("hidden");
    document.getElementById("updateBtn").classList.remove("hidden");
}

function formatDateTimeLocal(datetime) {
    const date = new Date(datetime);
    return date.toISOString().slice(0, 16);
}

function resetForm() {
    document.getElementById("trainId").value = "";
    document.getElementById("train_name").value = "";
    document.getElementById("train_type").value = "Eksekutif";
    document.getElementById("departure_time").value = "";
    document.getElementById("arrival_time").value = "";
    document.getElementById("origin").value = "";
    document.getElementById("destination").value = "";
    document.getElementById("price").value = "";

    const form = document.getElementById("trainForm");
    form.action = "{{ url('/trains') }}";
    document.getElementById('_method').value = 'POST';

    document.getElementById("addBtn").classList.remove("hidden");
    document.getElementById("updateBtn").classList.add("hidden");
}
</script>

</body>
</html>
