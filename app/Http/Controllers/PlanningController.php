<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Planning;

class PlanningController extends Controller
{
    public function index(Request $request)
    {
        $plans = Planning::where('user_id', Auth::id())->orderByDesc('timestamp')->get();

        $planToEdit = null;
        if ($request->has('edit')) {
            $planToEdit = Planning::find($request->edit);
        }

        return view('planning', compact('plans', 'planToEdit'));
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('list_name', 'departure_date', 'return_date', 'departure_city', 'destination_city');

        // Jika create baru
        if (!$request->filled('list_id')) {
            $data['user_id'] = Auth::id();

            // Handle upload image jika ada
            if ($request->hasFile('image')) {
                $data['image'] = file_get_contents($request->file('image')->getRealPath());
            }

            Planning::create($data);
        }
        // Jika update
        else {
            $planning = Planning::where('list_id', $request->list_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Handle image
            if ($request->hasFile('image')) {
                $data['image'] = file_get_contents($request->file('image')->getRealPath());
            } elseif ($request->filled('old_image')) {
                $data['image'] = base64_decode($request->input('old_image'));
            } else {
                $data['image'] = $planning->image; // fallback terakhir
            }

            $planning->update($data);
        }

        return redirect()->route('planning', ['edit' => $request->list_id]);
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
    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $plan = Planning::where('list_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('showplan', compact('plan'));
    }
    public function destroy($list_id)
    {
        $planning = Planning::where('list_id', $list_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $planning->delete();

        return redirect()->route('planning')->with('success', 'Rencana perjalanan berhasil dihapus.');
    }

}
