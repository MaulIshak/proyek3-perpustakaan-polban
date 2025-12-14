<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EJournal;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class EJournalController extends Controller
{
    /**
     * Menampilkan daftar jurnal untuk Admin
     */
    public function index(Request $request)
    {
        $query = EJournal::query();

        // 1. Filter Search (Pencarian)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // 2. Filter Type (Journal/Ebook) - INI YANG HILANG SEBELUMNYA
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        return Inertia::render('admin/EJournal/Index', [
            // Gunakan withQueryString agar filter tidak hilang saat klik halaman 2
            'journals' => $query->latest()->paginate(3)->withQueryString(),
            'filters'  => $request->only(['search', 'type']), // Kirim balik state filter ke Vue
        ]);
    }

    /**
     * Menyimpan data baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                   => 'required|string|max:255',
            'description'            => 'required|string',
            'url'                    => 'required|url', // regex https opsional, 'url' bawaan laravel sudah cukup aman
            'type'                   => 'required|in:journal,ebook',
            'logo'                   => 'nullable|image|max:5120', // Max 5MB
            
            // Validasi Link Tambahan
            'additional_links'       => 'nullable|array',
            'additional_links.*.label' => 'required_with:additional_links|string',
            'additional_links.*.url'   => 'required_with:additional_links|url',
        ]);

        $data = $request->only(['name', 'description', 'url', 'additional_links', 'type']);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('journals', 'public');
        }

        EJournal::create($data);
        
        return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Mengupdate data
     */
    public function update(Request $request, EJournal $ejournal)
    {
        $request->validate([
            'name'                   => 'required|string|max:255',
            'description'            => 'required|string',
            'url'                    => 'required|url',
            'type'                   => 'required|in:journal,ebook',
            'logo'                   => 'nullable|image|max:5120',
            
            'additional_links'       => 'nullable|array',
            'additional_links.*.label' => 'required_with:additional_links|string',
            'additional_links.*.url'   => 'required_with:additional_links|url',
        ]);

        $data = $request->only(['name', 'description', 'url', 'additional_links', 'type']);

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($ejournal->logo_path && Storage::disk('public')->exists($ejournal->logo_path)) {
                Storage::disk('public')->delete($ejournal->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('journals', 'public');
        }

        $ejournal->update($data);

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Menghapus data
     */
    public function destroy(EJournal $ejournal)
    {
        // Hapus file fisik gambar
        if ($ejournal->logo_path && Storage::disk('public')->exists($ejournal->logo_path)) {
            Storage::disk('public')->delete($ejournal->logo_path);
        }

        // Hapus data di database
        $ejournal->delete();

        return redirect()->back()->with('success', 'Jurnal berhasil dihapus.');
    }

    /**
     * Menampilkan halaman User (Frontend)
     * FIX: Menggunakan Paginate agar sinkron dengan Vue Component
     */
    public function ShowUser(Request $request)
    {
        $query = EJournal::query();

        // 1. Filter Pencarian (Nama atau Deskripsi)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // 2. Filter Tipe (Journal atau Ebook)
        // Default ke 'journal' jika tidak ada tipe yang dipilih
        if ($request->has('type')) {
            $query->where('type', $request->type);
        } else {
            $query->where('type', 'journal');
        }

        // 3. Paginate & Query String
        // paginate(12) agar layout grid (3 atau 4 kolom) terlihat rapi
        $journals = $query->latest()
                          ->paginate(3)
                          ->withQueryString(); 

        return Inertia::render('user/Koleksi/EJournal', [
            'journals' => $journals, // Data ini sekarang memiliki struktur { data: [], links: [], ... }
            'filters'  => $request->only(['search', 'type']), // Kirim state filter balik ke Vue
        ]);
    }
}