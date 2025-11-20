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
        // Validasi input
        $request->validate([
            'alur_image' => 'nullable|image|max:2048',
            'template_file' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'watermark_image' => 'nullable|image|max:2048',
        ]);

        $settings = DB::table('bebas_masalah_settings')->first();
        
        // PERBAIKAN DISINI: Tambahkan '_method' ke dalam array except
        $dataToUpdate = $request->except([
            'alur_image', 
            'template_file', 
            'watermark_image', 
            '_token', 
            '_method'
        ]);

        // 1. Handle Alur Image
        if ($request->hasFile('alur_image')) {
            if ($settings && $settings->alur_image_path) Storage::delete($settings->alur_image_path);
            $dataToUpdate['alur_image_path'] = '/storage/' . $request->file('alur_image')->store('bebas-masalah', 'public');
        }

        // 2. Handle Template File
        if ($request->hasFile('template_file')) {
            if ($settings && $settings->template_file_path) Storage::delete($settings->template_file_path);
            $dataToUpdate['template_file_path'] = '/storage/' . $request->file('template_file')->store('bebas-masalah', 'public');
        }

        // 3. Handle Watermark Image
        if ($request->hasFile('watermark_image')) {
            if ($settings && $settings->watermark_image_path) Storage::delete($settings->watermark_image_path);
            $dataToUpdate['watermark_image_path'] = '/storage/' . $request->file('watermark_image')->store('bebas-masalah', 'public');
        }

        // Update Database
        DB::table('bebas_masalah_settings')->updateOrInsert(['id' => 1], $dataToUpdate);

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    // --- CRUD REQUIREMENTS (Persyaratan) ---
    public function storeRequirement(Request $request)
    {
        DB::table('bebas_masalah_requirements')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
        ]);
        return redirect()->back();
    }

    public function updateRequirement(Request $request, $id)
    {
        DB::table('bebas_masalah_requirements')->where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->sort_order,
        ]);
        return redirect()->back();
    }

    public function destroyRequirement($id)
    {
        DB::table('bebas_masalah_requirements')->delete($id);
        return redirect()->back();
    }

    // --- CRUD GUIDES (Panduan) ---
    public function storeGuide(Request $request)
    {
        DB::table('bebas_masalah_guides')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
        ]);
        return redirect()->back();
    }

    public function updateGuide(Request $request, $id)
    {
        DB::table('bebas_masalah_guides')->where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'sort_order' => $request->sort_order,
        ]);
        return redirect()->back();
    }

    public function destroyGuide($id)
    {
        DB::table('bebas_masalah_guides')->delete($id);
        return redirect()->back();
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
