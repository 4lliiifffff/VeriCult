<!DOCTYPE html>
<html>
<head>
    <title>Kode Verifikasi</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-w-xl mx-auto p-4">
        <h2 style="color: #03045E;">Verifikasi Nomor Telepon</h2>
        <p>Anda menerima email ini karena ada permintaan untuk mengubah atau menambahkan nomor telepon pada akun VeriCult Anda.</p>
        
        <div style="background-color: #f8f9fa; padding: 20px; text-align: center; margin: 20px 0; border-radius: 8px;">
            <p style="margin: 0; font-size: 14px; color: #666;">Kode Verifikasi (OTP) Anda:</p>
            <h1 style="margin: 10px 0 0; color: #0077B6; letter-spacing: 5px; font-size: 32px;">{{ $token }}</h1>
        </div>

        <p>Kode ini hanya berlaku selama <strong>5 menit</strong>. Jangan bagikan kode ini kepada siapapun.</p>
        
        <p style="margin-top: 30px; font-size: 12px; color: #999;">
            Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.
        </p>
    </div>
</body>
</html>
