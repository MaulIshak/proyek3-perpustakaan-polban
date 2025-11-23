<?php

namespace App\Http\Controllers;

use App\Models\BookCover;
use App\Models\Article; // Import the Article model
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(){
        $covers = BookCover::latest()->limit(6)->get();
        $latestNews = Article::where('type', 'berita')
                            ->where('status', 'published')
                            ->latest('created_date')
                            ->limit(3)
                            ->get();
        $latestAnnouncements = Article::where('type', 'pengumuman')
                                    ->where('status', 'published')
                                    ->latest('created_date')
                                    ->limit(3)
                                    ->get();

        $data = [
            'title' => 'Home',
            'description' => 'Selamat datang di perpustakaan polban',
            'book_covers' => $covers,
            'latest_news' => $latestNews, // Pass latest news to the view
            'latest_announcements' => $latestAnnouncements // Pass latest announcements to the view
        ];
        // dd($data['book_covers'])
        return Inertia::render('user/Home', $data);
    }
}
