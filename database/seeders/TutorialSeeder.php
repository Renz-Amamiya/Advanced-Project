<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterTutorial;
use App\Models\DetailTutorial;
use Illuminate\Support\Str;

class TutorialSeeder extends Seeder
{
    public function run()
    {
        $emailDosen = 'aprilyani.safitri@gmail.com'; // Sesuai dengan akun login kamu

        // ==========================================
        // DATA TUTORIAL 1 (Pemrograman Berbasis Web)
        // ==========================================
        $judul1 = "Belajar Routing Dasar Laravel";
        $slug1 = Str::slug($judul1);
        $time1 = time();

        $master1 = MasterTutorial::create([
            'judul' => $judul1,
            'kode_mk' => 'A11.54314', // Kode Web Dasar dari API Postman
            'url_presentation' => "presentation/{$slug1}-{$time1}",
            'url_finished' => "finished/{$slug1}-{$time1}",
            'creator_email' => $emailDosen,
        ]);

        // Detail Langkah Tutorial 1
        DetailTutorial::create([
            'master_tutorial_id' => $master1->id,
            'text' => 'Buka file routes/web.php di dalam project Laravel Anda.',
            'order' => 1,
            'status' => 'show',
        ]);

        DetailTutorial::create([
            'master_tutorial_id' => $master1->id,
            'text' => 'Tambahkan kode berikut untuk membuat rute baru yang menampilkan teks sederhana.',
            'code' => "Route::get('/halo', function () {\n    return 'Halo, Selamat Belajar Laravel!';\n});",
            'order' => 2,
            'status' => 'show',
        ]);

        DetailTutorial::create([
            'master_tutorial_id' => $master1->id,
            'text' => 'Buka browser dan akses alamat http://localhost:8000/halo untuk melihat hasilnya.',
            'order' => 3,
            'status' => 'hide', // Sengaja di-hide agar bisa didemokan saat presentasi
        ]);


        // ==========================================
        // DATA TUTORIAL 2 (Pemrograman Web Lanjut)
        // ==========================================
        // Memberi jeda 1 detik agar unique ID (time) berbeda
        sleep(1); 
        
        $judul2 = "Membuat API Sederhana";
        $slug2 = Str::slug($judul2);
        $time2 = time();

        $master2 = MasterTutorial::create([
            'judul' => $judul2,
            'kode_mk' => 'A11.64404', // Kode Web Lanjut
            'url_presentation' => "presentation/{$slug2}-{$time2}",
            'url_finished' => "finished/{$slug2}-{$time2}",
            'creator_email' => $emailDosen,
        ]);

        // Detail Langkah Tutorial 2
        DetailTutorial::create([
            'master_tutorial_id' => $master2->id,
            'text' => 'Buat rute API baru di dalam file routes/api.php.',
            'code' => "Route::get('/data-mahasiswa', function () {\n    return response()->json([\n        'nama' => 'Raffael Ezra',\n        'nim' => 'A11.2024.xxxxx'\n    ]);\n});",
            'order' => 1,
            'status' => 'show',
        ]);

        DetailTutorial::create([
            'master_tutorial_id' => $master2->id,
            'text' => 'Buka aplikasi Postman, lalu lakukan request GET ke http://localhost:8000/api/data-mahasiswa.',
            'url' => 'https://www.postman.com/downloads/',
            'order' => 2,
            'status' => 'hide',
        ]);
    }
}