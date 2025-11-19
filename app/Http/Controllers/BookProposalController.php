<?php

namespace App\Http\Controllers;

use App\Models\BookProposal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookProposalController extends Controller
{
    public function index(Request $request)
    {
        $query = BookProposal::query();

        // Fitur Pencarian (Nama, Judul, Pengarang)
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_pengusul', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
            });
        }

        // Fitur Filter Status
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Hitung Statistik untuk Kartu di atas
        $stats = [
            'total' => BookProposal::count(),
            'pending' => BookProposal::where('status', 'pending')->count(),
            'approved' => BookProposal::where('status', 'approved')->count(),
            'rejected' => BookProposal::where('status', 'rejected')->count(),
        ];

        // Ambil data dengan pagination
        $proposals = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('admin/usulan/Index', [
            'proposals' => $proposals,
            'filters' => $request->only(['search', 'status']),
            'stats' => $stats
        ]);
    }

    public function create()
    {
        return Inertia::render('user/Koleksi/Usulan_Buku'); 
        
    }

    public function store(Request $request)
    {
        // Validasi Input (PENTING)
        $validated = $request->validate([
            'nama_pengusul' => 'required|string|max:255',
            'nim'           => 'required|string|max:20',
            'prodi'         => 'required|string|max:100',
            'title'         => 'required|string|max:255',
            'author'        => 'required|string|max:255',
            'isbn'          => 'required|string|max:50',
            'publisher'     => 'required|string|max:255',
            'year'          => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price'         => 'nullable|numeric|min:0',
            'reason'        => 'nullable|string',
        ]);

        // Tambahkan status default
        $validated['status'] = 'pending';

        // Simpan ke Database
        BookProposal::create($validated);

        // Redirect kembali (Vue akan menangkap ini sebagai onSuccess)
        return redirect()->back()->with('success', 'Usulan buku berhasil dikirim!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $proposal = BookProposal::findOrFail($id);
        $proposal->update(['status' => $request->status]);

        return back()->with('success', 'Status berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $proposal = BookProposal::findOrFail($id);
        
        // Opsional: Pastikan hanya yang statusnya ditolak yang bisa dihapus backend
        if ($proposal->status !== 'rejected') {
            return back()->withErrors(['error' => 'Hanya usulan yang ditolak yang boleh dihapus.']);
        }

        $proposal->delete();

        return back()->with('success', 'Usulan berhasil dihapus.');
    }
    
    // Placeholder untuk export excel
    public function export()
    {
        // Implementasi logic export excel (misal menggunakan Maatwebsite/Excel)
        return back()->with('success', 'Fitur export akan segera tersedia.');
    }
}