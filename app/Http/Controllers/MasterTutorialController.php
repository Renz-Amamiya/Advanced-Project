<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterTutorial;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class MasterTutorialController extends Controller
{
    public function index()
    {
        $tutorials = MasterTutorial::all();
        $makuls = []; // Wadah default kosong

        // 1. Ambil Token dari Session
        $token = Session::get('token') ?? Session::get('refreshToken') ?? Session::get('access_token'); 

        // 2. Jika token ada, tembak API Vercel
        if ($token) {
            $response = Http::withToken($token)->get('https://jwt-auth-eight-neon.vercel.app/getMakul');

            if ($response->successful()) {
                $hasilApi = $response->json();
                // Deteksi otomatis apakah data dibungkus 'data' atau langsung array
                $makuls = isset($hasilApi['data']) ? $hasilApi['data'] : $hasilApi;
            }
        }

        return view('master.index', compact('tutorials', 'makuls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kode_mk' => 'required'
        ]);

        $slug = \Str::slug($request->judul);
        $uniqueTs = time();

        MasterTutorial::create([
            'judul' => $request->judul,
            'kode_mk' => $request->kode_mk,
            'creator_email' => Session::get('user_email') ?? 'admin@mail.com',
            'url_presentation' => 'presentation/' . $slug . '-' . $uniqueTs,
            'url_finished' => 'finished/' . $slug . '-' . ($uniqueTs + random_int(100, 999)),
        ]);

        return redirect()->route('master.index')->with('success', 'MISSION LOG: Tutorial Baru Berhasil Dibuat!');
    }

    public function destroy($id)
    {
        $tutorial = MasterTutorial::findOrFail($id);
        $tutorial->delete();
        return redirect()->route('master.index')->with('success', 'TARGET ELIMINATED: Tutorial berhasil dihapus!');
    }
}