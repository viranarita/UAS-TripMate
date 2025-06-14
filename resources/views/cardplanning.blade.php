@extends('layouts.app')

@section('title', 'Planning')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/style.css'])
    <title>Planning | TripMate</title>
    <link rel="stylesheet" href="style.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <section id="cardplanning" class="pt-25 pb-25">
        <div class="container">
            <div class="flex flex-wrap">
                <div class="w-full self-center px-4">
                    <div class="w-full">
                        <h2 class="font-bold text-dark text-2xl max-w-xl mt-5 mb-5 lg:mt-0">Your Plan</h2>
                    </div>
                    <div class="flex flex-wrap gap-4 w-full">
                        <a href="/planning" class="block">
                            <div class="rounded-2xl w-[196px] h-[200px] bg-primary overflow-hidden drop-shadow flex flex-col">
                                <div class="p-3 flex flex-col justify-center items-center flex-grow text-center">
                                    <img src="https://d1785e74lyxkqq.cloudfront.net/_next/static/v4.5.8/0/00e531dd9042465e76fa4006380118a1.svg" width="48" height="48">
                                    <h1 class="mt-5 font-semibold text-white">Create Plan</h1>
                                </div>                
                            </div>
                        </a>
                        @foreach ($plans as $plan)
                            <a href="{{ route('planning.show', $plan->list_id) }}" class="block">
                                <div class="rounded-2xl w-[196px] h-[200px] bg-gray-200 overflow-hidden drop-shadow flex flex-col">
                                    <img src="{{ $plan->image ? url('/image/planning/' . $plan->list_id) : asset('img/default.jpg') }}" class="w-full h-1/2 object-cover rounded-b"/>
                                    <div class="p-3 flex flex-col justify-center items-center flex-grow text-center">
                                        <h1 class="font-semibold text-black">{{ $plan->list_name }}</h1>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        </div>              
                </div>
            </div>
        </div>
    </section>

    @include('components.footer')
    
</body>
</html>

@endsection