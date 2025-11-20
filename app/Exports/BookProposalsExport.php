<?php

namespace App\Exports;

use App\Models\BookProposal; // Sesuaikan dengan nama Model Anda
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookProposalsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $search;
    protected $status;

    // Constructor untuk menerima filter dari Controller
    public function __construct($search = null, $status = null)
    {
        $this->search = $search;
        $this->status = $status;
    }

    public function query()
    {
        // Logic query ini sebaiknya sama dengan logic di Controller utama agar hasil konsisten
        $query = BookProposal::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('nama_pengusul', 'like', '%' . $this->search . '%')
                  ->orWhere('author', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status && $this->status !== 'all') {
            $query->where('status', $this->status);
        }

        return $query->orderBy('created_at', 'desc');
    }

    // Mapping data per baris agar rapi
    public function map($row): array
    {
        return [
            $row->nama_pengusul,
            $row->nim,
            $row->prodi,
            $row->title,
            $row->author,
            $row->publisher,
            $row->isbn,
            $row->year,
            // Format Rupiah manual atau biarkan raw number agar bisa dihitung di Excel
            $row->price,
            ucfirst($row->status),
            $row->created_at->format('d-m-Y H:i'), // Format Tanggal
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Pengusul',
            'NIM/NIP',
            'Prodi',
            'Judul Buku',
            'Pengarang',
            'Penerbit',
            'ISBN',
            'Tahun',
            'Harga Estimasi',
            'Status',
            'Tanggal Usulan',
        ];
    }

    // Styling header agar bold
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
