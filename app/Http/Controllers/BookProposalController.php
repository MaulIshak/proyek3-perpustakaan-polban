<?php

namespace App\Http\Controllers;

use App\Models\BookProposal;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Exports\BookProposalsExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $proposals = $query->latest()->paginate(5)->withQueryString();

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
        // 1. Definisikan Aturan Validasi
        $rules = [
            'nama_pengusul' => ['required', 'string', 'max:255'],
            
            // NIM: Wajib, Maksimal 20, Hanya Angka (Regex)
            'nim' => ['required', 'string', 'max:20', 'regex:/^[0-9]+$/'], 
            
            'prodi' => ['required', 'string', 'max:100'],
            
            // ISBN: Minimal 10 (asumsi standar ISBN-10/13), Maksimal 50
            'isbn' => ['required', 'string', 'min:10', 'max:50'], 

            'publisher' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'price' => ['nullable', 'numeric', 'min:0'],
            'author' => ['required', 'string', 'max:255'],
            'reason' => ['nullable', 'string'],

            // TITLE + Cek Duplikasi (Spam Prevention)
            'title' => [
                'required', 
                'string', 
                'max:255',
                // Custom Validation Logic untuk Cek Duplikasi
                function ($attribute, $value, $fail) use ($request) {
                    // Cek di database: 
                    // Apakah ada data dengan NIM ini DAN Status 'pending'
                    // DAN (Judulnya sama ATAU ISBN-nya sama)
                    $isDuplicate = BookProposal::where('nim', $request->nim)
                        ->where('status', 'pending')
                        ->where(function($q) use ($value, $request) {
                            $q->where('title', $value) // Judul sama
                              ->orWhere('isbn', $request->isbn); // Atau ISBN sama
                        })
                        ->exists();

                    if ($isDuplicate) {
                        $fail('Anda sudah mengusulkan buku ini (berdasarkan Judul atau ISBN) dan statusnya masih menunggu proses.');
                    }
                },
            ],
        ];

        // 2. Custom Pesan Error (Bahasa Indonesia)
        $messages = [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'integer' => ':attribute harus berupa angka bulat.',
            'numeric' => ':attribute harus berupa angka.',
            'min' => ':attribute minimal berisi :min karakter/angka.',
            'max' => ':attribute maksimal berisi :max karakter/angka.',
            'nim.regex' => 'NIM hanya boleh berisi angka tanpa spasi atau huruf.',
            'year.max' => 'Tahun terbit tidak boleh melebihi tahun depan.',
            'price.min' => 'Harga tidak boleh negatif.',
        ];

        // 3. Custom Nama Atribut (Agar pesan error lebih enak dibaca)
        $attributes = [
            'nama_pengusul' => 'Nama Pengusul',
            'nim' => 'NIM',
            'prodi' => 'Program Studi',
            'title' => 'Judul Buku',
            'author' => 'Nama Pengarang',
            'isbn' => 'ISBN',
            'publisher' => 'Penerbit',
            'year' => 'Tahun Terbit',
            'price' => 'Perkiraan Harga',
            'reason' => 'Alasan Usulan',
        ];

        // Jalankan Validasi
        // Jika gagal, Laravel otomatis redirect back + kirim error ke Vue
        $validated = $request->validate($rules, $messages, $attributes);

        // Tambahkan status default
        $validated['status'] = 'pending';

        // Simpan ke Database
        BookProposal::create($validated);

        // Redirect kembali
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

    public function export(Request $request)
    {
        // Ambil parameter filter dari request URL
        $search = $request->input('search');
        $status = $request->input('status');

        // Generate nama file dengan timestamp
        $fileName = 'usulan-buku-' . date('Y-m-d_H-i') . '.xlsx';

        return Excel::download(new BookProposalsExport($search, $status), $fileName);
    }


}
