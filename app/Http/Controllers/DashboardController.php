<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = DB::table('tb_Users')->count();
        $totalItinerary = DB::table('tb_Itinerary')->count();
        $totalFlight = DB::table('tb_Flights')->count();
        $totalBus = DB::table('tb_Buses')->count();
        $totalTrain = DB::table('tb_Trains')->count();
        $totalTransport = $totalFlight + $totalBus + $totalTrain;

        $totalAttractions = DB::table('tb_Attractions')->count();
        $totalCulinary = DB::table('tb_Culinary')->count();
        $totalDestination = $totalAttractions + $totalCulinary;

        $monthlyItinerary = DB::table('tb_Itinerary')
            ->selectRaw("DATE_FORMAT(timestamp, '%Y-%m') as month, COUNT(*) as total")
            ->whereNotNull('departure_date')
            ->groupByRaw("DATE_FORMAT(timestamp, '%Y-%m')")
            ->orderByRaw("MIN(departure_date)")
            ->get();

        // Format month label from '2025-06' to 'June 2025'
        $monthLabels = $monthlyItinerary->pluck('month')->map(function($m) {
            return Carbon::createFromFormat('Y-m', $m)->format('F Y');
        });

        $monthData = $monthlyItinerary->pluck('total');

        $itineraries = DB::table('tb_Itinerary')
            ->join('tb_Users', 'tb_Itinerary.user_id', '=', 'tb_Users.user_id')
            ->select('tb_Itinerary.*', 'tb_Users.name as user_name')
            ->orderByDesc('departure_date')
            ->get();

        return view('dashboard', compact(
            'totalUsers', 'totalItinerary', 'totalTransport', 'totalDestination',
            'monthLabels', 'monthData', 'itineraries'
        ));
    }
    public function getChartData()
    {
        $destinations = DB::table('tb_itinerary')
            ->select('destination', DB::raw('COUNT(*) as total'))
            ->groupBy('destination')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $labels = $destinations->pluck('destination');
        $data = $destinations->pluck('total');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}
