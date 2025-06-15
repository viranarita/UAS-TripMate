<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItineraryHotelController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|string|max:11',
            'list_id' => 'required|string|max:11',
        ]);

        // Cek apakah data sudah ada
        $exists = DB::table('tb_Itinerary_Hotel')
            ->where('hotel_id', $request->hotel_id)
            ->where('list_id', $request->list_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Data sudah ada'], 409); // HTTP 409 Conflict
        }

        // Kalau belum ada, tambahkan data baru
        DB::table('tb_Itinerary_Hotel')->insert([
            'hotel_id' => $request->hotel_id,
            'list_id' => $request->list_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Sukses']);
    }
}
