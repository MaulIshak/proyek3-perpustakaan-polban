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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // Simpan gambar
        $path = $request->file('image')->store('covers', 'public');

        BookCover::create([
            'title' => $request->title,
            'image_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Cover berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $cover = BookCover::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = ['title' => $request->title];

        // Cek jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($cover->image_path && Storage::disk('public')->exists($cover->image_path)) {
                Storage::disk('public')->delete($cover->image_path);
            }
            // Upload gambar baru
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