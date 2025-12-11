<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertanyaan Baru Tanya Pustakawan</title>
    <style>
        /* Reset CSS */
        body { margin: 0; padding: 0; background-color: #f4f4f7; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; color: #333; }
        table { border-collapse: separate; width: 100%; }
        table td { font-family: sans-serif; font-size: 14px; vertical-align: top; }
        
        /* Layout */
        .body { background-color: #f4f4f7; width: 100%; }
        .container { display: block; margin: 0 auto !important; max-width: 600px; padding: 10px; width: 600px; }
        .content { box-sizing: border-box; display: block; margin: 0 auto; max-width: 600px; padding: 10px; }

        /* Card Style */
        .main { background: #ffffff; border-radius: 12px; width: 100%; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #eaebed; }
        .wrapper { box-sizing: border-box; padding: 30px; }

        /* Header */
        .header { background-color: #99cc33; padding: 20px 30px; text-align: center; }
        .header h2 { color: #ffffff; margin: 0; font-size: 20px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }

        /* Typography */
        h1, h2, h3 { color: #333; margin: 0 0 20px; }
        p { margin: 0 0 15px; color: #555; }
        
        /* Sender Info Box */
        .sender-info { background-color: #f9fafb; border-left: 4px solid #99cc33; padding: 15px; margin-bottom: 25px; border-radius: 4px; }
        .sender-info p { margin-bottom: 5px; color: #333; }
        .sender-info strong { color: #555; min-width: 80px; display: inline-block; }

        /* Question Box */
        .question-box { background-color: #f0fdf4; border: 1px dashed #99cc33; border-radius: 8px; padding: 20px; margin-top: 10px; }
        .question-label { font-size: 12px; font-weight: bold; color: #99cc33; text-transform: uppercase; margin-bottom: 8px; display: block; }
        .question-text { font-size: 15px; color: #333; line-height: 1.6; font-style: italic; }

        /* === TOMBOL BALAS BARU === */
        .btn-reply {
            display: inline-block;
            background-color: #99cc33; /* Warna Hijau */
            color: #ffffff !important;
            text-decoration: none;
            font-weight: bold;
            padding: 12px 25px;
            border-radius: 6px;
            text-transform: uppercase;
            font-size: 13px;
            margin-top: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-reply:hover { background-color: #88b82d; }

        /* Footer */
        .footer { clear: both; margin-top: 20px; text-align: center; width: 100%; }
        .footer td, .footer p, .footer span { color: #999; font-size: 12px; text-align: center; }
        
        @media only screen and (max-width: 620px) {
            .main { border-radius: 0; }
            .container { padding: 0 !important; width: 100% !important; }
            .wrapper { padding: 20px !important; }
            .btn-reply { display: block; width: 100%; box-sizing: border-box; }
        }
    </style>
</head>
<body>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>&nbsp;</td>
            <td class="container">
                <div class="content">
                    <table role="presentation" class="main">
                        <tr>
                            <td class="header">
                                <h2>Tanya Pustakawan</h2>
                            </td>
                        </tr>
                        <tr>
                            <td class="wrapper">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <p>Halo Admin,</p>
                                            <p>Anda menerima pertanyaan baru dari formulir website perpustakaan. Berikut adalah detailnya:</p>
                                            
                                            <div class="sender-info">
                                                <p><strong>Nama</strong> : {{ $nama }}</p>
                                                <p><strong>Email</strong> : <a href="mailto:{{ $email }}" style="color: #99cc33; text-decoration: none;">{{ $email }}</a></p>
                                                <p><strong>Waktu</strong> : {{ date('d M Y, H:i') }}</p>
                                            </div>

                                            <div class="question-box">
                                                <span class="question-label">Isi Pertanyaan:</span>
                                                <div class="question-text">
                                                    {!! $pertanyaan !!}
                                                </div>
                                            </div>

                                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td align="center">
                                                        <a href="mailto:{{ $email }}?subject=Balasan: Pertanyaan Pustakawan&body=Halo {{ $nama }},%0D%0A%0D%0AMenjawab pertanyaan Anda mengenai..." class="btn-reply">
                                                            Balas Pesan Ini
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>

                                            <br>
                                            <p style="font-size: 12px; color: #888; text-align: center; margin-top: 10px;">
                                                *Klik tombol di atas untuk membalas langsung via email Anda.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    
                    <div class="footer">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="content-block">
                                    <span class="apple-link">Sistem Perpustakaan Digital</span>
                                    <br> Jangan balas email notifikasi otomatis ini.
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>
</html>