<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Planning;

class PlanningController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Harap login terlebih dahulu.');
        }

        $plans = Planning::where('user_id', Auth::id())->orderByDesc('timestamp')->get();
        return view('planning', compact('plans'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'list_name' => 'required|string|max:150',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:departure_date',
            'departure_city' => 'required|in:Surabaya,Jakarta,Bandung,Yogyakarta',
            'destination_city' => 'required|in:Surabaya,Jakarta,Bandung,Yogyakarta',
        ]);

        if ($request->filled('list_id')) {
            $planning = Planning::where('list_id', $request->list_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $planning->update($request->only('list_name', 'departure_date', 'return_date', 'departure_city', 'destination_city'));
        } else {
            Planning::create([
                'user_id' => Auth::id(),
                'list_name' => $request->list_name,
                'departure_date' => $request->departure_date,
                'return_date' => $request->return_date,
                'departure_city' => $request->departure_city,
                'destination_city' => $request->destination_city,
            ]);
        }

        return redirect()->route('planning');
    }

    public function delete($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $planning = Planning::where('list_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $planning->delete();

        return redirect()->route('planning');
    }
}
