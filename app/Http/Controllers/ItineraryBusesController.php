<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItineraryBusesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|string|max:11',
            'list_id' => 'required|string|max:11',
        ]);

        // Cek apakah kombinasi bus_id dan list_id sudah ada
        $exists = DB::table('tb_Itinerary_Buses')
            ->where('bus_id', $request->bus_id)
            ->where('list_id', $request->list_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Data sudah ada'], 409); // HTTP 409 Conflict
        }

        // Jika belum ada, insert
        DB::table('tb_Itinerary_Buses')->insert([
            'bus_id' => $request->bus_id,
            'list_id' => $request->list_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Sukses']);
    }
}
