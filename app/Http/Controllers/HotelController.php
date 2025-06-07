<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        return view('hotel', compact('hotels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price_per_night' => 'required|numeric',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $imageData = null;
        if ($request->hasFile('image_url')) {
            $imageData = file_get_contents($request->file('image_url')->getRealPath());
        }

        $lastHotel = Hotel::orderBy('hotel_id', 'desc')->first();

        if ($lastHotel) {
            $lastIdNum = (int) substr($lastHotel->hotel_id, 3);
            $newIdNum = $lastIdNum + 1;
        } else {
            $newIdNum = 1;
        }

        $newHotelId = 'HTL' . str_pad($newIdNum, 3, '0', STR_PAD_LEFT);

        Hotel::create([
            'hotel_id' => $newHotelId,
            'name' => $request->name,
            'location' => $request->location,
            'price_per_night' => $request->price_per_night,
            'image_url' => $imageData,
        ]);

        return redirect('/hotel')->with('success', 'Hotel berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price_per_night' => 'required|numeric',
            'image_url' => 'nullable|image|mimes:jpg,jpeg|max:5120',
        ]);

        if ($request->hasFile('image_url')) {
            $hotel->image_url = file_get_contents($request->file('image_url')->getRealPath());
        }

        $hotel->name = $request->name;
        $hotel->location = $request->location;
        $hotel->price_per_night = $request->price_per_night;
        $hotel->save();

        return redirect('/hotel')->with('success', 'Hotel berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect('/hotel')->with('success', 'Hotel berhasil dihapus.');
    }
}
