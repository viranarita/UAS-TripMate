@php
    $pageTitle = 'Manage Users';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>Admin | Manage Users</title>
    <link rel="stylesheet" href="style.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    
    @include('components.headerAdmin')
    @include('components.sidebar')

    <section class="pt-24 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        <div class="flex justify-center mt-4 mb-4">
                <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-red-600 text-white">
                                <th class="p-2 border">ID</th>
                                <th class="p-2 border">Nama</th>
                                <th class="p-2 border">Email</th>
                                <th class="p-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="text-center">
                                <td class="p-2 border">{{ $user->user_id }}</td>
                                <td class="p-2 border">{{ $user->name }}</td>
                                <td class="p-2 border">{{ $user->email }}</td>
                                <td class="p-2 border">
                                    <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
</body>
</html>