<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canRegister' => Features::enabled(Features::registration()),
//     ]);
// })->name('home');

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\ArticleController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    // show login form (only for guests of admin guard)
    Route::get('login', [LoginController::class, 'showLogin'])->middleware('guest:admin')->name('login');

    // perform login
    Route::post('login', [LoginController::class, 'login'])->name('login.post');

    // logout
    Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:admin')->name('logout');

    // admin dashboard (protected)
    Route::get('dashboard', function () {
        return Inertia::render('admin/Dashboard');
    })->middleware('auth:admin')->name('dashboard');

    // Berita
    Route::get('berita', [ArticleController::class, 'index'])->middleware('auth:admin')->name('beritaIndex');
    Route::get('berita/create', function(){
        return Inertia::render('admin/berita/Create');
    })->middleware('auth:admin')->name('beritaCreate');

});

require __DIR__.'/settings.php';
