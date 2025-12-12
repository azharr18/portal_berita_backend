<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// --- TAMBAHAN PENTING: Import Model ---
use App\Models\News; 
use App\Models\Comment;
// --------------------------------------

class NewsController extends Controller
{
    // php artisan make:controller NewsController
    public function index() {
        // Mengambil semua berita
        return response()->json(News::all());
    }

    public function show($id) {
        // Mengambil berita spesifik beserta komentarnya
        $news = News::with('comments.user')->find($id); // Saya tambahkan .user agar nama pengomentar juga ikut terambil (opsional)
        
        if (!$news) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        return response()->json($news);
    }

    public function storeComment(Request $request, $id) {
        $request->validate(['comment' => 'required']);
        
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'news_id' => $id,
            'comment' => $request->comment
        ]);
        
        return response()->json(['message' => 'Comment added', 'data' => $comment]);
    }
}