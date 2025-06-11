<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Planning;

class PlanningController extends Controller
{
    public function index()
    {
        $plans = Auth::check()
            ? Planning::where('user_id', Auth::id())->orderByDesc('timestamp')->get()
            : collect(); // jika belum login, kirim koleksi kosong

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
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('list_name', 'departure_date', 'return_date', 'departure_city', 'destination_city');

        // Tambahkan user_id untuk create
        if (!$request->filled('list_id')) {
            $data['user_id'] = Auth::id();
        }

        // Proses gambar jika ada upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = file_get_contents($file);
        } else {
            $data['image'] = ''; // supaya tidak null
        }

        // Jika update
        if ($request->filled('list_id')) {
            $planning = Planning::where('list_id', $request->list_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $planning->update($data);
        }
        // Jika create baru
        else {
            Planning::create($data);
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

    public function cardPlanning()
    {
        $plans = Auth::check()
            ? Planning::where('user_id', Auth::id())->orderByDesc('timestamp')->get()
            : collect();

        return view('cardplanning', compact('plans'));
    }
    public function showImage($id)
    {
        $plan = Planning::findOrFail($id);

        if (!$plan->image) {
            abort(404);
        }

        return response($plan->image)
            ->header('Content-Type', 'image/jpeg'); // Sesuaikan jika kamu juga support PNG
    }

}
