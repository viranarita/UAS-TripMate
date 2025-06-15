<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItineraryTrainsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'train_id' => 'required|string|max:11',
            'list_id' => 'required|string|max:11',
        ]);

        // Cek apakah kombinasi train_id dan list_id sudah ada
        $exists = DB::table('tb_Itinerary_Trains')
            ->where('train_id', $request->train_id)
            ->where('list_id', $request->list_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Data sudah ada'], 409); // HTTP 409 Conflict
        }

        // Jika belum ada, insert
        DB::table('tb_Itinerary_Trains')->insert([
            'train_id' => $request->train_id,
            'list_id' => $request->list_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Sukses']);
    }
}
