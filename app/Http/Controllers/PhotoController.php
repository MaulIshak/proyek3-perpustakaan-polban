<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PhotoController extends Controller
{
    public function index(Request $request){
        // paginate, cari berdasarkan tipe atau q (opsional)
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
        $request->validate([
            'foto' => 'required|image|max:5240', // max 5MB
            'tipe' => 'required|in:galeri,cover_buku',
        ]);

        $uuid = (string) Str::uuid();
        $fileData = $this->handleFileUpload($request->file('foto'), $uuid);

        Photo::create([
            'foto_id' => $uuid,
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
            'foto' => 'nullable|image|max:5120',
            'tipe' => 'required|in:galeri,cover_buku',
        ]);

        if ($request->hasFile('foto')) {
            // hapus file lama
            if ($photo->url_foto) {
                Storage::delete('public/photos/' . basename($photo->url_foto));
            }

            $fileData = $this->handleFileUpload($request->file('foto'), $photo->foto_id);
            $photo->url_foto = $fileData['url'];
            $photo->size = $fileData['size'];
        }

        $photo->tipe = $request->tipe;
        $photo->save();

        return redirect()->back()->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy($id){
        $photo = Photo::findOrFail($id);
        if ($photo->url_foto) {
            Storage::delete('public/photos/' . basename($photo->url_foto));
        }
        $photo->delete(); // soft delete -> deleted_date

        return redirect()->back()->with('success', 'Foto dihapus.');
    }

    private function handleFileUpload(UploadedFile $file, $name)
    {
        $path = $file->storeAs('photos', $name . '.' . $file->getClientOriginalExtension(), 'public');
        $url = Storage::url($path);
        $sizeKb = (int) round($file->getSize() / 1024);

        return [
            'url' => $url,
            'size' => $sizeKb,
        ];
    }
}
