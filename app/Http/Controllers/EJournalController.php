<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EJournal;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class EJournalController extends Controller
{
    public function index()
    {
        // Ambil data, paginate 10 per halaman
        return Inertia::render('admin/EJournal/Index', [
            'journals' => EJournal::latest()->paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'url' => 'required|url',
            'type' => 'required|in:journal,ebook', // <--- Validasi baru
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'url', 'type']); // <--- Ambil type

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('journals', 'public');
        }

        EJournal::create($data);

        return redirect()->back()->with('message', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, EJournal $ejournal)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'url' => 'required|url',
            'type' => 'required|in:journal,ebook', // <--- Validasi baru
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'url', 'type']); // <--- Ambil type

        // ... logic upload gambar tetap sama ...
        if ($request->hasFile('logo')) {
            if ($ejournal->logo_path) {
                Storage::disk('public')->delete($ejournal->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('journals', 'public');
        }

        $ejournal->update($data);
        
        return redirect()->back()->with('message', 'Data berhasil diperbarui.');
    }

    public function destroy(EJournal $ejournal)
    {
        // Hapus file gambar dari storage sebelum hapus data DB
        if ($ejournal->logo_path) {
            Storage::disk('public')->delete($ejournal->logo_path);
        }

        $ejournal->delete();

        return redirect()->back()->with('message', 'Jurnal berhasil dihapus.');
    }

    public function ShowUser()
    {
        // Mengambil semua data jurnal, diurutkan dari yang terbaru
        $journals = EJournal::latest()->get();

        return Inertia::render('user/Koleksi/EJournal', [
            'journals' => $journals
        ]);
    }
}