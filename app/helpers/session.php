<?php

// PERBAIKAN: Mengubah "array $hasilHitung" menjadi "string $hasilHitung"
function simpanHasilHitungKedalamSession(array $dataUntukDihitung, int $nilaiK, array $dataHasilHitungYangTerurut, string $hasilHitung)
{
	// Mengecek apakah session sudah berjalan sebelum memulainya
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	// PERBAIKAN: Ambil nilai jarak langsung dari data terurut (karena sudah bukan array di $hasilHitung)
	$jarakHasil = 0;
	if (isset($dataHasilHitungYangTerurut[0]->jarak)) {
		$jarakHasil = floatval($dataHasilHitungYangTerurut[0]->jarak);
	} elseif (isset($dataHasilHitungYangTerurut[0]->distance)) {
		$jarakHasil = floatval($dataHasilHitungYangTerurut[0]->distance);
	}

	$_SESSION["ada_hasil_hitung"] = true;
	$_SESSION["nilai_k"] = $nilaiK;
	$_SESSION["hasil_hitung"] = $dataHasilHitungYangTerurut;
	$_SESSION["data_yang_diuji"] = $dataUntukDihitung;
	$_SESSION["klasifikasi_yang_terpilih"] = $hasilHitung; // Sekarang langsung menyimpan string
	$_SESSION["jarak_hasil"] = $jarakHasil; // Menyimpan jarak dari perhitungan di atas

	return true;
}

function bersihkanHasilHitungDariSession()
{
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	// Perbaikan: Menggunakan empty() agar tidak error jika variabel belum ada
	if (empty($_SESSION["ada_hasil_hitung"])) {
		return true;
	}

	$_SESSION["ada_hasil_hitung"] = false;
	$_SESSION["nilai_k"] = null;
	$_SESSION["hasil_hitung"] = [];
	$_SESSION["data_yang_diuji"] = [];
	$_SESSION["klasifikasi_yang_terpilih"] = null;
	$_SESSION["jarak_hasil"] = null;

	return true;
}

function adaHasilHitung()
{
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	if (isset($_SESSION["ada_hasil_hitung"]) && $_SESSION["ada_hasil_hitung"]) {
		return true;
	}

	return false;
}

function ambilSemuaHasilDariSession()
{
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	// Perbaikan: Menggunakan ?? (Null Coalescing) untuk memberikan nilai default 
	// jika variabel session tersebut belum tercipta/masih kosong.
	return [
		"ada_hasil_hitung" => $_SESSION["ada_hasil_hitung"] ?? false,
		"nilai_k" => $_SESSION["nilai_k"] ?? null,
		"hasil_hitung" => $_SESSION["hasil_hitung"] ?? [],
		"data_yang_diuji" => $_SESSION["data_yang_diuji"] ?? [],
		"klasifikasi_yang_terpilih" => $_SESSION["klasifikasi_yang_terpilih"] ?? null,
		"jarak_hasil" => $_SESSION["jarak_hasil"] ?? null,
	];
}
