<?php

namespace App\Http\Controllers;

use App\Models\PdfFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RencanaStrategi extends Controller{
    public function viewPDF(){
        $pdf = PdfFile::first();
        $data = [
            'title' => 'Rencana Strategi',
            'pdf_url' => $pdf ? Storage::url($pdf->path) : null
        ];

        return Inertia::render('user/Profile/Renstra', $data);
    }

    public function index(){
        $pdf = PdfFile::first();
        return Inertia::render('admin/renstra/Index', [
            'pdf' => $pdf
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        if (PdfFile::count() > 0) {
            return redirect()->back()->with('error', 'A PDF file already exists. Please delete the existing file before uploading a new one.');
        }

        $path = $request->file('file')->store('renstra', 'public');

        PdfFile::create([
            'name' => $request->file('file')->getClientOriginalName(),
            'path' => $path,
        ]);

        return redirect()->route('admin.renstra.index')->with('success', 'File uploaded successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $pdf = PdfFile::findOrFail($id);

        Storage::disk('public')->delete($pdf->path);

        $path = $request->file('file')->store('renstra', 'public');

        $pdf->update([
            'name' => $request->file('file')->getClientOriginalName(),
            'path' => $path,
        ]);

        return redirect()->route('admin.renstra.index')->with('success', 'File updated successfully.');
    }

    public function destroy($id)
    {
        $pdf = PdfFile::findOrFail($id);

        Storage::delete($pdf->path);

        $pdf->delete();

        return redirect()->route('admin.renstra.index')->with('success', 'File deleted successfully.');
    }
}
