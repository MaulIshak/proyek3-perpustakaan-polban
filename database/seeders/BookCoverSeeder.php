<?php

namespace Database\Seeders;

use App\Models\BookCover;
use Illuminate\Database\Seeder;

class BookCoverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar buku dengan cover Unsplash yang spesifik (Vertical/Portrait preferred)
        $books = [
            [
                'title' => 'The Psychology of Design',
                // Gambar abstrak minimalis
                'url' => 'https://elib.polban.ac.id/lib/minigalnano/createthumb.php?filename=images/docs/cover_fisika-untuk-teknik-kimia-dan-rekayasa-proses-20251124135813.png&width=200',
            ],
            [
                'title' => 'Modern Architecture: A Visual Guide',
                // Gambar gedung vertikal
                'url' => 'https://elib.polban.ac.id/lib/minigalnano/createthumb.php?filename=images/docs/cover_validasi-dan-penjaminan-mutu-metode-analisis-kimia-20240315122208.jpg&width=200',
            ],
            [
                'title' => 'Culinary Journey: Asia',
                // Gambar makanan estetik
                'url' => 'https://elib.polban.ac.id/lib/minigalnano/createthumb.php?filename=images/docs/cover_fotoluminesensi-organik-sintesis-desain-dan-aplikasinya-20251124084030.jpg&width=200',
            ],
            [
                'title' => 'Into the Wild: Nature Photography',
                // Hutan/Alam
                'url' => 'https://elib.polban.ac.id/lib/minigalnano/createthumb.php?filename=images/docs/Buku_Ajar_Kimia_Unsur_SUYANTA.jpg.jpg&width=200',
            ],
            [
                'title' => 'Mastering Artificial Intelligence',
                // Teknologi/Robot
                'url' => 'https://elib.polban.ac.id/lib/minigalnano/createthumb.php?filename=images/docs/cover_termodinamika-untuk-teknik-mesin-20251120134033.png&width=200',
            ],
            [
                'title' => 'Urban Life and Solitude',
                // Fotografi jalanan
                'url' => 'https://elib.polban.ac.id/lib/minigalnano/createthumb.php?filename=images/docs/cover_biorefinery-konversi-biomassa-menjadi-bioenergi-biomaterial-dan-biok-20240301100825.jpg&width=200',
            ],
            [
                'title' => 'Minimalism in Code',
                // Setup komputer bersih
                'url' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600&q=80',
            ],
            [
                'title' => 'The Coffee Table Book',
                // Kopi dan buku
                'url' => 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=600&q=80',
            ],
        ];

        foreach ($books as $book) {
            BookCover::create([
                'title'      => $book['title'],
                'image_path' => $book['url'],
            ]);
        }
    }
}
