<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;

class UsersController extends Controller
{
    public function index()
    {
        $users = Users::all();
        return view('users', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|email|max:150|unique:tb_Users,email',
            'password' => 'required|string|min:6|confirmed',  // pakai confirmed agar cek password_confirmation
        ]);

        // Ambil user_id terakhir dan tambah 1
        $latestId = Users::max('user_id') ?? 0;

        $user = Users::create([
            'user_id' => $latestId + 1,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // password akan otomatis di-hash karena setPasswordAttribute di model
        ]);

        // Login user langsung setelah register
        Auth::login($user);

        // Redirect ke homepage dengan flash message sukses
        return redirect('/')->with('success', 'Registrasi berhasil, selamat datang!');
    }


    public function update(Request $request, $id)
    {
        $user = Users::where('user_id', $id)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Users tidak ditemukan');
        }

        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|string|email|max:150|unique:tb_Users,email,' . $id . ',user_id',
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = $request->password; // auto hash oleh model
        }

        $user->save();

        return redirect()->back()->with('success', 'Users berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = Users::where('user_id', $id)->first();
        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'Users berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Users tidak ditemukan');
    }
}
