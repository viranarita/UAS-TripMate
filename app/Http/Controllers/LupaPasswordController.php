<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LupaPasswordController extends Controller
{
    public function showForm()
    {
        return view('lupaPassword');
    }

    public function handleRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->input('email');

        $user = DB::table('tb_Users')->where('email', $email)->first();

        if ($user) {
            // Redirect langsung ke halaman reset password dengan email di query
            return redirect()->route('password.reset', ['email' => $email]);
        } else {
            return redirect()->route('password.request')->with('error', 'Email tidak ditemukan.');
        }
    }
}
