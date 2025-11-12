<?php

namespace App\Http\Controllers;

use App\Models\TeamManajemen;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimManajemen extends Controller
{
    public function timManajemen()
    {
        $data = [
            'title' => 'Tim Manajemen',
            'manajemen' => TeamManajemen::all(),
        ];

        return Inertia::render('user/Profile/TimManajemen', $data);
    }

    public function TmAdminPage(){
        $data = [
            'title' => 'Tim Manajemen',
            'manajemen' => TeamManajemen::all()
        ];

        return Inertia::render('admin/TimManajemen/Index', $data);
    }
}
