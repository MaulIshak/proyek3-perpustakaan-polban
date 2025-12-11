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
        // 1. Validasi Input
        $rules = [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'], 
            'url'         => ['required', 'url', 'regex:/^https?:\/\//'], // Wajib http:// atau https://
            // [UPDATE] Validasi GDrive (Nullable / Opsional)
            'gdrive_url'  => ['nullable', 'url', 'regex:/^https?:\/\//'], 
            'type'        => ['required', 'in:journal,ebook'],
            'logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], 
        ];

        $messages = [
            'required'    => ':attribute wajib diisi.',
            'url'         => 'Format URL tidak valid.',
            'url.regex'   => 'URL harus diawali dengan http:// atau https://',
            'in'          => 'Pilihan tipe tidak valid.',
            'image'       => 'File harus berupa gambar.',
            'mimes'       => 'Format logo harus JPG, PNG, atau WEBP.',
            'max'         => 'Ukuran file maksimal 5MB.',
        ];

        $attributes = [
            'name'        => 'Nama Jurnal/E-Book',
            'description' => 'Deskripsi',
            'url'         => 'Link URL',
            'gdrive_url'  => 'Link Google Drive', // [UPDATE] Label Error
            'type'        => 'Tipe Koleksi',
            'logo'        => 'Logo/Cover',
        ];

        $request->validate($rules, $messages, $attributes);

        // 2. Siapkan Data
        // [UPDATE] Tambahkan 'gdrive_url' agar ikut tersimpan
        $data = $request->only(['name', 'description', 'url', 'gdrive_url', 'type']);

        // 3. Upload Logo (Jika ada)
        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('journals', 'public');
        }

        EJournal::create($data);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, EJournal $ejournal)
    {
        // 1. Validasi Update
        $rules = [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'url'         => ['required', 'url', 'regex:/^https?:\/\//'],
            // [UPDATE] Validasi GDrive
            'gdrive_url'  => ['nullable', 'url', 'regex:/^https?:\/\//'],
            'type'        => ['required', 'in:journal,ebook'],
            'logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];

        $messages = [
            'required'    => ':attribute wajib diisi.',
            'url.regex'   => 'URL harus diawali dengan http:// atau https://',
            'mimes'       => 'Format logo harus JPG, PNG, atau WEBP.',
            'max'         => 'Ukuran file maksimal 5MB.',
        ];

        $attributes = [
            'name'        => 'Nama Jurnal/E-Book',
            'description' => 'Deskripsi',
            'url'         => 'Link URL',
            'gdrive_url'  => 'Link Google Drive', // [UPDATE] Label Error
            'type'        => 'Tipe Koleksi',
            'logo'        => 'Logo/Cover',
        ];

        $request->validate($rules, $messages, $attributes);

        // [UPDATE] Tambahkan 'gdrive_url'
        $data = $request->only(['name', 'description', 'url', 'gdrive_url', 'type']);

        // 2. Cek Upload Logo Baru
        if ($request->hasFile('logo')) {
            // Hapus file lama jika ada
            if ($ejournal->logo_path && Storage::disk('public')->exists($ejournal->logo_path)) {
                Storage::disk('public')->delete($ejournal->logo_path);
            }
            // Simpan file baru
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