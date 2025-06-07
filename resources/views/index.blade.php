@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>TripMate</title>
    <link rel="stylesheet" href="style.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- Hero Section Start -->
    <section id="home" class="pt-20">
        <div class="container">
            <div class="flex flex-wrap">
                <div class="w-full self-center px-4 lg:w-1/2">
                    <h1 class="text-balance font-semibold text-dark md:text-sl lg:text-xl">Welcome to <span class="block font-bold text-primary text-4xl lg:text-5xl mb-2">TripMate!🌴🚗</span></h1>
                    <h2 class="font-medium text-secondary text-lg mb-8 lg:text-xl">Your Trip <span class="text-slate-700 font-style: italic">Soulmate</span></h2>
                    <p class="font-medium text-secondary mb-10 leading-relaxed">New Places Await, Just Tap TripMate!</p>

                    <a href="/planning" class="text-base font-semibold text-white bg-primary py-3 px-8 rounded-full hover:shadow-lg hover:opacity-80 transition duration-300 ease-in-out">Mulai Planning Trip!</a>
                </div>
                <div class="w-full self-end px-4 lg:w-1/2">
                    <div class="relative mt-10 lg:mt-0 lg:right-0">
                        <img src="img/foto tourguide nunjuk.png" alt="Tour Guide" class="max-w-full mx-auto"/>
                        <span class="absolute -bottom-0 -z-10 translate-x-6 md:scale-125"> 
                            <svg width="400" height="400" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#dc2626" d="M35.1,-49.7C49.8,-45.3,68.7,-42.7,79.5,-32.4C90.3,-22.1,93,-4.2,90.7,13.2C88.4,30.5,81.1,47.3,67.1,51.3C53,55.3,32,46.6,15.9,49C-0.3,51.4,-11.7,64.9,-22.2,66.1C-32.7,67.3,-42.3,56.1,-53.4,45.2C-64.4,34.3,-77,23.6,-81.8,9.9C-86.7,-3.7,-83.8,-20.4,-75.4,-32.6C-66.9,-44.8,-52.9,-52.6,-39.4,-57.5C-25.9,-62.4,-12.9,-64.3,-1.3,-62.3C10.3,-60.2,20.5,-54.1,35.1,-49.7Z" transform="translate(100 100)" />
                              </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- About Section Start -->
    <section id="about" class="pt-26">
        <div class="container">
            <div class="flex flex-wrap">
                <div class="w-full px-4 mb-10">
                    <h4 class="font-bold uppercase text-primary text-lg mb-3">Tentang TripMate</h4>
                    <h2 class="font-bold text-dark text-3xl mb-5 max-w-xl">Yuk, kenalan sama TripMate!</h2>
                    <p class="font-medium text-base text-secondary mb-5">
                        Selamat datang di TripMate, sahabat terbaikmu dalam merencanakan dan menikmati perjalanan!
                        Kami hadir sebagai platform perjalanan pintar yang dirancang untuk mempermudah setiap langkah perjalananmu—mulai dari merancang itinerary, mencari penginapan, memesan transportasi, hingga menemukan aktivitas seru di destinasi pilihanmu.
                    </p>
                    <h2 class="font-bold text-dark text-3xl mb-5 max-w-xl">Visi Kami – Liburan Tanpa Ribet</h2>
                    <p class="font-medium text-base text-secondary mb-5">
                        Di TripMate, kami percaya bahwa setiap orang berhak mendapatkan pengalaman liburan yang menyenangkan tanpa ribet.
                        Kami menghadirkan solusi yang lengkap dan terintegrasi agar kamu bisa fokus menikmati perjalanan, bukan repot dengan detail perencanaannya.
                    </p>
                    <h2 class="font-bold text-dark text-3xl mb-5 max-w-xl">Fitur Unggulan</h2>
                    <div class="grid md:grid-cols-4 gap-6 mt-10">
                        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center text-center">
                            <h3 class="text-5xl mb-2">🛏️</h3>
                            <h3 class="text-xl font-semibold text-primary mb-2">Akomodasi</h3>
                            <p class="text-secondary text-base text-small">
                                Temukan dan pesan penginapan serta transportasi terbaik dalam satu platform.
                            </p>
                        </div>
                        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center text-center">
                            <h3 class="text-5xl mb-2">🚗</h3>
                            <h3 class="text-xl font-semibold text-primary mb-2">Transportasi</h3>
                            <p class="text-secondary text-base text-small">
                                Nikmati berbagai pilihan kendaraan lokal, antar kota, hingga layanan antar-jemput bandara yang praktis dan nyaman.
                            </p>
                        </div>
                        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center text-center">
                            <h3 class="text-5xl mb-2">🎯</h3>
                            <h3 class="text-xl font-semibold text-primary mb-2">Aktivitas</h3>
                            <p class="text-secondary text-base text-small">
                                Jelajahi rekomendasi tempat wisata berdasarkan minatmu—apakah itu petualangan alam, wisata budaya, atau city tour.
                            </p>
                        </div>
                        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center text-center">
                            <h3 class="text-5xl mb-2">🍜</h3>
                            <h3 class="text-xl font-semibold text-primary mb-2">Kuliner</h3>
                            <p class="text-secondary text-base text-small">
                                Temukan tempat makan legendaris, hidden gem kuliner, dan jajanan khas daerah yang wajib kamu coba di setiap kota.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
     </section>
    <!-- About Section End -->

    <!-- Chart Section Start
    <section id="chart" class="pt-12 pb-12">
        <div class="container">
            <div class="flex flex-wrap justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md text-center">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Destinasi Terfavorit TripMate</h2>
                    <div class="w-full h-80 mx-auto">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

<!-- Tambahkan Library Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch("getChartData.php")
        .then(response => response.json())
        .then(data => {
            var ctx = document.getElementById("myChart").getContext('2d');

            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Destinasi Favorit',
                        data: data.data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 2
                    }]
                }
            });
        })
        .catch(error => console.error('Error:', error));
});
</script>


    <!-- Chart Section Start -->
     
    <!-- Footer Start -->
    <footer class="bg-dark pt-24 pb-12">
        <div class="container">
            <div class="flex flex-wrap">
                <!-- Bagian Kiri -->
                <div class="w-full px-4 mb-12 md:w-1/2 flex flex-col justify-center items-center text-center">
                    <h2 class="font-bold text-6xl text-primary py-6">TripMate</h2>
                </div>
                <!-- Bagian Kanan -->
                <div class="w-full px-4 mb-12 text-slate-300 md:w-1/2 flex flex-col justify-center items-center text-center">
                    <h3 class="font-bold text-2xl mb-2">Contact Us</h3>
                    <p>TripMate@business.com</p>
                    <p>Jl. Ir. Soekarno No.127</p>
                    <p>Surabaya</p>
                </div>
            </div>
            <div class="w-full pt-10 border-t border-slate-700">
                <p class="font-medium text-sm text-slate-500 text-center">Copyright © 2025 <a class="font-bold text-primary">TripMate</a>. All rights reserved.</p>
            </div>
        </div>
        
    </footer>
    <!-- Footer End -->

    <script src="js/script.js"></script>

</body>
</html>

@endsection
