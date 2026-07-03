<?php

require_once '../init.php';

use \Abdus\PMB\KNN\Schema;
use \Abdus\PMB\KNN\DataSet;
use \Abdus\PMB\KNN\Data;

// Kita gunakan pengecekan POST method yang lebih aman dan terbukti jalan
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$k = intval($_POST["tetangga_terdekat"]);

	$dataUntukDihitung = [
		'nama' => $_POST['nama'],
		'jalur_pendaftaran' => normalizeText($_POST['jalur_pendaftaran']),
		'gelombang' => normalizeText($_POST['gelombang']),
		'sistem_kuliah' => normalizeText($_POST['sistem_kuliah']),
		'l_p' => normalizeText($_POST['l_p']),
		'usia' => floatval($_POST['usia']),
		'nilai_lulusan' => floatval($_POST['nilai_lulusan']),
		'tahun_lulus' => floatval($_POST['tahun_lulus']),
		'jenjang_pendidikan' => normalizeText($_POST['jenjang_pendidikan']),
		'jenis_institusi' => normalizeText($_POST['jenis_institusi']),
		'jurusan_sekolah' => normalizeText($_POST['jurusan_sekolah']),
		'propinsi_institusi' => normalizeText($_POST['propinsi_institusi']),
		'prodi_yg_diterima' => normalizeText($_POST['prodi_yg_diterima'])
	];

	$semuaData = ambilSemuaDataset();

	$schema = new Schema();

	$schema
		->tambahParameter('jalur_pendaftaran')
		->tambahParameter('gelombang')
		->tambahParameter('sistem_kuliah')
		->tambahParameter('l_p') // <-- Diperbaiki menjadi huruf kecil l_p
		->tambahParameter('usia')
		->tambahParameter('nilai_lulusan')
		->tambahParameter('tahun_lulus')
		->tambahParameter('jenjang_pendidikan')
		->tambahParameter('jenis_institusi')
		->tambahParameter('jurusan_sekolah')
		->tambahParameter('propinsi_institusi')
		->tambahParameter('prodi_yg_diterima')
		->setParameterKlasifikasi('klasifikasi');

	$dataset = new DataSet($schema, $k);

	foreach ($semuaData as $data) {
		$dataset->tambah(new Data([
			'nama' => $data['nama'],
			'jalur_pendaftaran' => $data['jalur_pendaftaran'],
			'gelombang' => $data['gelombang'],
			'sistem_kuliah' => $data['sistem_kuliah'],
			'l_p' => $data['l_p'], // <-- Diperbaiki ambil dari database (huruf kecil)
			'usia' => floatval($data['usia']),
			'nilai_lulusan' => floatval($data['nilai_lulusan']),
			'tahun_lulus' => floatval($data['tahun_lulus']),
			'jenjang_pendidikan' => $data['jenjang_pendidikan'],
			'jenis_institusi' => $data['jenis_institusi'],
			'jurusan_sekolah' => $data['jurusan_sekolah'],
			'propinsi_institusi' => $data['propinsi_institusi'],
			'prodi_yg_diterima' => $data['prodi_yg_diterima'],
			'klasifikasi' => $data['klasifikasi']
		]));
	}

	$hasil = $dataset->hitung(
		new Data([
			'nama' => $dataUntukDihitung['nama'],
			'jalur_pendaftaran' => $dataUntukDihitung['jalur_pendaftaran'],
			'gelombang' => $dataUntukDihitung['gelombang'],
			'sistem_kuliah' => $dataUntukDihitung['sistem_kuliah'],
			'l_p' => $dataUntukDihitung['l_p'], // <-- Diperbaiki
			'usia' => $dataUntukDihitung['usia'],
			'nilai_lulusan' => $dataUntukDihitung['nilai_lulusan'],
			'tahun_lulus' => $dataUntukDihitung['tahun_lulus'],
			'jenjang_pendidikan' => $dataUntukDihitung['jenjang_pendidikan'],
			'jenis_institusi' => $dataUntukDihitung['jenis_institusi'],
			'jurusan_sekolah' => $dataUntukDihitung['jurusan_sekolah'],
			'propinsi_institusi' => $dataUntukDihitung['propinsi_institusi'],
			'prodi_yg_diterima' => $dataUntukDihitung['prodi_yg_diterima']
		])
	);

	// --- PERBAIKAN ERROR ARRAY KE STRING ---
	$hasilHitungRaw = $hasil["hasil_hitung"];

	// Kita pastikan hasilnya adalah string/teks agar tidak error saat disimpan ke database
	if (is_array($hasilHitungRaw) && isset($hasilHitungRaw['klasifikasi'])) {
		$hasilHitung = (string) $hasilHitungRaw['klasifikasi'];
	} elseif (is_array($hasilHitungRaw)) {
		// Ambil key dan value pertama dari array balikan library KNN
		$keyPertama = array_key_first($hasilHitungRaw);
		$valuePertama = $hasilHitungRaw[$keyPertama];

		// Terkadang library KNN mengembalikan array ['LULUS' => 3 (jumlah voting)]
		if (is_string($keyPertama) && !is_numeric($keyPertama)) {
			$hasilHitung = $keyPertama;
		} else {
			// Jika formatnya hanya list biasa [0 => 'LULUS']
			$hasilHitung = is_array($valuePertama) ? json_encode($valuePertama) : (string) $valuePertama;
		}
	} else {
		// Jika sudah berbentuk string dari awal
		$hasilHitung = (string) $hasilHitungRaw;
	}
	// ---------------------------------------

	$tetanggaTerdekat = $hasil["tetangga_terdekat"];
	$dataHasilHitungYangTerurut = $hasil["data_hasil_hitung_yang_terurut"];

	// 1. Simpan ke Session untuk ditampilkan di halaman hasil_hitung.php
	simpanHasilHitungKedalamSession(
		$dataUntukDihitung,
		$k,
		$dataHasilHitungYangTerurut,
		$hasilHitung
	);

	// 2. Ambil nilai jarak untuk disimpan ke database
	$jarakHasil = 0;
	if (isset($dataHasilHitungYangTerurut[0])) {
		$jarakHasil = floatval($dataHasilHitungYangTerurut[0]->getJarakHasil());
	}

	// 3. Simpan permanen ke database phpMyAdmin
	// Sekarang $hasilHitung dipastikan berupa STRING (teks), bukan array lagi
	if (isset($_POST['recalc_id']) && !empty($_POST['recalc_id'])) {
		updateDataHasilHitungBerdasarkanId(
			intval($_POST['recalc_id']),
			$dataUntukDihitung,
			$hasilHitung,
			$jarakHasil,
			$k
		);
	} else {
		simpanDataHasilHitung(
			$dataUntukDihitung,
			$hasilHitung,
			$jarakHasil,
			$k
		);
	}

	// 4. Arahkan ke halaman hasil
	echo "<script>
        const getUrl = window.location;
        const baseUrl = getUrl.protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
        window.location.href = baseUrl + '/hasil_hitung.php';
    </script>";

	return;
} else {

	echo "<script>
        alert('Akses langsung tidak diizinkan!');
        const getUrl = window.location;
        const baseUrl = getUrl.protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
        window.location.href = baseUrl + '/index.php';
    </script>";

	return;
}
