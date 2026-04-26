<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterTutorial;
use App\Models\DetailTutorial;
use Illuminate\Support\Facades\Storage;

class DetailTutorialController extends Controller
{
    public function index($id)
    {
        $master = MasterTutorial::findOrFail($id); // atau nama variable sesuai kebutuhan
        $details = DetailTutorial::where('master_tutorial_id', $id)->get();
    
        return view('detail.index', compact('master', 'details'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'order' => 'required|numeric',
            'text' => 'nullable|string',
            'code' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'url' => 'nullable|url'
        ]);

        $data = $request->all();
        $data['master_tutorial_id'] = $id;
        $data['status'] = 'show'; // Default langsung Show

        // Proses Upload Gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tutorial-images', 'public');
        }

        DetailTutorial::create($data);

        return redirect()->back()->with('success', 'MISSION LOG UPDATED: Langkah baru berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, $id)
    {
        $detail = DetailTutorial::findOrFail($id);
        $detail->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'STATUS OVERRIDDEN: Visibilitas langkah diubah!');
    }

    public function destroy($id)
    {
        $detail = DetailTutorial::findOrFail($id);
        
        // Hapus file gambar dari folder jika ada
        if ($detail->image) {
            Storage::disk('public')->delete($detail->image);
        }
        
        $detail->delete();

        return redirect()->back()->with('success', 'TARGET ELIMINATED: Langkah berhasil dihapus!');
    }
}