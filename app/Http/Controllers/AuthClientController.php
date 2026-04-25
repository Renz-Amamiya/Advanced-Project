<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthClientController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Hit endpoint API untuk login
        $response = Http::post('https://jwt-auth-eight-neon.vercel.app/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful() && $response->json('refreshToken')) {
            // Simpan token dan email di Session Laravel
            Session::put('token', $response->json('refreshToken'));
            Session::put('user_email', $request->email);
            
            return redirect()->route('master.index')->with('success', 'Berhasil Login!');
        }

        return back()->with('error', 'Email atau Password salah.');
    }

    public function logout()
    {
        $token = Session::get('token');

        if ($token) {
            // Hit endpoint API untuk logout (pakai Bearer token)
            Http::withToken($token)->get('https://jwt-auth-eight-neon.vercel.app/logout');
        }

        // Hapus session
        Session::forget(['token', 'user_email']);
        return redirect()->route('login')->with('success', 'Berhasil Logout');
    }
}