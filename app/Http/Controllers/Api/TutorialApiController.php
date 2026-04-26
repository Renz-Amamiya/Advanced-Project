<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterTutorial;

class TutorialApiController extends Controller
{
    // API Server untuk SiAdin (Menampilkan JSON)
    public function apiMakul($kode_mk)
    {
        // Ambil data dari database tanpa select spesifik agar kita bisa memetakan (map) isinya
        $tutorials = MasterTutorial::where('kode_mk', $kode_mk)->get();

        // Format isinya sesuai struktur yang diminta di gambar
        $results = $tutorials->map(function ($item) {
            return [
                'kode_matkul' => $item->kode_mk,
                // Tambahkan nama_matkul (karena tidak ada di database, kita beri default sementara)
                'nama_matkul' => 'Pemrograman Web Lanjut', 
                'judul' => $item->judul,
                'url_presentation' => url($item->url_presentation),
                'url_finished' => url($item->url_finished),
                'creator_email' => $item->creator_email,
                'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                'updated_at' => $item->updated_at ? $item->updated_at->format('Y-m-d H:i:s') : null,
            ];
        });

        // Kembalikan response JSON
        return response()->json([
            'results' => $results,
            'status' => [
                'code' => 200,
                'description' => 'OK'
            ]
        ], 200);
    }
}
