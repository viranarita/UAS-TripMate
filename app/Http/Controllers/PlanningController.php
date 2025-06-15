<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Planning;
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
        $request->validate([
            'list_name' => 'required|string|max:150',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:departure_date',
            'departure_city' => 'required|in:Surabaya,Jakarta,Bandung,Yogyakarta',
            'destination_city' => 'required|in:Surabaya,Jakarta,Bandung,Yogyakarta',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('list_name', 'departure_date', 'return_date', 'departure_city', 'destination_city');

        $data['list_id'] = $request->input('list_id');

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $data['image'] = file_get_contents($request->file('image')->getRealPath());
        }

        // Create
        if (!$request->filled('list_id')) {
            $last = Planning::orderByDesc('list_id')->first();
            if ($last) {
                $lastIdNumber = (int) substr($last->list_id, 4); // Ambil angka dari plan001 -> 1
                $newIdNumber = $lastIdNumber + 1;
            } else {
                $newIdNumber = 1;
            }
            $data['list_id'] = 'PLAN' . str_pad($newIdNumber, 3, '0', STR_PAD_LEFT); // jadi plan001, plan002, dst

            $data['user_id'] = Auth::id();

            Planning::create($data);
        } 
        // Update
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
                unset($data['image']); // pakai image lama
            }

            $planning->update($data);
        }

        return redirect()->route('planning', ['edit' => $data['list_id']]);
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

        $buses = DB::table('tb_Itinerary_Buses as ib')
            ->join('tb_Buses as b', 'ib.bus_id', '=', 'b.bus_id')
            ->where('ib.list_id', $id)
            ->select('b.*', DB::raw('true as is_saved'))
            ->get();
        
        $flights = DB::table('tb_Itinerary_Flights as ifl')
            ->join('tb_Flights as f', 'ifl.flight_id', '=', 'f.flight_id')
            ->where('ifl.list_id', $id)
            ->select('f.*', DB::raw('true as is_saved'))
            ->get();

        $trains = DB::table('tb_Itinerary_Trains as it')
            ->join('tb_Trains as t', 'it.train_id', '=', 't.train_id')
            ->where('it.list_id', $id)
            ->select('t.*', DB::raw('true as is_saved'))
            ->get();        
        
        return view('showplan', compact('plan', 'hotels', 'culinaries', 'attractions', 'buses', 'flights', 'trains'));
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

            case 'bus':
                $exists = DB::table('tb_Itinerary_Buses')
                        ->where('bus_id', $id)
                        ->where('list_id', $planId)
                        ->exists();
                
                    if ($exists) {
                        DB::table('tb_Itinerary_Buses')
                            ->where('bus_id', $id)
                            ->where('list_id', $planId)
                            ->delete();
                    } else {
                        DB::table('tb_Itinerary_Buses')->insert([
                            'bus_id' => $id,
                            'list_id' => $planId,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                        break;
            case 'flight':
                $exists = DB::table('tb_Itinerary_Flights')
                    ->where('flight_id', $id)
                    ->where('list_id', $planId)
                    ->exists();
                        
                if ($exists) {
                    DB::table('tb_Itinerary_Flights')
                    ->where('flight_id', $id)
                    ->where('list_id', $planId)
                    ->delete();
                        } else {
                            DB::table('tb_Itinerary_Flights')->insert([
                            'flight_id' => $id,
                            'list_id' => $planId,
                            'created_at' => now(),
                                'updated_at' => now()
                            ]);
                        }
                    break;
        
            case 'train':
                $exists = DB::table('tb_Itinerary_Trains')
                    ->where('train_id', $id)
                    ->where('list_id', $planId)
                    ->exists();
                    
                    if ($exists) {
                    DB::table('tb_Itinerary_Trains')
                        ->where('train_id', $id)
                        ->where('list_id', $planId)
                        ->delete();
                } else {
                        DB::table('tb_Itinerary_Trains')->insert([
                        'train_id' => $id,
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
