<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attraction;
use Illuminate\Support\Str;

class AttractionController extends Controller
{
    public function index()
    {
        $attractions = Attraction::all(); // Ambil semua data dari DB
        return view('attraction', ['attractions' => $attractions]);
// Kirim ke blade
    }


    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'location' => 'required',
        'price' => 'required|numeric',
        'image_url' => 'nullable|file|mimes:jpg,jpeg',
    ]);

    $imageData = null;
    if ($request->hasFile('image_url')) {
        $imageData = file_get_contents($request->file('image_url')->getRealPath());
    }

    // Cari ID terakhir
    $lastAttraction = Attraction::orderBy('attraction_id', 'desc')->first();

    if ($lastAttraction && preg_match('/ATR(\d+)/', $lastAttraction->attraction_id, $matches)) {
        $nextIdNumber = (int)$matches[1] + 1;
    } else {
        $nextIdNumber = 1;
    }

    $newAttractionId = 'ATR' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

    Attraction::create([
        'attraction_id' => $newAttractionId,
        'name' => $request->name,
        'location' => $request->location,
        'price' => $request->price,
        'image_url' => $imageData,
    ]);

    return redirect()->back()->with('success', 'Data berhasil ditambahkan');
}
    public function destroy($id)
    {
        $attraction = Attraction::where('attraction_id', $id)->first();

        if ($attraction) {
            $attraction->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }
    
    public function update(Request $request, $id)
    {
        // Validasi: semua wajib kecuali image_url boleh kosong
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'price' => 'required|numeric',
            'image_url' => 'nullable|file|mimes:jpg,jpeg',
        ]);

        $attraction = Attraction::where('attraction_id', $id)->first();
        if (!$attraction) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Cek ada file baru tidak
        if ($request->hasFile('image_url')) {
            $imageData = file_get_contents($request->file('image_url')->getRealPath());
            $attraction->image_url = $imageData;
        }
        
        // Update field wajib (semua harus diisi)
        $attraction->name = $request->name;
        $attraction->location = $request->location;
        $attraction->price = $request->price;

        $attraction->save();

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }



}
