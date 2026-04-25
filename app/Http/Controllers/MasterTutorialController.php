<?php

namespace App\Http\Controllers;

use App\Models\MasterTutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MasterTutorialController extends Controller
{
    public function index()
    {
        // 1. Ambil data dari database lokal
        $tutorials = MasterTutorial::latest()->get();

        // 2. Ambil token dari session
        $token = Session::get('token');

        // 3. Hit API untuk ambil Mata Kuliah
        $response = Http::withToken($token)->get('https://jwt-auth-eight-neon.vercel.app/getMakul');
        
        $makuls = [];
        if ($response->successful()) {
            $makuls = $response->json('data'); // Ambil array data-nya
        }

        return view('master.index', compact('tutorials', 'makuls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kode_mk' => 'required',
        ]);

        // Generate URL Unique pakai Str::slug dan timestamp biar unik
        $slug = Str::slug($request->judul);
        $uniqueId = time();

        MasterTutorial::create([
            'judul' => $request->judul,
            'kode_mk' => $request->kode_mk,
            'url_presentation' => "presentation/{$slug}-{$uniqueId}",
            'url_finished' => "finished/{$slug}-{$uniqueId}",
            'creator_email' => Session::get('user_email'), // Otomatis dari email login
        ]);

        return redirect()->route('master.index')->with('success', 'Master Tutorial berhasil ditambahkan!');
    }

    // Fungsi destroy untuk Hapus data
    public function destroy($id)
    {
        MasterTutorial::findOrFail($id)->delete();
        return redirect()->route('master.index')->with('success', 'Tutorial berhasil dihapus!');
    }
}