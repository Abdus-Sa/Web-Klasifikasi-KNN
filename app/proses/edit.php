<?php

require_once __DIR__ . '/../init.php';

// 1. Pastikan request dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. KITA BYPASS FUNGSI dataFormLengkap() KARENA DATA SUDAH DIPASTIKAN ADA
    // Langsung jalankan fungsi eksekusi ke database
    $hasil = editDataBerdasarkanId($_POST);

    if ($hasil) {
        echo "<script>
            alert('Berhasil mengedit data!');
            const getUrl = window.location;
            const baseUrl = getUrl.protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
            window.location.href = baseUrl + '/dataset.php';
        </script>";
    } else {
        // Jika gagal di sini, berarti masalahnya ada di query database SQL-nya
        echo "<script>
            alert('Gagal mengedit data di database! Pastikan kamu benar-benar merubah datanya sebelum memencet Ubah (jika tidak ada yang dirubah, sistem menganggap gagal).');
            const getUrl = window.location;
            const baseUrl = getUrl.protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
            window.location.href = baseUrl + '/dataset.php';
        </script>";
    }
} else {
    // Jika halaman diakses langsung melalui URL browser (GET method)
    echo "<script>
        alert('Maaf, aktivitas ini tidak diizinkan! Anda harus menekan tombol simpan dari halaman edit.');
        const getUrl = window.location;
        const baseUrl = getUrl.protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
        window.location.href = baseUrl + '/dataset.php';
    </script>";
}

return;
