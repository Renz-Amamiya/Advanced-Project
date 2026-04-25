<?php

namespace App\Http\Controllers;

use App\Models\MasterTutorial;
use App\Models\DetailTutorial;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PublicTutorialController extends Controller
{
    // 1. Halaman Presentation (Hanya status "show")
    public function presentation($slug)
    {
        $fullUrl = 'presentation/' . $slug;
        $master = MasterTutorial::where('url_presentation', $fullUrl)->firstOrFail();
        
        // Ambil detail yang statusnya HANYA show
        $details = DetailTutorial::where('master_tutorial_id', $master->id)
                                 ->where('status', 'show')
                                 ->orderBy('order', 'asc')
                                 ->get();

        return view('public.presentation', compact('master', 'details'));
    }

    // 2. Halaman Finished / PDF (Semua status tampil)
    public function finished($slug)
    {
        $fullUrl = 'finished/' . $slug;
        $master = MasterTutorial::where('url_finished', $fullUrl)->firstOrFail();
        
        // Ambil SEMUA detail tanpa melihat status show/hide
        $details = DetailTutorial::where('master_tutorial_id', $master->id)
                                 ->orderBy('order', 'asc')
                                 ->get();

        // Load view dan jadikan PDF
        $pdf = Pdf::loadView('public.pdf', compact('master', 'details'));
        
        // Gunakan stream() agar tampil di browser (seperti contoh di soal)
        return $pdf->stream('Tutorial-' . $master->judul . '.pdf');
    }

    // 3. API Server untuk list tutorial per mata kuliah
    public function apiMakul($kode_mk)
    {
        $tutorials = MasterTutorial::where('kode_mk', $kode_mk)
                        ->select('judul', 'url_presentation', 'url_finished', 'creator_email', 'created_at', 'updated_at')
                        ->get();

        return response()->json($tutorials);
    }
}