<?php

namespace App\Http\Controllers;

use App\Models\BookCover;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(){
        $covers = BookCover::latest()->limit(6)->get();

        $data = [
            'title' => 'Home',
            'description' => 'Selamat datang di perpustakaan polban',
            'book_covers' => $covers
        ];
        // dd($data['book_covers'])
        return Inertia::render('user/Home', $data);
    }
}
