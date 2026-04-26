<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterTutorial;
use App\Models\DetailTutorial;

class PublicTutorialController extends Controller
{
    // Halaman Presentation (HANYA status 'Show' & Auto-Refresh)
    public function presentation($slug)
    {
        // Cari master berdasarkan slug di URL
        $master = MasterTutorial::where('url_presentation', 'LIKE', '%' . $slug . '%')->firstOrFail();
        
        // Ambil detail yang HANYA berstatus SHOW
        $details = DetailTutorial::where('master_tutorial_id', $master->id)
                    ->where('status', 'show')
                    ->orderBy('order', 'asc')
                    ->get();

        // Cek apakah ada detail yang masih berstatus 'hide'
        $hasHidden = DetailTutorial::where('master_tutorial_id', $master->id)
                    ->where('status', 'hide')
                    ->exists();
        
        // Cek apakah sudah ada materi sama sekali
        $hasDetails = DetailTutorial::where('master_tutorial_id', $master->id)->exists();

        // Tombol finish hanya aktif jika sudah ada materi dan TIDAK ADA yang di-hide
        $canFinish = $hasDetails && !$hasHidden;

        return view('public.presentation', compact('master', 'details', 'canFinish'));
    }

    // Halaman Full PDF (Semua status 'Show' & 'Hide' tampil)
    public function finished($slug)
    {
        $master = MasterTutorial::where('url_finished', 'LIKE', '%' . $slug . '%')->firstOrFail();
        
        // Ambil SEMUA detail tanpa filter status
        $details = DetailTutorial::where('master_tutorial_id', $master->id)
                    ->orderBy('order', 'asc')
                    ->get();

        return view('public.pdf', compact('master', 'details'));
    }


}