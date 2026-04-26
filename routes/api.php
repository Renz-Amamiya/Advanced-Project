<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TutorialApiController; // Controller khusus API

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rute API untuk SiAdin
Route::get('/{kode_mk}', [TutorialApiController::class, 'apiMakul']);