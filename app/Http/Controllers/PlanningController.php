<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Planning;
use App\Models\Culinary;
use Illuminate\Support\Facades\DB;


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
        
            // Tambahkan logika ID baru
            $last = Planning::orderByDesc('list_id')->first();
            $newId = $last ? $last->list_id + 1 : 1;
            $data['list_id'] = $newId;
        
            // Handle upload image jika ada
            if ($request->hasFile('image')) {
                $data['image'] = file_get_contents($request->file('image')->getRealPath());
            }
        
            $planning = Planning::create($data);
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

        return redirect()->route('planning', ['edit' => $planning->list_id]);
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

        session()->put('current_plan_id', $id);

        $culinaries = DB::table('tb_Itinerary_Culinary as ic')
            ->join('tb_Culinary as c', 'ic.culinary_id', '=', 'c.culinary_id')
            ->where('ic.list_id', $id)
            ->select('c.*', DB::raw('true as is_saved'))
            ->get();

        $hotels = DB::table('tb_Itinerary_Hotel as ih')
            ->join('tb_Hotels as h', 'ih.hotel_id', '=', 'h.hotel_id')
            ->where('ih.list_id', $id)
            ->select('h.*', DB::raw('true as is_saved'))
            ->get();

        $attractions = DB::table('tb_Itinerary_Attractions as ia')
            ->join('tb_Attractions as a', 'ia.attraction_id', '=', 'a.attraction_id')
            ->where('ia.list_id', $id)
            ->select('a.*', DB::raw('true as is_saved'))
            ->get();

        return view('showplan', compact('plan', 'hotels', 'culinaries', 'attractions'));
    }
    public function destroy($list_id)
    {
        $planning = Planning::where('list_id', $list_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $planning->delete();

        return redirect()->route('planning')->with('success', 'Rencana perjalanan berhasil dihapus.');
    }
    public function toggleSave(Request $request, $type, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $planId = $request->session()->get('current_plan_id'); // Ambil dari session

        if (!$planId) {
            return back()->with('error', 'Rencana tidak ditemukan.');
        }

        switch ($type) {
            case 'culinary':
                $exists = DB::table('tb_Itinerary_Culinary')
                    ->where('culinary_id', $id)
                    ->where('list_id', $planId)
                    ->exists();

                if ($exists) {
                    DB::table('tb_Itinerary_Culinary')
                        ->where('culinary_id', $id)
                        ->where('list_id', $planId)
                        ->delete();
                } else {
                    DB::table('tb_Itinerary_Culinary')->insert([
                        'culinary_id' => $id,
                        'list_id' => $planId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            break;
            
            case 'attraction':
                $exists = DB::table('tb_Itinerary_Attractions')
                    ->where('attraction_id', $id)
                    ->where('list_id', $planId)
                    ->exists();
            
                if ($exists) {
                    DB::table('tb_Itinerary_Attractions')
                        ->where('attraction_id', $id)
                        ->where('list_id', $planId)
                        ->delete();
                } else {
                    DB::table('tb_Itinerary_Attractions')->insert([
                        'attraction_id' => $id,
                        'list_id' => $planId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            break;
            
            case 'hotel':
                $exists = DB::table('tb_Itinerary_Hotel')
                    ->where('hotel_id', $id)
                    ->where('list_id', $planId)
                    ->exists();
            
                if ($exists) {
                    DB::table('tb_Itinerary_Hotel')
                        ->where('hotel_id', $id)
                        ->where('list_id', $planId)
                        ->delete();
                } else {
                    DB::table('tb_Itinerary_Hotel')->insert([
                        'hotel_id' => $id,
                        'list_id' => $planId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
                break;
            
        }

        return back();
    }

}
