<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - TripMate</title>
    @vite(['resources/css/app.css', 'resources/css/style.css'])
</head>
<body class="p-24 flex items-center justify-center min-h-screen bg-gray-100">
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-red-600 mb-6">Login ke TripMate</h2>

    <!-- Form Login dengan action ke route login.post -->
    <form action="{{ route('login.post') }}" method="POST">
      @csrf
      @if ($errors->any())
          <div class="mb-4 text-red-600 font-semibold">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" placeholder="Masukkan email" required
               value="{{ old('email') }}"
               class="w-full px-4 py-2 border rounded-lg focus:ring-red-500 focus:border-red-500" />
      </div>

      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan password" required
               class="w-full px-4 py-2 border rounded-lg focus:ring-red-500 focus:border-red-500" />
      </div>

      <div class="mb-4 flex justify-between items-center">
        <div class="flex items-center">
          <input type="checkbox" id="showPassword" class="mr-2" />
          <label for="showPassword" class="text-sm text-gray-700">Tampilkan Password</label>
        </div>
        <a href="/lupa-password" class="text-sm text-red-600 hover:underline font-medium">Lupa Password?</a>
      </div>

      <button type="submit"
              class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 font-semibold transition duration-300">
        Login
      </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-4">
      Belum punya akun?
      <a href="{{ url('/register') }}" class="text-red-600 hover:text-red-700 font-semibold">Buat Akun Baru</a>
    </p>
  </div>

  <script>
    document.getElementById("showPassword").addEventListener("change", function () {
      const password = document.getElementById("password");
      password.type = this.checked ? "text" : "password";
    });
  </script>
</body>
</html>
