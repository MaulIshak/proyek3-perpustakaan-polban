<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $query = Photo::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('url_foto', 'like', "%{$q}%");
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $photos = $query->orderBy('created_date', 'desc')->paginate(12)->withQueryString();

        return Inertia::render('admin/AdminGaleri', [
            'photos' => $photos,
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'foto' => [
                'required',
                'image',                    // Pastikan file gambar
                'mimes:jpg,jpeg,png,webp',       // Format HANYA jpg/png (sesuai request)
                'max:5120',                 // Maksimal 5MB (Best Practice)
            ],
            'tipe' => [
                'required', 
                'in:galeri,cover_buku'
            ],
        ], [
            // Custom Error Messages
            'foto.required' => 'File foto wajib diunggah.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format foto harus JPG atau PNG atau webp',
            'foto.max'      => 'Ukuran foto maksimal 5MB.',
            'foto.uploaded' => 'Gagal upload. Ukuran file melebihi batas server (cek php.ini).',
            'tipe.required' => 'Tipe foto wajib dipilih.',
            'tipe.in'       => 'Pilihan tipe tidak valid.',
        ]);

        // 2. Upload File dengan Nama Asli
        $fileData = $this->handleFileUpload($request->file('foto'));

        // 3. Simpan ke Database
        Photo::create([
            'foto_id' => (string) Str::uuid(), // ID Database tetap UUID
            'url_foto' => $fileData['url'],
            'size' => $fileData['size'],
            'tipe' => $request->tipe,
        ]);

        return redirect()->back()->with('success', 'Foto berhasil diunggah.');
    }

    public function update(Request $request, $foto_id)
    {
        $photo = Photo::findOrFail($foto_id);

        $request->validate([
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'tipe' => ['required', 'in:galeri,cover_buku'],
        ], [
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format foto harus JPG atau PNG atau webp',
            'foto.max'      => 'Ukuran foto maksimal 5MB.',
            'foto.uploaded' => 'Gagal upload. Ukuran file melebihi batas server.',
        ]);

        // Cek jika ada upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus file lama fisik dari storage
            $this->deleteFile($photo->url_foto);

            // Upload file baru (Nama Asli)
            $fileData = $this->handleFileUpload($request->file('foto'));
            
            $photo->url_foto = $fileData['url'];
            $photo->size = $fileData['size'];
        }

        $photo->tipe = $request->tipe;
        $photo->save();

        return redirect()->back()->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        
        // Hapus file fisik
        $this->deleteFile($photo->url_foto);
        
        $photo->delete();

        return redirect()->back()->with('success', 'Foto dihapus.');
    }

    // --- Private Helper Functions ---

    /**
     * Handle upload logic keeping original filename
     */
    private function handleFileUpload(UploadedFile $file)
    {
        // Ambil nama asli file (tanpa ekstensi)
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        
        // Bersihkan nama file (Slugify) agar aman untuk URL
        // Contoh: "Screenshot (279).jpg" -> "screenshot-279"
        $safeName = Str::slug($originalName);
        
        // Tambahkan Timestamp agar unik (mencegah overwrite jika nama sama)
        // Contoh hasil: "screenshot-279-17092344.jpg"
        $fileName = $safeName . '-' . time() . '.' . $file->getClientOriginalExtension();

        // Simpan ke folder 'photos' di disk 'public'
        $path = $file->storeAs('photos', $fileName, 'public');

        return [
            'url' => Storage::url($path),             // URL untuk frontend (/storage/photos/...)
            'size' => (int) round($file->getSize() / 1024), // Size dalam KB
        ];
    }

    /**
     * Handle delete logic dealing with storage path
     */
    private function deleteFile($url)
    {
        if ($url) {
            // Ubah URL publik (/storage/...) menjadi path relatif (public/...)
            $path = str_replace('/storage/', 'public/', $url);
            
            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        }
    }

    public function UserView()
    {
        $photos = Photo::where('tipe', 'galeri')->orderBy('created_date', 'desc')->get();
        return Inertia::render('Galeri/Galeri', [
            'photos' => $photos,
        ]);
    }
}
