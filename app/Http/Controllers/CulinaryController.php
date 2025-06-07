<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Culinary;

class CulinaryController extends Controller
{
    public function index()
    {
        $culinaries = Culinary::all(); // Ambil semua data dari DB
        return view('culinary', ['culinaries' => $culinaries]); // Kirim ke Blade
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'price_range' => 'required|in:Murah,Sedang,Mahal',
            'image_url' => 'nullable|file|mimes:jpg,jpeg',
        ]);

        $imageData = null;
        if ($request->hasFile('image_url')) {
            $imageData = file_get_contents($request->file('image_url')->getRealPath());
        }

        // Cari ID terakhir
        $last = Culinary::orderBy('culinary_id', 'desc')->first();
        if ($last && preg_match('/CUL(\d+)/', $last->culinary_id, $matches)) {
            $nextIdNumber = (int)$matches[1] + 1;
        } else {
            $nextIdNumber = 1;
        }
        $newId = 'CUL' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

        Culinary::create([
            'culinary_id' => $newId,
            'name' => $request->name,
            'location' => $request->location,
            'price_range' => $request->price_range,
            'image_url' => $imageData,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'price_range' => 'required|in:Murah,Sedang,Mahal',
            'image_url' => 'nullable|file|mimes:jpg,jpeg',
        ]);

        $culinary = Culinary::where('culinary_id', $id)->first();
        if (!$culinary) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        if ($request->hasFile('image_url')) {
            $culinary->image_url = file_get_contents($request->file('image_url')->getRealPath());
        }

        $culinary->name = $request->name;
        $culinary->location = $request->location;
        $culinary->price_range = $request->price_range;
        $culinary->save();

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $culinary = Culinary::where('culinary_id', $id)->first();
        if ($culinary) {
            $culinary->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }
}
