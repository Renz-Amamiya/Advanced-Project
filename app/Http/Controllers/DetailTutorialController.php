<?php

namespace App\Http\Controllers;

use App\Models\MasterTutorial;
use App\Models\DetailTutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailTutorialController extends Controller
{
    public function index($id)
    {
        $master = MasterTutorial::findOrFail($id);
        // Ambil detail diurutkan berdasarkan 'order'
        $details = DetailTutorial::where('master_tutorial_id', $id)->orderBy('order', 'asc')->get();
        
        return view('detail.index', compact('master', 'details'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'order' => 'required|integer',
            'status' => 'required|in:show,hide',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            // Simpan gambar ke folder storage/app/public/tutorial_images
            $gambarPath = $request->file('gambar')->store('tutorial_images', 'public');
        }

        DetailTutorial::create([
            'master_tutorial_id' => $id,
            'text' => $request->text,
            'gambar' => $gambarPath,
            'code' => $request->code,
            'url' => $request->url,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Detail tutorial berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, $id)
    {
        $detail = DetailTutorial::findOrFail($id);
        $detail->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $detail = DetailTutorial::findOrFail($id);
        
        // Hapus file gambar jika ada
        if ($detail->gambar) {
            Storage::disk('public')->delete($detail->gambar);
        }
        
        $detail->delete();
        return back()->with('success', 'Detail tutorial berhasil dihapus!');
    }
}