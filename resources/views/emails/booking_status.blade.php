<!DOCTYPE html>
<html>
<head>
    <title>Status Booking Buku</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
        <h2 style="color: #2f855a;">Halo, {{ $data['name'] }}</h2>

        <p>Berikut adalah pembaruan status untuk peminjaman buku:</p>
        <p style="background: #f7fafc; padding: 10px; border-radius: 5px;">
            <strong>Judul Buku:</strong> {{ $data['book_title'] }}
        </p>

        {{-- KONDISI STATUS --}}

        @if($data['status'] == 'approved')
            <div style="background-color: #f0fdf4; padding: 15px; border-left: 4px solid #16a34a; margin: 20px 0;">
                <h3 style="color: #166534; margin-top: 0;">✅ Permintaan Disetujui</h3>
                <p>Buku yang dipesan dapat diambil di layanan sirkulasi perpustakaan pada hari kerja dan jam kerja.</p>
                <p><strong>Batas Pengambilan:</strong> {{ $data['deadline'] }}</p>
                <p style="font-size: 0.9em; color: #666;">*Pengambilan buku hanya berlaku selama 1 (satu) hari kerja.</p>
            </div>

        @elseif($data['status'] == 'rejected')
            <div style="background-color: #fef2f2; padding: 15px; border-left: 4px solid #dc2626; margin: 20px 0;">
                <h3 style="color: #991b1b; margin-top: 0;">❌ Permintaan Ditolak</h3>
                <p>Mohon maaf buku yang dipesan tidak tersedia di perpustakaan.</p>
                <p><strong>Alasan:</strong> {{ $data['reason'] }}</p>
            </div>

        @elseif($data['status'] == 'cancelled')
            <div style="background-color: #f3f4f6; padding: 15px; border-left: 4px solid #6b7280; margin: 20px 0;">
                <h3 style="color: #374151; margin-top: 0;">⚠️ Permintaan Dibatalkan</h3>
                <p>Pesanan buku dibatalkan karena telah melewati masa pengambilan buku.</p>
            </div>
        @endif

        <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
        <p style="font-size: 0.8em; color: #888;">Perpustakaan Politeknik Negeri Bandung</p>
    </div>

</body>
</html>