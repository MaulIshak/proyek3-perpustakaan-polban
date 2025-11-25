<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar Penulis (Agar terlihat variatif)
        $authors = [
            'Dr. Rina Pustakawati, S.IP',
            'Budi Santoso, M.Kom (Ka. IT)',
            'Siti Aminah, S.Hum (Layanan Sirkulasi)',
            'Admin Perpustakaan',
            'Humas POLBAN'
        ];

        // Koleksi Gambar Unsplash yang Relevan (Library, Books, Tech, Student)
        // Format: ID gambar spesifik untuk performa dan relevansi
        $images = [
            'library' => 'https://images.unsplash.com/photo-1507842217153-656bfae75262?w=800&q=80', // Gedung/Rak buku
            'study'   => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&q=80', // Orang belajar
            'tech'    => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=800&q=80', // Coding/Matrix
            'meeting' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&q=80', // Diskusi
            'books'   => 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=800&q=80', // Buku estetik
            'coffee'  => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=800&q=80', // Kopi & Buku
            'server'  => 'https://images.unsplash.com/photo-1558494949-ef526b0042a0?w=800&q=80', // Server
        ];

        $placeholderPdf = 'https://s2.q4cdn.com/175719177/files/doc_presentations/Placeholder-PDF.pdf';

        // --- 1. SEED BERITA (7 ITEM) ---
        // Menggunakan sintaks HERODOC (<<<HTML) agar penulisan HTML rapi

        $beritaList = [
            [
                'judul' => 'Transformasi Digital: Perpustakaan POLBAN Luncurkan Smart Kiosk',
                'img' => $images['tech'],
                'konten' => <<<HTML
                    <p>Dalam upaya meningkatkan efisiensi layanan, Perpustakaan POLBAN dengan bangga meluncurkan <strong>Smart Kiosk v2.0</strong>.</p>
                    <h2>Apa itu Smart Kiosk?</h2>
                    <p>Ini adalah anjungan mandiri yang memungkinkan mahasiswa melakukan peminjaman dan pengembalian buku tanpa antre di meja sirkulasi. Teknologi ini menggunakan RFID (Radio Frequency Identification).</p>
                    <h3>Fitur Utama:</h3>
                    <ul>
                        <li>Peminjaman mandiri dalam waktu kurang dari 10 detik.</li>
                        <li>Cek status denda secara <em>real-time</em>.</li>
                        <li>Rekomendasi buku berbasis AI.</li>
                    </ul>
                    <p>Kami mengajak seluruh civitas akademika untuk mulai beralih menggunakan fasilitas ini mulai Senin depan.</p>
HTML
            ],
            [
                'judul' => 'Workshop Literasi Informasi: Menghindari Predatory Journals',
                'img' => $images['meeting'],
                'konten' => <<<HTML
                    <p>Mahasiswa tingkat akhir sering terjebak dalam jurnal predator saat menyusun tugas akhir. Oleh karena itu, kami mengadakan workshop intensif.</p>
                    <h2>Materi yang Akan Dibahas</h2>
                    <ol>
                        <li>Cara mengidentifikasi jurnal terindeks Scopus/Sinta yang valid.</li>
                        <li>Teknik sitasi menggunakan Mendeley dan Zotero.</li>
                        <li>Etika penulisan ilmiah.</li>
                    </ol>
                    <blockquote>"Kualitas riset tidak hanya ditentukan oleh isinya, tapi juga di mana ia dipublikasikan." - Kepala Perpustakaan</blockquote>
                    <p>Segera daftarkan diri Anda melalui portal akademik.</p>
HTML
            ],
            [
                'judul' => 'Penambahan 500 Koleksi E-Book Engineering Terbaru',
                'img' => $images['library'],
                'konten' => <<<HTML
                    <p>Kabar gembira bagi mahasiswa Jurusan Teknik Mesin dan Elektro! Kami baru saja berlangganan paket E-Book premium dari <strong>Springer dan IEEE</strong>.</p>
                    <p>Koleksi ini mencakup topik-topik hangat seperti:</p>
                    <ul>
                        <li>Renewable Energy Systems</li>
                        <li>Advanced Robotics & AI</li>
                        <li>Microcontroller Architecture</li>
                    </ul>
                    <p>Akses dapat dilakukan melalui VPN kampus atau login SSO dari rumah masing-masing.</p>
HTML
            ],
            [
                'judul' => 'Bedah Buku: "Filosofi Teras" Bersama Penulis',
                'img' => $images['books'],
                'konten' => <<<HTML
                    <p>Stoikisme menjadi topik yang hangat diperbincangkan belakangan ini. Perpustakaan mengundang penulis <em>best-seller</em> untuk membedah buku tersebut.</p>
                    <h2>Detail Acara</h2>
                    <p>Acara akan dilaksanakan di Auditorium Utama pada:</p>
                    <ul>
                        <li><strong>Hari/Tanggal:</strong> Sabtu, 25 November 2025</li>
                        <li><strong>Pukul:</strong> 09:00 - 12:00 WIB</li>
                    </ul>
                    <p>Disediakan <em>doorprize</em> berupa 10 buku bertanda tangan penulis bagi penanya terbaik.</p>
HTML
            ],
            [
                'judul' => 'Renovasi Co-Working Space Lantai 3 Selesai',
                'img' => $images['coffee'],
                'konten' => <<<HTML
                    <p>Area lantai 3 kini telah disulap menjadi <em>Co-Working Space</em> modern yang nyaman untuk diskusi kelompok.</p>
                    <h2>Fasilitas Baru:</h2>
                    <ul>
                        <li>Kursi ergonomis standar industri.</li>
                        <li>Stopkontak di setiap meja.</li>
                        <li>Sound-absorbing panels untuk mengurangi kebisingan.</li>
                        <li>Pojok kopi mandiri (self-service coffee).</li>
                    </ul>
                    <p>Harap menjaga kebersihan dan ketertiban selama menggunakan fasilitas baru ini.</p>
HTML
            ],
            [
                'judul' => 'Kunjungan Delegasi Perpustakaan Nasional',
                'img' => $images['study'],
                'konten' => <<<HTML
                    <p>Perpustakaan POLBAN menerima kunjungan kehormatan dari tim akreditasi Perpustakaan Nasional Republik Indonesia.</p>
                    <p>Kunjungan ini bertujuan untuk meninjau standar layanan digital yang telah diterapkan di kampus kita. Hasil penilaian awal menunjukkan skor <strong>A (Unggul)</strong>.</p>
                    <p>Terima kasih atas kerja keras seluruh staf dan partisipasi mahasiswa dalam menjaga fasilitas perpustakaan.</p>
HTML
            ],
            [
                'judul' => 'Kompetisi Resensi Buku 2025',
                'img' => $images['books'],
                'konten' => <<<HTML
                    <h2>Tunjukkan Bakat Menulismu!</h2>
                    <p>Dalam rangka bulan bahasa, kami menantang Anda untuk membuat resensi video (vlog) atau tulisan blog mengenai buku favorit di perpustakaan.</p>
                    <h3>Hadiah:</h3>
                    <ul>
                        <li>Juara 1: Tablet Android + Sertifikat</li>
                        <li>Juara 2: Voucher Gramedia Rp 500.000</li>
                        <li>Juara 3: Paket Merchandise Eksklusif</li>
                    </ul>
                    <p>Kirimkan karyamu sebelum tanggal 30 Desember.</p>
HTML
            ]
        ];

        foreach ($beritaList as $item) {
            Article::create([
                'article_id'    => Str::uuid()->toString(),
                'judul'         => $item['judul'],
                'content'       => $item['konten'],
                'type'          => 'berita',
                'status'        => 'published',
                'url_thumbnail' => $item['img'],
                'created_by'    => $authors[array_rand($authors)], // Random Author
                'created_date'  => now()->subDays(rand(1, 60)),
            ]);
        }

        // --- 2. SEED PENGUMUMAN (7 ITEM) ---

        $pengumumanList = [
            [
                'judul' => 'MAINTENANCE: Pemadaman Server Akhir Pekan',
                'img'   => $images['server'],
                'konten'=> <<<HTML
                    <div style="background-color: #ffeeba; padding: 10px; border: 1px solid #ffdf7e; border-radius: 5px;">
                        <strong>PERHATIAN PENTING!</strong>
                    </div>
                    <p>Dikarenakan adanya upgrade memori server database, maka layanan berikut tidak dapat diakses sementara:</p>
                    <ul>
                        <li>OPAC (Online Public Access Catalog)</li>
                        <li>Repository Tugas Akhir</li>
                        <li>Sistem Bebas Pustaka Online</li>
                    </ul>
                    <p><strong>Waktu Downtime:</strong> Sabtu, 20.00 WIB s.d Minggu, 06.00 WIB.</p>
                    <p>Mohon maaf atas ketidaknyamanan ini.</p>
HTML
            ],
            [
                'judul' => 'Jam Operasional Selama Libur Semester Ganjil',
                'img'   => $images['library'],
                'konten'=> <<<HTML
                    <h2>Penyesuaian Jam Layanan</h2>
                    <p>Selama periode libur semester (20 Des - 5 Jan), jam operasional perpustakaan adalah sebagai berikut:</p>
                    <table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
                        <tr>
                            <th>Hari</th>
                            <th>Jam Buka</th>
                        </tr>
                        <tr>
                            <td>Senin - Kamis</td>
                            <td>08.00 - 14.00 WIB</td>
                        </tr>
                        <tr>
                            <td>Jumat</td>
                            <td>08.00 - 11.00 WIB</td>
                        </tr>
                    </table>
                    <p>Layanan Sabtu dan Minggu <strong>TUTUP</strong>.</p>
HTML
            ],
            [
                'judul' => 'Wajib Baca: Prosedur Bebas Pustaka Wisuda 2025',
                'img'   => $images['study'],
                'konten'=> <<<HTML
                    <p>Bagi calon wisudawan periode 2025, harap memperhatikan syarat bebas pustaka berikut agar ijazah dapat diproses:</p>
                    <ol>
                        <li>Tidak memiliki pinjaman buku aktif.</li>
                        <li>Sudah mengunggah softcopy TA/Skripsi ke repository.</li>
                        <li>Menyerahkan 1 eksemplar hardcopy (jika dipersyaratkan prodi).</li>
                        <li>Membayar denda keterlambatan (jika ada).</li>
                    </ol>
                    <p>Silakan unduh panduan lengkap pada lampiran di bawah ini.</p>
HTML
            ],
            [
                'judul' => 'Lowongan Part-Time: Student Staff Perpustakaan',
                'img'   => $images['meeting'],
                'konten'=> <<<HTML
                    <h2>Join Our Team!</h2>
                    <p>Perpustakaan membuka kesempatan bagi mahasiswa aktif semester 3-5 untuk bergabung sebagai <em>Student Staff</em>.</p>
                    <h3>Posisi Tersedia:</h3>
                    <ul>
                        <li>Shelving Staff (Penataan Buku)</li>
                        <li>Content Creator Media Sosial</li>
                        <li>Customer Service Assistant</li>
                    </ul>
                    <p>Kirim CV dan jadwal kuliah Anda ke email perpustakaan@polban.ac.id dengan subjek: <strong>[REKRUTMEN] - Nama Anda</strong>.</p>
HTML
            ],
            [
                'judul' => 'Peringatan Terakhir Pengembalian Buku Paket Semester 1',
                'img'   => $images['books'],
                'konten'=> <<<HTML
                    <p>Diberitahukan kepada seluruh mahasiswa Tingkat 1. Batas akhir pengembalian Buku Paket Mata Kuliah Dasar adalah:</p>
                    <h2>Jumat, 30 Januari 2026</h2>
                    <p>Keterlambatan pengembalian akan dikenakan sanksi berupa:</p>
                    <ul>
                        <li>Denda Rp 1.000/buku/hari.</li>
                        <li>Pemblokiran akun peminjaman semester depan.</li>
                    </ul>
                    <p>Harap diperhatikan dan disebarkan ke rekan kelas lainnya.</p>
HTML
            ],
            [
                'judul' => 'Gangguan Koneksi Wi-Fi di Area R. Referensi',
                'img'   => $images['server'],
                'konten'=> <<<HTML
                    <p>Kami menerima laporan mengenai koneksi internet yang tidak stabil di Ruang Referensi Lantai 2.</p>
                    <p>Saat ini tim teknis sedang melakukan penggantian <em>Access Point</em>. Kami menyarankan pengguna untuk menggunakan area baca Lantai 1 atau Lantai 3 untuk koneksi yang lebih stabil.</p>
                    <p>Estimasi perbaikan: 2 x 24 Jam.</p>
HTML
            ],
            [
                'judul' => 'Undangan Terbuka: Rapat Anggota Tahunan Klub Baca',
                'img'   => $images['coffee'],
                'konten'=> <<<HTML
                    <p>Klub Baca POLBAN akan mengadakan pemilihan ketua baru.</p>
                    <p>Kami mengundang seluruh anggota aktif maupun mahasiswa umum yang berminat literasi untuk hadir pada:</p>
                    <ul>
                        <li><strong>Tempat:</strong> Ruang Audio Visual</li>
                        <li><strong>Waktu:</strong> 13.00 WIB s.d Selesai</li>
                    </ul>
                    <p>Disediakan snack dan sertifikat partisipasi.</p>
HTML
            ]
        ];

        foreach ($pengumumanList as $index => $item) {
            $hasAttachment = in_array($index, [2, 3]); // Item ke-3 dan ke-4 punya lampiran

            Article::create([
                'article_id'      => Str::uuid()->toString(),
                'judul'           => $item['judul'],
                'content'         => $item['konten'],
                'type'            => 'pengumuman',
                'status'          => 'published',
                'url_thumbnail'   => $item['img'], // Tetap diisi agar layout frontend tidak rusak
                'url_attachment'  => $hasAttachment ? $placeholderPdf : null,
                'attachment_name' => $hasAttachment ? 'Dokumen_Pendukung.pdf' : null,
                'created_by'      => $authors[array_rand($authors)],
                'created_date'    => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
