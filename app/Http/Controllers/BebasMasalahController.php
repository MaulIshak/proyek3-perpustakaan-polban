<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BebasMasalahController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/BebasMasalah/Index', [
            'settings' => DB::table('bebas_masalah_settings')->first(),
            'requirements' => DB::table('bebas_masalah_requirements')->orderBy('sort_order')->get(),
            'guides' => DB::table('bebas_masalah_guides')->orderBy('sort_order')->get(),
        ]);
    }

    // --- UPDATE SETTINGS (Alur, Template, Watermark) ---
    public function updateSettings(Request $request)
    {
        // 1. Definisikan Rules
        $rules = [
            // Validasi File (Nullable: karena user mungkin hanya update teks)
            // 5120 KB = 5MB (Standard best practice untuk dokumen)
            'alur_image'      => ['nullable', 'mimes:jpg,jpeg,png,webp', 'max:5120'], 
            'template_file'   => ['nullable', 'mimes:pdf,doc,docx', 'max:5120'],
            'watermark_file'  => ['nullable', 'mimes:pdf', 'max:5120'],

            // Validasi Teks (Wajib diisi semua sesuai request)
            'alur_description'      => ['required', 'string'],
            
            'template_title'        => ['required', 'string', 'max:255'],
            'template_info'         => ['required', 'string', 'max:255'],
            'template_instruction'  => ['required', 'string'],

            'watermark_title'       => ['required', 'string', 'max:255'],
            'watermark_info'        => ['required', 'string', 'max:255'],
            'watermark_instruction' => ['required', 'string'],
        ];

        // 2. Custom Pesan Error
        $messages = [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'max' => [
                'string' => ':attribute maksimal :max karakter.',
                'file' => 'Ukuran file :attribute maksimal 5MB.',
            ],
            'mimes' => 'Format file :attribute tidak didukung.',
            'alur_image.mimes' => 'Gambar alur harus berformat JPG atau PNG atau webp',
            'template_file.mimes' => 'Template harus berformat PDF, DOC, atau DOCX.',
            'watermark_file.mimes' => 'Watermark harus berformat PDF.',
        ];

        // 3. Nama Atribut (Untuk pesan error)
        $attributes = [
            'alur_image' => 'Gambar Diagram Alur',
            'alur_description' => 'Deskripsi Alur',
            'template_title' => 'Judul Template',
            'template_file' => 'File Template',
            'template_info' => 'Info Template',
            'template_instruction' => 'Instruksi Template',
            'watermark_title' => 'Judul Watermark',
            'watermark_file' => 'File Watermark',
            'watermark_info' => 'Info Watermark',
            'watermark_instruction' => 'Instruksi Watermark',
        ];

        // Jalankan Validasi
        $request->validate($rules, $messages, $attributes);

        // --- Proses Simpan Data ---
        $settings = DB::table('bebas_masalah_settings')->first();
        
        // Ambil semua input teks yang valid (kecuali file)
        $dataToUpdate = $request->only([
            'alur_description', 
            'template_title', 'template_info', 'template_instruction',
            'watermark_title', 'watermark_info', 'watermark_instruction'
        ]);

        // Upload ALUR IMAGE
        if ($request->hasFile('alur_image')) {
            if ($settings && $settings->alur_image_path) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $settings->alur_image_path));
            }
            $dataToUpdate['alur_image_path'] = '/storage/' . $request->file('alur_image')->store('bebas-masalah', 'public');
        }

        // Upload TEMPLATE FILE
        if ($request->hasFile('template_file')) {
            if ($settings && $settings->template_file_path) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $settings->template_file_path));
            }
            $dataToUpdate['template_file_path'] = '/storage/' . $request->file('template_file')->store('bebas-masalah', 'public');
        }

        // Upload WATERMARK FILE
        if ($request->hasFile('watermark_file')) {
            if ($settings && $settings->watermark_file_path) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $settings->watermark_file_path));
            }
            $dataToUpdate['watermark_file_path'] = '/storage/' . $request->file('watermark_file')->store('watermark', 'public');
        }

        // Update Database
        DB::table('bebas_masalah_settings')
            ->where('id', 1)
            ->update($dataToUpdate);

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    // --- PRIVATE FUNCTION UNTUK VALIDASI LIST (Requirements & Guides) ---
    // Saya buat fungsi private agar tidak perlu menulis ulang rules di Store dan Update
    private function validateList(Request $request)
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'], // Text Area biasanya panjang, jadi string saja cukup (Text type di DB)
            'sort_order' => ['nullable', 'integer'],
        ], [
            'title.required' => 'Judul poin wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'description.required' => 'Deskripsi poin wajib diisi.',
            'sort_order.integer' => 'Nomor urut harus berupa angka.',
        ]);
    }

    // --- CRUD REQUIREMENTS (Persyaratan) ---
    public function storeRequirement(Request $request)
    {
        $this->validateList($request); // Panggil validasi

        DB::table('bebas_masalah_requirements')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
        ]);
        return redirect()->back()->with('success', 'Persyaratan baru berhasil ditambahkan.');
    }

    public function updateRequirement(Request $request, $id)
    {
        $this->validateList($request); // Panggil validasi

        DB::table('bebas_masalah_requirements')->where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
        ]);
        return redirect()->back()->with('success', 'Persyaratan berhasil diperbarui.');
    }

    public function destroyRequirement($id)
    {
        DB::table('bebas_masalah_requirements')->delete($id);
        return redirect()->back()->with('success', 'Persyaratan berhasil dihapus.');
    }

    // --- CRUD GUIDES (Panduan) ---
    public function storeGuide(Request $request)
    {
        $this->validateList($request); // Panggil validasi

        DB::table('bebas_masalah_guides')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
        ]);
        return redirect()->back()->with('success', 'Panduan baru berhasil ditambahkan.');
    }

    public function updateGuide(Request $request, $id)
    {
        $this->validateList($request); // Panggil validasi

        DB::table('bebas_masalah_guides')->where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
        ]);
        return redirect()->back()->with('success', 'Panduan berhasil diperbarui.');
    }

    public function destroyGuide($id)
    {
        DB::table('bebas_masalah_guides')->delete($id);
        return redirect()->back()->with('success', 'Panduan berhasil dihapus.');
    }

    public function ViewUser()
    {
        return Inertia::render('BebasMasalah/Bebas_Masalah', [
            'settings' => DB::table('bebas_masalah_settings')->first(),
            'requirements' => DB::table('bebas_masalah_requirements')->orderBy('sort_order')->get(),
            'guides' => DB::table('bebas_masalah_guides')->orderBy('sort_order')->get(),
        ]);
    }
}