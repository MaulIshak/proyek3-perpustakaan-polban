<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class CollectionController extends Controller
{
    public function index(Request $request)
    {
        $query = Collection::query();

        // Fitur Search
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Gunakan paginate, misalnya 8 item per halaman agar grid rapi
        $collections = $query->latest()->paginate(8)->withQueryString();

        return Inertia::render('admin/ECollection/Index', [
            'collections' => $collections,
            'searchQuery' => $request->search ?? '',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'url' => 'nullable|url',
            'description' => 'required',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = '/storage/' . $request->file('image')->store('collections', 'public');
        }

        Collection::create([
            'title' => $request->title,
            'image_path' => $path,
            'url' => $request->url,
            'description' => $request->description,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $collection = Collection::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'url' => 'nullable|url',
            'description' => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'url' => $request->url,
            'description' => $request->description,
            'is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN),
        ];

        if ($request->hasFile('image')) {
            if ($collection->image_path) {
                $oldPath = str_replace('/storage/', '', $collection->image_path);
                Storage::disk('public')->delete($oldPath);
            }
            $data['image_path'] = '/storage/' . $request->file('image')->store('collections', 'public');
        }

        $collection->update($data);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $collection = Collection::findOrFail($id);
        if ($collection->image_path) {
            $oldPath = str_replace('/storage/', '', $collection->image_path);
            Storage::disk('public')->delete($oldPath);
        }
        $collection->delete();
        
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function ShowUser()
    {
        // Ambil data yang aktif saja
        $collections = Collection::where('is_active', true)
            ->latest()
            ->get();

        return Inertia::render('user/Koleksi/ECollection', [
            'collections' => $collections
        ]);
    }
}