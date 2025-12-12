<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;

// Route Public (Tidak butuh login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{id}', [NewsController::class, 'show']);

// --- ROUTE YANG BUTUH LOGIN (PROTECTED) ---
Route::middleware('auth:api')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Kirim Komentar
    Route::post('/news/{id}/comment', [NewsController::class, 'storeComment']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});