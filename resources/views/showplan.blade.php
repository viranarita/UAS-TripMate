@extends('layouts.app')

@section('title', 'Detail Plan')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>Detail Plan | TripMate</title>
</head>
<body class="bg-gray-100">
    <section class="pt-25 pb-25">
        <div class="container px-4">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <img src="{{ $plan->image ? url('/image/planning/' . $plan->list_id) : asset('img/default.jpg') }}" class="w-full max-h-[300px] object-cover mb-4 rounded">

                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold text-gray-800">
                        {{ $plan->list_name }}
                    </h1>
                    <div class="flex justify-between items-center space-x-2">
                        <a href="{{ url('/planning?edit=' . $plan->list_id) }}" title="Edit Plan">
                            <img src="https://d1785e74lyxkqq.cloudfront.net/_next/static/v4.6.0/8/80038853ae719be896bba533543fdab1.svg" width="20" height="20" class="hover:opacity-80 transition" alt="Edit Icon">
                        </a>
                        <form action="{{ route('planning.destroy', $plan->list_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus plan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Delete Plan" class="hover:opacity-80 transition">
                                {{-- SVG Trash merah --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0011-1z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    
                </div>             

                {{-- Detail dalam baris horizontal --}}
                <div class="flex flex-wrap gap-8 text-gray-700">
                    <div class="flex items-center space-x-2">
                        {{-- Icon tujuan (lokasi) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1 1 0 01-1.414 0L6.343 16.657a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $plan->destination_city }}</span>
                    </div>

                    <div class="flex items-center space-x-2">
                        {{-- Icon tanggal berangkat (calendar) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m2 10H5a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2z" />
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($plan->departure_date)->translatedFormat('d F Y') }}</span>
                    </div>

                    {{-- <div class="flex items-center space-x-2">
                        Icon tanggal kembali (calendar return)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($plan->return_date)->translatedFormat('d F Y') }}</span>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

    @include('components.footer')
</body>
</html>
@endsection
