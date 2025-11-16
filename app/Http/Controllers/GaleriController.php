<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GaleriController extends Controller
{
    public function index()
    {
        $photos = Photo::where('tipe', 'galeri')->get();
        return Inertia::render('Galeri/Galeri', [
            'photos' => $photos,
        ]);
    }
}
