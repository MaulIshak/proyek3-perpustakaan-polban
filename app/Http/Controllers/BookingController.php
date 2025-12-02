<?php

namespace App\Http\Controllers;

use App\Models\BookingBuku;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
// Import Library Brevo
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client; // Brevo butuh Guzzle

class BookingController extends Controller
{
    // --- USER SIDE ---
    public function create()
    {
        return Inertia::render('user/BookingBuku', [
            'title' => 'Booking Buku'
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validasi Backend (Security Layer)
        $request->validate([
            'namaLengkap' => 'required|string|max:100|regex:/^[a-zA-Z\s\.\']+$/', // Hanya huruf, spasi, titik, petik
            
            'nimNip' => [
                'required',
                'numeric', // Wajib Angka
                'digits_between:1,10', // Panjang minimal 5, maksimal 20 digit
            ],
            
            'email' => 'required|email:dns', // Cek format email valid & domainnya eksis
            
            'whatsapp' => [
                'required',
                'numeric', // Wajib Angka
                'starts_with:08,62', // Harus berawalan 08 atau 62 (Format Indonesia)
                'digits_between:10,15', // Panjang wajar no HP
            ],
            
            'judulBuku' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
        ], [
            // Custom Pesan Error (Opsional, agar pesan dari backend bahasa Indonesia)
            'namaLengkap.regex' => 'Nama hanya boleh berisi huruf.',
            'nimNip.numeric' => 'NIM/NIP harus berupa angka.',
            'whatsapp.numeric' => 'Nomor WhatsApp harus berupa angka.',
            'whatsapp.starts_with' => 'Nomor WhatsApp harus diawali 08 atau 62.',
        ]);

        // 2. Simpan ke Database
        BookingBuku::create([
            'nama_lengkap' => $request->namaLengkap,
            'nim_nip'      => $request->nimNip,
            'email'        => $request->email,
            'whatsapp'     => $request->whatsapp, // Data masuk sudah pasti bersih/angka saja
            'judul_buku'   => $request->judulBuku,
            'pengarang'    => $request->pengarang,
            'status'       => 'pending'
        ]);

        return redirect()->back()->with('success', 'Permintaan booking berhasil dikirim!');
    }

    // --- ADMIN SIDE ---

    public function indexAdmin()
    {
        $bookings = BookingBuku::latest()->get();
        return Inertia::render('admin/booking/Index', [
            'bookings' => $bookings
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = BookingBuku::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:approved,rejected,cancelled,pending',
            'rejection_reason' => 'nullable|string'
        ]);

        $booking->status = $request->status;
        
        if ($request->status === 'rejected') {
            $booking->rejection_reason = $request->rejection_reason;
        } else {
            $booking->rejection_reason = null;
        }

        $booking->save();

        // --- LOGIKA API BREVO ---
        // Kirim email jika status bukan pending
        if ($booking->status !== 'pending') {
            $this->sendBrevoEmail($booking);
        }
        
        return redirect()->back()->with('success', 'Status diperbarui & Email dikirim via API.');
    }

    public function destroy($id)
    {
        BookingBuku::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data booking berhasil dihapus.');
    }

    // --- FUNGSI PRIVAT KHUSUS KIRIM EMAIL (NO BLADE, NO MAIL CLASS) ---
    private function sendBrevoEmail($booking)
    {
        // 1. Setup Konfigurasi API
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', env('BREVO_API_KEY'));
        $apiInstance = new TransactionalEmailsApi(new Client(), $config);
        $sendSmtpEmail = new SendSmtpEmail();

        // 2. Siapkan Data Variabel
        $deadlineString = '-';
        if ($booking->status === 'approved') {
            Carbon::setLocale('id');
            $deadline = Carbon::now()->addDay();
            if ($deadline->isSaturday()) $deadline->addDays(2);
            elseif ($deadline->isSunday()) $deadline->addDay();
            $deadlineString = $deadline->translatedFormat('l, d F Y H:i');
        }

        // 3. Rakit HTML Content secara Manual (Pengganti Blade)
        // Kita gunakan heredoc syntax (<<<HTML) agar rapi
        $statusColor = match($booking->status) {
            'approved' => '#16a34a', // Hijau
            'rejected' => '#dc2626', // Merah
            'cancelled' => '#6b7280', // Abu
            default => '#000000'
        };

        $statusMessage = '';
        if ($booking->status == 'approved') {
            $statusMessage = "
                <h3 style='color: $statusColor;'>✅ Permintaan Disetujui</h3>
                <p>Buku yang dipesan dapat diambil di layanan sirkulasi perpustakaan pada hari kerja.</p>
                <p><strong>Batas Pengambilan:</strong> $deadlineString</p>
                <small>*Berlaku 1 hari kerja.</small>";
        } elseif ($booking->status == 'rejected') {
            $statusMessage = "
                <h3 style='color: $statusColor;'>❌ Permintaan Ditolak</h3>
                <p>Mohon maaf buku tidak tersedia.</p>
                <p><strong>Alasan:</strong> $booking->rejection_reason</p>";
        } elseif ($booking->status == 'cancelled') {
            $statusMessage = "
                <h3 style='color: $statusColor;'>⚠️ Permintaan Dibatalkan</h3>
                <p>Pesanan dibatalkan karena melewati batas waktu pengambilan.</p>";
        }

        $htmlContent = <<<HTML
        <!DOCTYPE html>
        <html>
        <body style="font-family: sans-serif; color: #333;">
            <div style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #eee; border-radius: 8px;">
                <h2 style="color: #2f855a;">Halo, {$booking->nama_lengkap}</h2>
                <p>Update status peminjaman buku: <strong>{$booking->judul_buku}</strong></p>
                <div style="background: #f9f9f9; padding: 15px; border-left: 4px solid $statusColor; margin: 20px 0;">
                    $statusMessage
                </div>
                <p>Terima kasih,<br>Perpustakaan Polban</p>
            </div>
        </body>
        </html>
        HTML;

        // 4. Set Parameter Email
        $sendSmtpEmail['subject'] = 'Update Status Peminjaman - Perpustakaan Polban';
        $sendSmtpEmail['sender'] = ['name' => 'Perpustakaan Polban', 'email' => env('MAIL_FROM_ADDRESS')]; // Pastikan email ini verified di Brevo
        $sendSmtpEmail['to'] = [['email' => $booking->email, 'name' => $booking->nama_lengkap]];
        $sendSmtpEmail['htmlContent'] = $htmlContent;

        // 5. Tembak API!
        try {
            $apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (\Exception $e) {
            // Log error jika perlu: \Log::error($e->getMessage());
            // Kita biarkan silent fail agar user tidak terganggu error screen jika email gagal
        }
    }
}