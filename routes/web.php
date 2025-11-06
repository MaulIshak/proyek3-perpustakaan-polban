<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelayananController;
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

Route::get('/pelayanan/{slug}', function (string $slug) {
    $pelayananContent = [
        'peminjaman' => [
            'title' => 'Peminjaman Buku',
            'icon' => 'BookOpen',
            'description' => 'Layanan peminjaman buku untuk mendukung kegiatan belajar dan penelitian',
            'content' => [
                [
                    'subtitle' => 'Ketentuan Peminjaman',
                    'items' => [
                        'Mahasiswa dapat meminjam maksimal 5 (lima) buku',
                        'Dosen dan staf dapat meminjam maksimal 10 (sepuluh) buku',
                        'Masa peminjaman mahasiswa: 14 hari',
                        'Masa peminjaman dosen/staf: 30 hari',
                        'Perpanjangan dapat dilakukan maksimal 2 kali'
                    ]
                ],
                [
                    'subtitle' => 'Alur Peminjaman',
                    'items' => [
                        'Cari buku yang diinginkan melalui katalog online (e-Lib)',
                        'Catat nomor panggil buku dan cari di rak koleksi',
                        'Bawa buku dan kartu anggota ke meja sirkulasi',
                        'Petugas akan memproses peminjaman dan mencetak slip',
                        'Simpan slip peminjaman sebagai bukti'
                    ]
                ]
            ]
        ],
        'pengembalian' => [
            'title' => 'Pengembalian Buku',
            'icon' => 'Clock',
            'description' => 'Prosedur pengembalian buku yang mudah dan praktis',
            'content' => [
                [
                    'subtitle' => 'Cara Pengembalian',
                    'items' => [
                        'Bawa buku yang akan dikembalikan ke meja sirkulasi',
                        'Serahkan buku beserta kartu anggota kepada petugas',
                        'Petugas akan memeriksa kondisi buku dan tanggal jatuh tempo',
                        'Jika ada denda keterlambatan, lakukan pembayaran',
                        'Simpan bukti pengembalian'
                        
                    ]
                ],
                [
                    'subtitle' => 'Ketentuan Denda',
                    'items' => [
                        'Denda keterlambatan: Rp 1.000 per hari per buku',
                        'Kehilangan buku: Ganti buku yang sama atau 2x harga buku',
                        'Kerusakan ringan: Rp 25.000 - Rp 50.000',
                        'Kerusakan berat: Sesuai harga buku',
                        'Pembayaran denda dapat dilakukan di kasir perpustakaan'
                    ]
                ]
            ]
        ],
        'keanggotaan' => [
            'title' => 'Keanggotaan',
            'icon' => 'Users',
            'description' => 'Informasi pendaftaran dan layanan keanggotaan perpustakaan',
            'content' => [
                [
                    'subtitle' => 'Syarat Keanggotaan',
                    'items' => [
                        'Mahasiswa aktif POLBAN dengan KTM yang masih berlaku',
                        'Dosen dan staff POLBAN dengan kartu pegawai',
                        'Mengisi formulir pendaftaran',
                        'Menyerahkan pas foto 3x4 sebanyak 2 lembar',
                        'Kartu anggota berlaku selama menjadi civitas akademika POLBAN'
                    ]
                ],
                [
                    'subtitle' => 'Hak Anggota',
                    'items' => [
                        'Meminjam buku sesuai kuota yang ditentukan',
                        'Mengakses katalog online dan database digital',
                        'Menggunakan fasilitas ruang baca dan komputer',
                        'Mengikuti program literasi dan pelatihan perpustakaan',
                        'Mendapatkan layanan referensi dan konsultasi'
                    ]
                ]
            ]
        ],
        'referensi' => [
            'title' => 'Pelayanan Referensi',
            'icon' => 'FileText',
            'description' => 'Bantuan pencarian informasi dan referensi akademik',
            'content' => [
                [
                    'subtitle' => 'Layanan yang Tersedia',
                    'items' => [
                        'Konsultasi pencarian referensi untuk tugas akhir',
                        'Bantuan penelusuran database jurnal internasional',
                        'Pelatihan penggunaan tools manajemen referensi (Mendeley, Zotero)',
                        'Layanan fotokopi artikel jurnal dan buku referensi',
                        'Bantuan sitasi dan penulisan daftar pustaka'
                    ]
                ],
                [
                    'subtitle' => 'Cara Mengakses',
                    'items' => [
                    'Datang langsung ke meja layanan referensi',
                    'Email ke perpustakaan@polban.ac.id dengan subjek \'Layanan Referensi\'',
                    'Jadwal konsultasi: Senin-Jumat, 09.00-15.00 WIB',
                    'Gratis untuk seluruh civitas akademika POLBAN',
                    'Dapat dijadwalkan untuk konsultasi kelompok'
                    ]
                ]
            ]
        ],
        'ruang-komputer' => [
            'title' => 'Ruang Komputer',
            'icon' => 'Laptop',
            'description' => 'Fasilitas komputer dengan akses internet untuk kegiatan akademik',
            'content' => [
                [
                    'subtitle' => 'Fasilitas',
                    'items' => [
                        '40 unit komputer dengan spesifikasi memadai',
                        'Koneksi internet berkecepatan tinggi',
                        'Microsoft Office dan software akademik',
                        'Printer dan scanner (berbayar)',
                        'AC dan pencahayaan yang baik'
                    ]
                ],
                [
                    'subtitle' => 'Tata Tertib Penggunaan',
                    'items' => [
                        'Wajib menunjukkan kartu anggota perpustakaan',
                        'Maksimal penggunaan 2 jam per sesi',
                        'Hanya untuk keperluan akademik',
                        'Dilarang mengunduh file ilegal atau bermain game',
                        'Jaga kebersihan dan ketenangan ruangan'
                    ]
                ]
            ]
        ]
    ];

    abort_if(!isset($pelayananContent[$slug]), 404);

    $data = $pelayananContent[$slug];

    return Inertia::render('Pelayanan/Show', [
        'pelayanan' => $data
    ]);
})->name('pelayanan.show');

// Route::get('/Peminjaman', function () {
//     return Inertia::render('user/layanan/Peminjaman');
// })->name('Peminjaman');

// Route::get('/Pengembalian', function () {
//     return Inertia::render('user/layanan/Pengembalian');
// })->name('Pengembalian');

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
