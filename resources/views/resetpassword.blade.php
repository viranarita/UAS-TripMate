<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | TripMate</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}"/>
    @vite(['resources/css/app.css', 'resources/css/style.css'])
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-red-600 mb-6">Reset Password</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-600 p-2 rounded mb-4 text-sm">{{ session('error') }}</div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            {{-- Kirim email via hidden input --}}
            <input type="hidden" name="email" value="{{ request('email') }}">

            <div class="mb-4">
                <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                <input type="password" id="new_password" name="new_password" class="w-full px-4 py-2 border rounded-lg" required>
                @error('new_password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="confirm_password" id="confirmPassword" class="w-full px-4 py-2 border rounded-lg" required>
                @error('confirm_password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <input type="checkbox" id="showPassword" class="mr-2">
                <label for="showPassword" class="text-sm text-gray-700">Tampilkan Password</label>
            </div>

            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 font-semibold transition duration-300">Reset Password</button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            Kembali ke <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 font-semibold">Halaman Login</a>
        </p>
    </div>

    <script>
        document.getElementById("showPassword").addEventListener("change", function () {
            var passwordField = document.getElementById("new_password");
            var confirmField = document.getElementById("confirmPassword");
            var type = this.checked ? "text" : "password";
            passwordField.type = type;
            confirmField.type = type;
        });
    </script>
</body>
</html>
