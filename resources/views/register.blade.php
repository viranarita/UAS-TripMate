<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>Register - TripMate</title>
    <link rel="stylesheet" href="style.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-2xl font-bold text-center text-red-600 mb-6">Buat Akun TripMate</h2>
  
      <form id="registerForm" action="#" method="POST">
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
          <input type="text" id="name" name="name" placeholder="Masukkan nama" required
                 class="w-full px-4 py-2 border rounded-lg" />
        </div>
  
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" id="email" name="email" placeholder="Masukkan email" required
                 class="w-full px-4 py-2 border rounded-lg" />
        </div>
  
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" id="password" name="password" placeholder="Buat password" required
                 class="w-full px-4 py-2 border rounded-lg" />
        </div>
  
        <div class="mb-4">
          <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
          <input type="password" id="confirmPassword" name="confirm_password" placeholder="Ulangi password" required
                 class="w-full px-4 py-2 border rounded-lg" />
        </div>
  
        <div class="mb-4">
          <input type="checkbox" id="showPassword" class="mr-2" />
          <label for="showPassword" class="text-sm text-gray-700">Tampilkan Password</label>
        </div>
  
        <button type="submit"
                class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 font-semibold transition duration-300">
          Daftar
        </button>
      </form>
  
      <p class="text-center text-sm text-gray-600 mt-4">
        Sudah punya akun?
        <a href="/login" class="text-red-600 hover:text-red-700 font-semibold">Login</a>
      </p>
    </div>
  
    <script>
      document.getElementById("showPassword").addEventListener("change", function () {
        const type = this.checked ? "text" : "password";
        document.getElementById("password").type = type;
        document.getElementById("confirmPassword").type = type;
      });
  
      document.getElementById("registerForm").addEventListener("submit", function (e) {
        const pass = document.getElementById("password").value;
        const confirm = document.getElementById("confirmPassword").value;
        if (pass !== confirm) {
          e.preventDefault();
          alert("Password dan konfirmasi tidak cocok.");
        }
      });
    </script>
  </body>
</html>