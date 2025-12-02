<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\BookProposalController;
use App\Http\Controllers\BebasMasalahController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\EJournalController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CoverBuku;
use App\Http\Controllers\RencanaStrategi;
use App\Http\Controllers\TimManajemen;

Route::post('/send-question', [QuestionController::class, 'send']);

Route::get('/pelayanan/{slug}', function (string $slug) {
    return Inertia::render('Pelayanan/Show', [
        'pelayanan' => $slug
    ]);
});

Route::get('/bebas_masalah', [BebasMasalahController::class, 'ViewUser']);

Route::get('/gallery', [GaleriController::class, 'index']);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    $data = [
        'title' => 'Tentang Perpustakaan',
        'subjudul_1' => 'Sejarah',
        'subjudul_2' => 'Visi',
        'subjudul_3' => 'Misi',
        'misi' => [
            'Menyediakan koleksi mutakhir dan pelayanan yang efektif dengan memberikan akses informasi 24 jam.',
            'Menyediakan berbagai pilihan fasilitas belajar mandiri untuk mencapai prestasi akademik yang optimal.'
        ],
    ];
    return Inertia::render('user/Profile/About', $data);
});

// Fasilitas
Route::get('/facilities', function () {
    $data = [
        'title' => 'Fasilitas Perpustakaan',
        'subtitle' => 'Berbagai fasilitas modern untuk mendukung kegiatan belajar Anda',
        'facilities' => [
            [
                'subjudul' => 'Ruang Sirkulasi',
                'description' => 'Fasilitas 40 unit komputer dengan akses internet cepat, tersedia untuk browsing, mengakses e-journal, dan mengerjakan tugas.',
                'image' => '/Images/sirkulasi.jpeg',
            ],
            [
                'subjudul' => 'Ruang Baca',
                'description' => 'Ruang baca dengan kapasitas 150 orang, dilengkapi dengan AC, pencahayaan yang baik, dan suasana tenang untuk mendukung aktivitas belajar mandiri.',
                'image' => '/Images/ruang-baca.jpg',
            ],
            [
                'subjudul' => 'Ruang Referensi',
                'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sit excepturi quia a maxime quisquam impedit qui velit optio iusto. Voluptas beatae similique corporis ex ipsam eveniet assumenda, possimus nobis distinctio.',
                'image' => '/Images/referensi.jpeg'
            ],
            [
                'subjudul' => 'Ruang Komputer',
                'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sit excepturi quia a maxime quisquam impedit qui velit optio iusto. Voluptas beatae similique corporis ex ipsam eveniet assumenda, possimus nobis distinctio.',
                'image' => '/Images/komputer.jpeg'
            ],
            [
                'subjudul' => 'Ruang Belajar Mandiri',
                'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sit excepturi quia a maxime quisquam impedit qui velit optio iusto. Voluptas beatae similique corporis ex ipsam eveniet assumenda, possimus nobis distinctio.',
                'image' => '/Images/RBM.jpeg'
            ],
            [
                'subjudul' => 'Self Loan Machine',
                'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sit excepturi quia a maxime quisquam impedit qui velit optio iusto. Voluptas beatae similique corporis ex ipsam eveniet assumenda, possimus nobis distinctio.',
                'image' => '/Images/selfloan.jpeg'
            ]
        ],
    ];

    return Inertia::render('user/Profile/Facilities', $data);
});

// Tim Manajemen User
Route::get('/tim-manajemen', [TimManajemen::class, 'timManajemen'])->name('tim manajemen');

// Kontak User
Route::get('/contact', function () {
    $data = [
        'title' => 'Hubungi Kami',
        'subjudul' => 'Informasi Kontak'
    ];

    return Inertia::render('user/Kontak/Kontak', $data);
});

Route::get('usulan_buku', [BookProposalController::class, 'create'])->name('user.book-proposals.create');
Route::post('usulan-buku/store', [BookProposalController::class, 'store'])->name('user.book-proposals.store');

Route::get('/e-journal', [EJournalController::class, 'ShowUser'])->name('ejournal.ShowUser');

Route::get('/berita', [ArticleController::class, 'beritaUser'])->name('beritaUser');
Route::get('/berita/{id}', [ArticleController::class, 'showBeritaUser'])->name('showBeritaUser');
Route::get('/pengumuman', [ArticleController::class, 'pengumumanUser'])->name('pengumumanUser');
Route::get('/pengumuman/{id}', [ArticleController::class, 'showPengumumanUser'])->name('showPengumumanUser');

// Peraturan Perpustakaan
Route::get('/peraturan', function (){
    $data = [
        'title' => 'Peraturan Perpustakaan'
    ];

    return Inertia::render('user/Profile/Peraturan', $data);
});

