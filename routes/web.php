<?php

use App\Http\Controllers\AuthClientController;
use App\Http\Controllers\MasterTutorialController;
use App\Http\Controllers\DetailTutorialController;
use App\Http\Controllers\PublicTutorialController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthClientController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthClientController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthClientController::class, 'logout'])->name('logout');
// Rute untuk Detail Tutorial
Route::get('/master-tutorial/{id}/detail', [DetailTutorialController::class, 'index'])->name('detail.index');
Route::post('/master-tutorial/{id}/detail', [DetailTutorialController::class, 'store'])->name('detail.store');
Route::post('/detail-tutorial/{id}/update-status', [DetailTutorialController::class, 'updateStatus'])->name('detail.updateStatus');
Route::delete('/detail-tutorial/{id}', [DetailTutorialController::class, 'destroy'])->name('detail.destroy');
// Rute Public (Mahasiswa / Tanpa Login)
Route::get('/presentation/{slug}', [PublicTutorialController::class, 'presentation']);
Route::get('/finished/{slug}', [PublicTutorialController::class, 'finished']);
// Rute API untuk SiAdin
Route::get('/api/{kode_mk}', [PublicTutorialController::class, 'apiMakul']);

// Rute yang butuh autentikasi (harus login)
Route::middleware([\App\Http\Middleware\CekTokenApi::class])->group(function () {
    Route::resource('master-tutorial', MasterTutorialController::class)->names('master');
});