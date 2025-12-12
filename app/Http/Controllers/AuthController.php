<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// --- PERBAIKAN: Tambahkan baris ini ---
use App\Models\User; 
// --------------------------------------

class AuthController extends Controller
{
    // php artisan make:controller AuthController
    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
        
        $data['password'] = bcrypt($request->password);
        
        // Sekarang kode ini akan berjalan karena 'User' sudah di-import di atas
        $user = User::create($data);
        
        // Catatan: Pastikan kamu menggunakan Passport. 
        // Jika pakai Sanctum, ganti 'accessToken' jadi 'plainTextToken'
        $token = $user->createToken('API Token')->accessToken;
        
        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function login(Request $request) {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;
        
        return response()->json(['user' => auth()->user(), 'token' => $token]);
    }

    // ... fungsi register dan login di atas ...

    public function logout(Request $request) {
        // Hapus token yang sedang dipakai user ini
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Berhasil Logout'
        ]);
    }
}
