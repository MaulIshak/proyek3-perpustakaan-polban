<?php

namespace App\Http\Controllers;

use App\Models\BookCover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CoverBuku extends Controller
{
    public function index()
    {
        // Ambil data terbaru
        $covers = BookCover::latest()->get();

        return Inertia::render('admin/Cover/Index', [
            'covers' => $covers
        ]);
    }
    public function show()
    {
        // Ambil data terbaru
        $covers = BookCover::latest()->limit(6)->get();

        return Inertia::render('user/Home', [
            'covers' => $covers
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            // Validasi URL (nullable = boleh kosong)
            'link_buku' => 'nullable|url|max:255', 
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'link_buku.url' => 'Format link tidak valid (harus diawali http:// atau https://)'
        ]);

        $path = $request->file('image')->store('covers', 'public');

        BookCover::create([
            'title'      => $request->title,
            'link_buku'  => $request->link_buku, // Simpan Link
            'image_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Cover berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $cover = BookCover::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'link_buku' => 'nullable|url|max:255', // Validasi Update
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'title'     => $request->title,
            'link_buku' => $request->link_buku // Update Link
        ];

        if ($request->hasFile('image')) {
            if ($cover->image_path && Storage::disk('public')->exists($cover->image_path)) {
                Storage::disk('public')->delete($cover->image_path);
            }
            $data['image_path'] = $request->file('image')->store('covers', 'public');
        }

        $cover->update($data);

        return redirect()->back()->with('success', 'Cover berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $cover = BookCover::findOrFail($id);

        // Hapus file fisik
        if ($cover->image_path && Storage::disk('public')->exists($cover->image_path)) {
            Storage::disk('public')->delete($cover->image_path);
        }

        $cover->delete();

        return redirect()->back()->with('success', 'Cover berhasil dihapus.');
    }
}
