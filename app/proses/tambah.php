<?php
// 1. Panggil file inisialisasi
require_once '../init.php';

// 2. Cek apakah form benar-benar disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// 3. Langsung gunakan fungsi dari database.php milikmu
	$berhasil = tambahDataset($_POST);

	// 4. Cek apakah berhasil masuk ke database
	if ($berhasil) {
		echo "<script>
                alert('Mantap! Data calon mahasiswa berhasil ditambahkan.');
                window.location.href = '../../dataset.php';
              </script>";
	} else {
		echo "<script>
                alert('Waduh, gagal menambahkan data ke database.');
                window.history.back();
              </script>";
	}
} else {
	// Jika diakses langsung tanpa form
	echo "<script>
            alert('Akses tidak diizinkan!');
            window.location.href = '../../dataset.php';
          </script>";
}
