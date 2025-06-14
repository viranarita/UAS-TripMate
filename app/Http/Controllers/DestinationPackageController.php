<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packages;

class DestinationPackageController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'duration_days' => 'nullable|integer|min:1',
        ]);
        
        $city = $request->input('city');
        $departureDate = $request->input('departure_date');
        $durationDays = $request->input('duration_days');

        $query = Packages::where('city', 'like', '%' . $city . '%')
                         ->whereDate('departure_date', $departureDate);
        
        if (!empty($durationDays)) {
            $query->where('days', $durationDays);
        }
        
        $packages = $query->get();
        
        return view('destinationPackage', [
            'packages' => $packages,
            'city' => $city,
            'departureDate' => $departureDate,
            'durationDays' => $durationDays,
        ]);
        
    }
}
