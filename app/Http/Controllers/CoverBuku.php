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
        $covers = BookCover::latest()->get();

        return Inertia::render('admin/Cover/Index', [
            'covers' => $covers
        ]);
    }

    public function show()
    {
        $covers = BookCover::latest()->limit(6)->get();
        return Inertia::render('user/Home', [
            'covers' => $covers
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // [PERUBAHAN] Ubah nullable menjadi required
            'link_buku' => 'required|url|max:255', 
            'image'     => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'link_buku.required' => 'Link buku wajib diisi.',
            'link_buku.url'      => 'Format link tidak valid (harus diawali http:// atau https://)'
        ]);

        $path = $request->file('image')->store('covers', 'public');

        BookCover::create([
            'link_buku'  => $request->link_buku,
            'image_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Cover berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $cover = BookCover::findOrFail($id);

        $request->validate([
            // [PERUBAHAN] Ubah nullable menjadi required
            'link_buku' => 'required|url|max:255',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'link_buku.required' => 'Link buku wajib diisi.',
            'link_buku.url'      => 'Format link tidak valid.'
        ]);

        $data = [
            'link_buku' => $request->link_buku
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

        if ($cover->image_path && Storage::disk('public')->exists($cover->image_path)) {
            Storage::disk('public')->delete($cover->image_path);
        }

        $cover->delete();

        return redirect()->back()->with('success', 'Cover berhasil dihapus.');
    }
}