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
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'url'           => 'required|url|regex:/^https?:\/\//', // URL Utama
            'type'          => 'required|in:journal,ebook',
            'logo'          => 'nullable|image|max:5120',
            
            // Validasi Link Tambahan (Array) - Boleh kosong (nullable)
            'additional_links'         => 'nullable|array',
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

    public function update(Request $request, EJournal $ejournal)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'url'           => 'required|url|regex:/^https?:\/\//',
            'type'          => 'required|in:journal,ebook',
            'logo'          => 'nullable|image|max:5120',
            
            'additional_links'         => 'nullable|array',
            'additional_links.*.label' => 'required_with:additional_links|string',
            'additional_links.*.url'   => 'required_with:additional_links|url',
        ]);

        $data = $request->only(['name', 'description', 'url', 'additional_links', 'type']);

        if ($request->hasFile('logo')) {
            if ($ejournal->logo_path) \Illuminate\Support\Facades\Storage::disk('public')->delete($ejournal->logo_path);
            $data['logo_path'] = $request->file('logo')->store('journals', 'public');
        }

        $ejournal->update($data);
        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(EJournal $ejournal)
    {
        // 1. Hapus file fisik gambar
        if ($ejournal->logo_path && Storage::disk('public')->exists($ejournal->logo_path)) {
            Storage::disk('public')->delete($ejournal->logo_path);
        }

        // 2. Hapus data di database
        $ejournal->delete();

        return redirect()->back()->with('success', 'Jurnal berhasil dihapus.');
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