// Jam Layanan
Route::get('/jam-layanan', function (){
    $data = [
        'title' => 'Jam Layanan',

    ];

    return Inertia::render('user/Profile/JamLayanan', $data);
});

Route::get('/e-collection', [CollectionController::class, 'ShowUser']);

// Booking Buku
// 1. Untuk Menampilkan Halaman (GET)
Route::get('/book-reservation', [BookingController::class, 'create'])->name('booking.create');

// 2. Untuk Mengirim Data Form (POST) -> Ini yang sebelumnya hilang
Route::post('/book-reservation', [BookingController::class, 'store'])->name('booking.store');

// Renstra
Route::get('/renstra', [RencanaStrategi::class, 'viewPDF'])->name('renstra');



Route::prefix('admin')->name('admin.')->group(function () {
    // show login form (only for guests of admin guard)
    Route::get('login', [LoginController::class, 'showLogin'])->middleware('guest.admin')->name('login');

    // perform login
    Route::post('login', [LoginController::class, 'login'])->name('login.post');

    // logout
    Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:admin')->name('logout');

    // admin dashboard (protected)
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->middleware('auth:admin')->name('dashboard');

    // Berita
    Route::get('berita', [ArticleController::class, 'index'])->middleware('auth:admin')->name('beritaIndex');
    Route::get('berita/create', function(){
        return Inertia::render('admin/berita/Create');
    })->middleware('auth:admin')->name('beritaCreate');

    Route::post('berita/store', [ArticleController::class, 'storeBerita'])
    ->middleware('auth:admin')
    ->name('beritaStore');

    Route::get('berita/detail/{id}', [ArticleController::class, 'showBerita'])->middleware('auth:admin')->name('beritaShow');
    Route::get('berita/edit/{id}', [ArticleController::class, 'editBerita'])->middleware('auth:admin');
    Route::post('berita/update/{id}', [ArticleController::class, 'updateBerita'])->middleware('auth:admin');
    Route::delete('berita/delete/{id}', [ArticleController::class, 'destroyBerita'])->middleware('auth:admin');

    // Pengumuman
    Route::get('pengumuman', [ArticleController::class, 'indexPengumuman'])->middleware('auth:admin')->name('pengumumanIndex');
    Route::get('pengumuman/create', function(){
        return Inertia::render('admin/pengumuman/Create');
    })->middleware('auth:admin')->name('pengumumanCreate');
    Route::post('pengumuman/store', [ArticleController::class, 'storePengumuman'])
    ->middleware('auth:admin')
    ->name('pengumumanStore');
    Route::get('pengumuman/detail/{id}', [ArticleController::class, 'showPengumuman'])->middleware('auth:admin')->name('pengumumanShow');
    Route::get('pengumuman/edit/{id}', [ArticleController::class, 'editPengumuman'])->middleware('auth:admin');
    Route::put('pengumuman/update/{id}', [ArticleController::class, 'updatePengumuman'])->middleware('auth:admin');
    Route::delete('pengumuman/delete/{id}', [ArticleController::class, 'destroyPengumuman'])->middleware('auth:admin');
    Route::get('berita/edit/{id}', [ArticleController::class, 'editBerita'])->middleware('auth:admin');
    Route::put('berita/update/{id}', [ArticleController::class, 'updateBerita'])->middleware('auth:admin');
    Route::delete('berita/delete/{id}', [ArticleController::class, 'destroyBerita'])->middleware('auth:admin');

    // galeri
    Route::get('galeri/', [PhotoController::class, 'index'])->middleware('auth:admin')->name('index');
    Route::post('galeri/store', [PhotoController::class, 'store'])->middleware('auth:admin')->name('store');
    Route::put('galeri/{foto_id}', [PhotoController::class, 'update'])->middleware('auth:admin')->name('update');
    Route::delete('galeri/{foto_id}', [PhotoController::class, 'destroy'])->middleware('auth:admin')->name('delete');

    // usulan
    Route::get('usulan-buku', [BookProposalController::class, 'index'])->middleware('auth:admin')->name('book-proposals.index');
    Route::patch('usulan-buku/{id}/status', [BookProposalController::class, 'updateStatus'])->middleware('auth:admin')->name('book-proposals.update-status');
    Route::delete('usulan-buku/{id}', [BookProposalController::class, 'destroy'])->middleware('auth:admin')->name('book-proposals.destroy');
    Route::get('usulan-buku/export', [BookProposalController::class, 'export'])->middleware('auth:admin')->name('book-proposals.export');


    // Tim manajemen
    Route::get('tim-manajemen', [TimManajemen::class, 'TmAdminPage'])->middleware('auth:admin')->name('tim.index');
    Route::post('tim-manajemen/store', [TimManajemen::class, 'store'])->middleware('auth:admin')->name('tim.store');
    Route::put('tim-manajemen/update/{id}', [TimManajemen::class, 'update'])->middleware('auth:admin')->name('tim.update');
    Route::delete('tim-manajemen/delete/{id}', [TimManajemen::class, 'destroy'])->middleware('auth:admin')->name('tim.destroy');

    // Renstra
    Route::get('renstra', [RencanaStrategi::class, 'index'])->middleware('auth:admin')->name('renstra.index');
    Route::post('renstra/store', [RencanaStrategi::class, 'store'])->middleware('auth:admin')->name('renstra.store');
    Route::put('renstra/update/{id}', [RencanaStrategi::class, 'update'])->middleware('auth:admin')->name('renstra.update');
    Route::delete('renstra/delete/{id}', [RencanaStrategi::class, 'destroy'])->middleware('auth:admin')->name('renstra.destroy');

    // Cover Buku
    Route::get('cover-buku', [CoverBuku::class, 'index'])->name('cover.index');
    Route::post('cover-buku/store', [CoverBuku::class, 'store'])->name('cover.store');
    // Kita pakai POST untuk update file (dengan _method: PUT di frontend)
    Route::post('cover-buku/update/{id}', [CoverBuku::class, 'update'])->name('cover.update');
    Route::delete('cover-buku/delete/{id}', [CoverBuku::class, 'destroy'])->name('cover.destroy');

    // BebasMasalah
    Route::get('/bebas-masalah', [BebasMasalahController::class, 'index'])->middleware('auth:admin')->name('admin.bebas-masalah.index');
    // (Alur, Template, Watermark)
    Route::post('/bebas-masalah/settings', [BebasMasalahController::class, 'updateSettings'])->middleware('auth:admin')->name('admin.bebas-masalah.settings.update');
    // Persyaratan
    Route::post('/bebas-masalah/requirements', [BebasMasalahController::class, 'storeRequirement'])->middleware('auth:admin')->name('admin.bebas-masalah.requirements.store');
    Route::put('/bebas-masalah/requirements/{id}', [BebasMasalahController::class, 'updateRequirement'])->middleware('auth:admin')->name('admin.bebas-masalah.requirements.update');
    Route::delete('/bebas-masalah/requirements/{id}', [BebasMasalahController::class, 'destroyRequirement'])->middleware('auth:admin')->name('admin.bebas-masalah.requirements.destroy');
    // Panduan
    Route::post('/bebas-masalah/guides', [BebasMasalahController::class, 'storeGuide'])->middleware('auth:admin')->name('admin.bebas-masalah.guides.store');
    Route::put('/bebas-masalah/guides/{id}', [BebasMasalahController::class, 'updateGuide'])->middleware('auth:admin')->name('admin.bebas-masalah.guides.update');
    Route::delete('/bebas-masalah/guides/{id}', [BebasMasalahController::class, 'destroyGuide'])->middleware('auth:admin')->name('admin.bebas-masalah.guides.destroy');

    // ecollection
    Route::get('/e-collections', [CollectionController::class, 'index']);
    Route::post('/e-collections', [CollectionController::class, 'store']);
    // Edit pakai POST karena method spoofing
    Route::post('/e-collections/{id}', [CollectionController::class, 'update']);
    Route::delete('/e-collections/{id}', [CollectionController::class, 'destroy']);

    // Ejournal
    // 1. GET: Menampilkan halaman (Index)
    Route::get('/e-journals', [EJournalController::class, 'index'])
        ->name('e-journals.index');

    // 2. POST: Menyimpan data baru (Store)
    Route::post('/e-journals', [EJournalController::class, 'store'])
        ->name('e-journals.store');

    // 3. PUT: Mengupdate data (Update)
    // Menggunakan {ejournal} agar otomatis mencari data berdasarkan ID
    Route::put('/e-journals/{ejournal}', [EJournalController::class, 'update'])
        ->name('e-journals.update');

    // 4. DELETE: Menghapus data (Destroy)
    Route::delete('/e-journals/{ejournal}', [EJournalController::class, 'destroy'])
        ->name('e-journals.destroy');

    // Booking Buku
    Route::get('booking-buku', [BookingController::class, 'indexAdmin'])->name('booking.index');
    // Update Status (Setuju/Tolak/Batal)
    Route::patch('booking-buku/{id}/status', [BookingController::class, 'updateStatus'])->name('booking.status');
    // Hapus Data
    Route::delete('booking-buku/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');

});

require __DIR__.'/settings.php';
