<?php

namespace Database\Seeders;

use App\Models\Photo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Koleksi gambar Unsplash dengan ID spesifik (High Quality)
        // Kategori: Architecture, Nature, Minimalist, Technology
        $galleryImages = [
            'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=800&q=80', // Landscape River
            'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=800&q=80', // Misty Forest
            'https://images.unsplash.com/photo-1449824913929-79ae4352cc6e?w=800&q=80', // City View
            'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=800&q=80', // Mountains Night
            'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80', // Office Interior
            'https://images.unsplash.com/photo-1550684848-fac1c5b4e853?w=800&q=80', // Cyberpunk City
            'https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=800&q=80', // Sea Travel
            'https://images.unsplash.com/photo-1531297461136-8208631433e5?w=800&q=80', // Tech Chip
            'https://images.unsplash.com/photo-1497215728101-856f4ea42174?w=800&q=80', // Office Work
            'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800&q=80', // Hiking Nature
            'https://images.unsplash.com/photo-1493612276216-ee3925520721?w=800&q=80', // Minimal Lamp
            'https://images.unsplash.com/photo-1516259762381-22954d7d3ad2?w=800&q=80', // Code Screen
        ];

        // Jenis tipe file yang mungkin
        $types = ['galeri'];

        foreach ($galleryImages as $url) {
            Photo::create([
                'foto_id'      => Str::uuid()->toString(),
                'url_foto'     => $url,
                'size'         => rand(1500, 8500), // Simulasi size dalam KB (1.5MB - 8.5MB)
                'tipe'         => $types[array_rand($types)],
                'created_date' => now()->subDays(rand(0, 180)), // Random tanggal 6 bulan terakhir
            ]);
        }
    }
}
