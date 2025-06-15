<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItineraryAttractionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'attraction_id' => 'required|string|max:11',
            'list_id' => 'required|string|max:11',
        ]);

        $exists = DB::table('tb_Itinerary_Attractions')
            ->where('attraction_id', $request->attraction_id)
            ->where('list_id', $request->list_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Data sudah ada'], 409); // 409 = Conflict
        }

        DB::table('tb_Itinerary_Attractions')->insert([
            'attraction_id' => $request->attraction_id,
            'list_id' => $request->list_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Sukses']);
    }

}
