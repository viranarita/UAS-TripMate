<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packages;

class PackagesController extends Controller
{
    public function index()
    {
        $packages = Packages::all();
        return view('packages', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'required|string',
            'price' => 'required|numeric',
            'city' => 'required|string|max:255',
            'days' => 'required|integer|min:1',
            'nights' => 'required|integer|min:0',
            'departure_date' => 'required|date',
        ]);

        $lastPackage = Packages::orderBy('package_id', 'desc')->first();

        if ($lastPackage) {
            $lastIdNum = (int) substr($lastPackage->package_id, 3);
            $newIdNum = $lastIdNum + 1;
        } else {
            $newIdNum = 1;
        }

        $newPackageId = 'PKG' . str_pad($newIdNum, 3, '0', STR_PAD_LEFT);

        Packages::create([
            'package_id' => $newPackageId,
            'name' => $request->name,
            'details' => $request->details,
            'price' => $request->price,
            'city' => $request->city,
            'days' => $request->days,
            'nights' => $request->nights,
            'departure_date' => $request->departure_date,
        ]);

        return redirect('/packages')->with('success', 'Packages berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $package = Packages::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'required|string',
            'price' => 'required|numeric',
            'city' => 'required|string|max:255',
            'days' => 'required|integer|min:1',
            'nights' => 'required|integer|min:0',
            'departure_date' => 'required|date',
        ]);

        $package->update([
            'name' => $request->name,
            'details' => $request->details,
            'price' => $request->price,
            'city' => $request->city,
            'days' => $request->days,
            'nights' => $request->nights,
            'departure_date' => $request->departure_date,
        ]);

        return redirect('/packages')->with('success', 'Packages berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $package = Packages::findOrFail($id);
        $package->delete();

        return redirect('/packages')->with('success', 'Packages berhasil dihapus.');
    }
}
