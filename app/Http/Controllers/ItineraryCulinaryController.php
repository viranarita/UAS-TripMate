<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItineraryCulinaryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'culinary_id' => 'required|string|max:11',
            'list_id' => 'required|string|max:11',
        ]);

        // Cek apakah kombinasi culinary_id dan list_id sudah ada
        $exists = DB::table('tb_Itinerary_Culinary')
            ->where('culinary_id', $request->culinary_id)
            ->where('list_id', $request->list_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Data sudah ada'], 409); // HTTP 409 Conflict
        }

        // Jika belum ada, insert
        DB::table('tb_Itinerary_Culinary')->insert([
            'culinary_id' => $request->culinary_id,
            'list_id' => $request->list_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Sukses']);
    }
}
