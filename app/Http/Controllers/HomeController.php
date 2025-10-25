<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Home',
            'description' => 'Selamat datang di perpustakaan polban'
        ];
        return Inertia::render('user/Home', $data);
    }
}
