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
        // Kita hanya mengambil satu baris data settings
        // Pastikan tabel bebas_masalah_settings sudah ada (dari migration sebelumnya)
        return Inertia::render('admin/BebasMasalah/Index', [
            'settings' => DB::table('bebas_masalah_settings')->first(),
        ]);
    }

    public function updateSettings(Request $request)
    {
        // 1. Validasi
        $request->validate([
            // --- File Uploads (Semua Optional & Max 5MB) ---
            'alur_image'        => ['nullable', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'requirement_file'  => ['nullable', 'mimes:pdf', 'max:5120'],
            'guide_file'        => ['nullable', 'mimes:pdf', 'max:5120'],
            'template_file'     => ['nullable', 'mimes:pdf,doc,docx', 'max:5120'],
            'watermark_file'    => ['nullable', 'mimes:pdf', 'max:5120'],

            // --- Text Fields ---
            'alur_description'        => ['nullable', 'string'],
            'requirement_description' => ['nullable', 'string'],
            'guide_description'       => ['nullable', 'string'],
            
            // --- Template & Watermark Meta ---
            'template_title'       => ['nullable', 'string', 'max:255'],
            'template_info'        => ['nullable', 'string', 'max:255'],
            'template_instruction' => ['nullable', 'string'],
            
            'watermark_title'      => ['nullable', 'string', 'max:255'],
            'watermark_info'       => ['nullable', 'string', 'max:255'],
            'watermark_instruction'=> ['nullable', 'string'],
        ]);

        // 2. Siapkan Data untuk Update (Ambil semua input kecuali file)
        $inputs = $request->except([
            '_method',
            'alur_image',
            'requirement_file',
            'guide_file',
            'template_file',
            'watermark_file'
        ]);

        $dataToUpdate = array_filter($inputs, function ($value) {
            return !is_null($value);
        });
        
        // Cek data lama untuk menghapus file lama jika ada update
        $settings = DB::table('bebas_masalah_settings')->first();
        if (!$settings) {
            $id = DB::table('bebas_masalah_settings')->insertGetId(['created_at' => now()]);
            $settings = DB::table('bebas_masalah_settings')->where('id', $id)->first();
        }
        
        // Jika belum ada row sama sekali di database, buat baru
        if (!$settings) {
            $id = DB::table('bebas_masalah_settings')->insertGetId(['created_at' => now()]);
            $settings = DB::table('bebas_masalah_settings')->where('id', $id)->first();
        }

        // 3. Helper Function untuk Upload File
        $handleUpload = function ($fileInputName, $dbColumnName, $folder) use ($request, $settings, &$dataToUpdate) {
            if ($request->hasFile($fileInputName)) {
                // Hapus file lama jika ada
                if ($settings && $settings->$dbColumnName) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $settings->$dbColumnName));
                }
                // Upload file baru
                $dataToUpdate[$dbColumnName] = '/storage/' . $request->file($fileInputName)->store($folder, 'public');
            }
        };

        // Jalankan upload untuk masing-masing tab
        $handleUpload('alur_image', 'alur_image_path', 'bebas-masalah');
        $handleUpload('requirement_file', 'requirement_file_path', 'requirements');
        $handleUpload('guide_file', 'guide_file_path', 'guides');
        $handleUpload('template_file', 'template_file_path', 'templates');
        $handleUpload('watermark_file', 'watermark_file_path', 'watermark');

        $dataToUpdate['updated_at'] = now();

        // 4. Update Database
        DB::table('bebas_masalah_settings')->where('id', $settings->id)->update($dataToUpdate);

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function ViewUser()
    {
        // Kita hanya butuh data settings saja sekarang
        return Inertia::render('BebasMasalah/Bebas_Masalah', [
            'settings' => DB::table('bebas_masalah_settings')->first(),
        ]);
    }
}