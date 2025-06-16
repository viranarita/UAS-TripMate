@php
    $pageTitle = 'Dashboard';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>Admin | Dashboard</title>
    <link rel="stylesheet" href="style.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    @media print {
        section {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .container, 
        .flex, 
        .flex-wrap, 
        .justify-center, 
        .w-full,
        #printArea {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .shadow-md, 
        .shadow-lg {
            box-shadow: none !important;
        }

        .rounded-lg {
            border-radius: 0 !important;
        }
        }
    </style>
</head>

<body class="bg-gray-100">

    <div id="sidebar" class="print:hidden">
        @include('components.headerAdmin')
    </div>
    
    <div id="headerAdmin" class="print:hidden">
        @include('components.sidebar')
    </div>

    <div id="printArea">
    <section class="pt-24 pb-10 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        <div class="flex justify-center mt-4 space-x-4">
            <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-md">
                <div class="flex justify-center">
                    <div class="text-4xl font-semibold p-2">{{ $totalUsers }}</div>
                    <div class="text-sm font-medium text-gray-400 print:text-black p-2 mt-3">Total Pengguna Aktif</div>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-md">
                <div class="flex justify-center">
                    <div class="text-4xl font-semibold p-2">{{ $totalItinerary }}</div>
                    <div class="text-sm font-medium text-gray-400 print:text-black p-2 mt-3">Total Itinerary Dibuat</div>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-md">
                <div class="flex justify-center">
                    <div class="text-4xl font-semibold p-2">{{ $totalTransport }}</div>
                    <div class="text-sm font-medium text-gray-400 print:text-black p-2 mt-3">Total Transportasi</div>
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-100 p-6 shadow-md">
                <div class="flex justify-center">
                    <div class="text-4xl font-semibold p-2">{{ $totalDestination }}</div>
                    <div class="text-sm font-medium text-gray-400 print:text-black p-2 mt-3">Total Destinasi</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Chart Section Start -->
    <section id="chart" class="pt-10 pb-10 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
        <div class="container">
            <div class="flex flex-wrap justify-center gap-6">
                <!-- Chart 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/2 max-w-md text-center">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Destinasi Terfavorit</h2>
                    <div class="w-full h-80 mx-auto">
                        <canvas id="myChart1"></canvas>
                    </div>
                </div>
                <!-- Chart 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/2 max-w-md text-center">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Itinerary Bulanan </h2>
                    <div class="w-full h-80 mx-auto">
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-10 pb-10 w-full lg:w-[calc(100%-16rem)] lg:ml-64">
    <div class="flex justify-center mt-4 mb-4">
            <div class="bg-white p-4 rounded-lg shadow-md w-3/4">
                <h2 class="mb-2 font-semibold text-lg">Itinerary Orang-Orang</h2>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="p-2 border">Nama Itinerary</th>
                            <th class="p-2 border">Start Date</th>
                            <th class="p-2 border">End Date</th>
                            <th class="p-2 border">Status</th>
                            <th class="p-2 border">Nama User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $today = now()->format('Y-m-d'); @endphp
                        @foreach($itineraries as $item)
                            @php
                                $status = '';
                                if ($item->departure_date > $today) {
                                    $status = '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600">Pending</span>';
                                } elseif ($item->return_date < $today) {
                                    $status = '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Done</span>';
                                } else {
                                    $status = '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-500">Proses</span>';
                                }
                            @endphp
                            <tr class='text-center'>
                                <td class='p-2 border'>{{ $item->list_name }}</td>
                                <td class='p-2 border'>{{ $item->departure_date }}</td>
                                <td class='p-2 border'>{{ $item->return_date }}</td>
                                <td class='p-2 border'>{!! $status !!}</td>
                                <td class='p-2 border'>{{ $item->user_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    </div>
        <div class="pt-10 pb-10 w-full lg:w-[calc(100%-16rem)] lg:ml-64 flex justify-center print:hidden">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                🖨️ Print Laporan
            </button>
        </div>
    </body>

    <script>
        // Chart 1 Destinasi Favorit
        document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ url('/chart-data') }}")
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById("myChart1").getContext('2d');

                new Chart(ctx, {
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
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            title: {
                                display: true,
                                text: 'Destinasi Favorit'
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching chart data:', error));
    });
      
        // Chart 2 Itinerary Perbulan
        document.addEventListener("DOMContentLoaded", function () {
          const monthLabels = {!! json_encode($monthLabels) !!};
          const monthData = {!! json_encode($monthData) !!};
      
          const ctx = document.getElementById("myChart2").getContext("2d");
          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: monthLabels,
              datasets: [{
                label: monthLabels,
                data: monthData,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2
              }]
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    stepSize: 1
                  }
                }
              }
            }
          });
        });
      </script>
      


</html>