<?php
require_once __DIR__ . '/evaluasi.php';

// Ambil rasio dari parameter URL, default ke 0.8 (80/20)
$rasio = isset($_GET['rasio']) ? floatval($_GET['rasio']) : 0.8;

// Validasi rasio (hanya izinkan antara 0.1 sampai 0.9)
if ($rasio < 0.1 || $rasio > 0.9) {
    $rasio = 0.8;
}

// Memastikan koneksi dan environment termuat
$hasil = jalankanEvaluasi($rasio);

if ($hasil === false) {
    header('Location: ../../visualisasi.php?error=nodata');
    exit;
}

// Redirect kembali ke halaman visualisasi dengan flag sukses
header('Location: ../../visualisasi.php?success=evaluasi');
exit;
