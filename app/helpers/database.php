<?php



define('DB_HOST', $_ENV["DB_HOST"]);

define('DB_NAME', $_ENV["DB_NAME"]);

define('DB_USER', $_ENV["DB_USER"]);

define('DB_PASS', $_ENV["DB_PASS"]);



$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);



if ($conn->connect_error) {

	die("Connection failed: " . $conn->connect_error);
}



/*

 * FUNGSI UNTUK IMPORT EXCEL (MEMPERBAIKI ERROR SQL)

 */

function tambahData($data, $namaTabel)

{

	global $conn;



	$data = array_values($data);



	if (count($data) >= 15) {

		$dataPasti = array_slice($data, 1, 14);
	} else if (count($data) == 14) {

		$dataPasti = $data;
	} else {

		die("<b>Gagal Import!</b> Baris data Excel bermasalah karena hanya terbaca " . count($data) . " kolom. Padahal sistem butuh 14 atribut. Pastikan file Excel sesuai format.");
	}



	$escapedData = [];

	foreach ($dataPasti as $val) {

		$escapedData[] = "'" . $conn->real_escape_string(trim($val)) . "'";
	}



	$implodedValues = implode(", ", $escapedData);



	// Kueri SQL dengan backtick pada `l_p`

	$query = "INSERT INTO `" . $namaTabel . "`

              (nama, jalur_pendaftaran, gelombang, sistem_kuliah, `l_p`, usia, nilai_lulusan, tahun_lulus, jenjang_pendidikan, jenis_institusi, jurusan_sekolah, propinsi_institusi, prodi_yg_diterima, klasifikasi)

              VALUES

              ($implodedValues)";



	if ($conn->query($query) === TRUE) {

		return true;
	} else {

		die("<b>Gagal Import Dataset!</b><br>Error SQL: " . $conn->error . "<br><br>Kueri yang macet:<br><code>" . $query . "</code>");
	}
}



/*

 * TABEL DATASET UTAMA

 */

function ambilSemuaDataset()

{

	global $conn;



	$data = [];

	$query = "SELECT * FROM `dataset`";

	$hasil = $conn->query($query);



	if ($hasil->num_rows > 0) {

		while ($barisData = $hasil->fetch_assoc()) {

			$data[] = $barisData;
		}
	}



	return $data;
}



function tambahDataset($dataPost)

{

	global $conn;



	$nama = htmlspecialchars($dataPost["nama"]);

	$jalur = htmlspecialchars($dataPost["jalur_pendaftaran"]);

	$gelombang = htmlspecialchars($dataPost["gelombang"]);

	$sistem = htmlspecialchars($dataPost["sistem_kuliah"]);

	$l_p = htmlspecialchars($dataPost["l_p"]);

	$usia = htmlspecialchars($dataPost["usia"]);

	$nilai = htmlspecialchars($dataPost["nilai_lulusan"]);

	$tahun = htmlspecialchars($dataPost["tahun_lulus"]);

	$jenjang = htmlspecialchars($dataPost["jenjang_pendidikan"]);

	$institusi = htmlspecialchars($dataPost["jenis_institusi"]);

	$jurusan = htmlspecialchars($dataPost["jurusan_sekolah"]);

	$propinsi = htmlspecialchars($dataPost["propinsi_institusi"]);

	$prodi = htmlspecialchars($dataPost["prodi_yg_diterima"]);

	$klasifikasi = htmlspecialchars($dataPost["klasifikasi"]);



	$query = "INSERT INTO `dataset`

              (id, nama, jalur_pendaftaran, gelombang, sistem_kuliah, `l_p`, usia, nilai_lulusan, tahun_lulus, jenjang_pendidikan, jenis_institusi, jurusan_sekolah, propinsi_institusi, prodi_yg_diterima, klasifikasi)

              VALUES

              (null, '$nama', '$jalur', '$gelombang', '$sistem', '$l_p', '$usia', '$nilai', '$tahun', '$jenjang', '$institusi', '$jurusan', '$propinsi', '$prodi', '$klasifikasi')";



	$hasil = $conn->query($query);



	return $hasil ? true : false;
}



function ambildataBerdasarkanId(int $id)

{

	global $conn;



	$query = "SELECT * FROM `dataset` WHERE id=$id";

	$hasil = $conn->query($query);



	if ($hasil->num_rows > 0) {

		return $hasil->fetch_assoc();
	}



	return null;
}



function editDataBerdasarkanId(array $dataBaru)

{

	global $conn;



	$id = htmlspecialchars(($dataBaru["id"]));

	$nama = htmlspecialchars($dataBaru["nama"]);

	$jalur = htmlspecialchars($dataBaru["jalur_pendaftaran"]);

	$gelombang = htmlspecialchars($dataBaru["gelombang"]);

	$sistem = htmlspecialchars($dataBaru["sistem_kuliah"]);

	$l_p = htmlspecialchars($dataBaru["l_p"]);

	$usia = htmlspecialchars($dataBaru["usia"]);

	$nilai = htmlspecialchars($dataBaru["nilai_lulusan"]);

	$tahun = htmlspecialchars($dataBaru["tahun_lulus"]);

	$jenjang = htmlspecialchars($dataBaru["jenjang_pendidikan"]);

	$institusi = htmlspecialchars($dataBaru["jenis_institusi"]);

	$jurusan = htmlspecialchars($dataBaru["jurusan_sekolah"]);

	$propinsi = htmlspecialchars($dataBaru["propinsi_institusi"]);

	$prodi = htmlspecialchars($dataBaru["prodi_yg_diterima"]);

	$klasifikasi = htmlspecialchars($dataBaru["klasifikasi"]);



	$query = "UPDATE `dataset` SET

              `nama`='$nama',

              `jalur_pendaftaran`='$jalur',

              `gelombang`='$gelombang',

              `sistem_kuliah`='$sistem',

              `l_p`='$l_p',

              `usia`='$usia',

              `nilai_lulusan`='$nilai',

              `tahun_lulus`='$tahun',

              `jenjang_pendidikan`='$jenjang',

              `jenis_institusi`='$institusi',

              `jurusan_sekolah`='$jurusan',

              `propinsi_institusi`='$propinsi',

              `prodi_yg_diterima`='$prodi',

              `klasifikasi`='$klasifikasi'

              WHERE id=$id";



	$hasil = $conn->query($query);



	return $hasil ? true : false;
}



function hapusDataBerdasarkanId(int $id, $type)

{

	global $conn;



	$query = "DELETE FROM " . $type . " WHERE id=$id";

	$hasil = $conn->query($query);



	return $hasil ? true : false;
}



/*

 * TABEL HASIL HITUNG (K-NN)

 */

function ambilSemuaDataHasilHitung()

{

	global $conn;



	$data = [];

	$query = "SELECT * FROM `hasil_hitung`";

	$hasil = $conn->query($query);



	if ($hasil->num_rows > 0) {

		while ($barisData = $hasil->fetch_assoc()) {

			$data[] = $barisData;
		}
	}



	return $data;
}



function simpanDataHasilHitung(array $dataYangDiuji, string $klasifikasi, float $jarakHasil, int $nilaiK)

{

	global $conn;



	$nama = $conn->real_escape_string($dataYangDiuji["nama"]);
	$jalur = $conn->real_escape_string($dataYangDiuji["jalur_pendaftaran"]);
	$gelombang = $conn->real_escape_string($dataYangDiuji["gelombang"]);
	$sistem = $conn->real_escape_string($dataYangDiuji["sistem_kuliah"]);
	$l_p = $conn->real_escape_string($dataYangDiuji["l_p"]);
	$usia = $conn->real_escape_string($dataYangDiuji["usia"]);
	$nilai = $conn->real_escape_string($dataYangDiuji["nilai_lulusan"]);
	$tahun = $conn->real_escape_string($dataYangDiuji["tahun_lulus"]);
	$jenjang = $conn->real_escape_string($dataYangDiuji["jenjang_pendidikan"]);
	$institusi = $conn->real_escape_string($dataYangDiuji["jenis_institusi"]);
	$jurusan = $conn->real_escape_string($dataYangDiuji["jurusan_sekolah"]);
	$propinsi = $conn->real_escape_string($dataYangDiuji["propinsi_institusi"]);
	$prodi = $conn->real_escape_string($dataYangDiuji["prodi_yg_diterima"]);

	$klasif = $conn->real_escape_string($klasifikasi);
	$jarak = floatval($jarakHasil);
	$k = intval($nilaiK);

	$query = "INSERT INTO `hasil_hitung`
              (id, nama, jalur_pendaftaran, gelombang, sistem_kuliah, `l_p`, usia, nilai_lulusan, tahun_lulus, jenjang_pendidikan, jenis_institusi, jurusan_sekolah, propinsi_institusi, prodi_yg_diterima, jarak_hasil, klasifikasi, nilai_k)
              VALUES
              (null, '$nama', '$jalur', '$gelombang', '$sistem', '$l_p', '$usia', '$nilai', '$tahun', '$jenjang', '$institusi', '$jurusan', '$propinsi', '$prodi', '$jarak', '$klasif', '$k')";



	$hasil = $conn->query($query);



	return $hasil ? true : false;
}

function updateDataHasilHitungBerdasarkanId(int $id, array $dataYangDiuji, string $klasifikasi, float $jarakHasil, int $nilaiK)
{
	global $conn;

	$nama = $conn->real_escape_string($dataYangDiuji["nama"]);
	$jalur = $conn->real_escape_string($dataYangDiuji["jalur_pendaftaran"]);
	$gelombang = $conn->real_escape_string($dataYangDiuji["gelombang"]);
	$sistem = $conn->real_escape_string($dataYangDiuji["sistem_kuliah"]);
	$l_p = $conn->real_escape_string($dataYangDiuji["l_p"]);
	$usia = $conn->real_escape_string($dataYangDiuji["usia"]);
	$nilai = $conn->real_escape_string($dataYangDiuji["nilai_lulusan"]);
	$tahun = $conn->real_escape_string($dataYangDiuji["tahun_lulus"]);
	$jenjang = $conn->real_escape_string($dataYangDiuji["jenjang_pendidikan"]);
	$institusi = $conn->real_escape_string($dataYangDiuji["jenis_institusi"]);
	$jurusan = $conn->real_escape_string($dataYangDiuji["jurusan_sekolah"]);
	$propinsi = $conn->real_escape_string($dataYangDiuji["propinsi_institusi"]);
	$prodi = $conn->real_escape_string($dataYangDiuji["prodi_yg_diterima"]);

	$klasif = $conn->real_escape_string($klasifikasi);
	$jarak = floatval($jarakHasil);
	$k = intval($nilaiK);

	$query = "UPDATE `hasil_hitung` SET 
              nama='$nama', jalur_pendaftaran='$jalur', gelombang='$gelombang', sistem_kuliah='$sistem', `l_p`='$l_p', usia='$usia', nilai_lulusan='$nilai', tahun_lulus='$tahun', jenjang_pendidikan='$jenjang', jenis_institusi='$institusi', jurusan_sekolah='$jurusan', propinsi_institusi='$propinsi', prodi_yg_diterima='$prodi', jarak_hasil='$jarak', klasifikasi='$klasif', nilai_k='$k'
              WHERE id=$id";

	$hasil = $conn->query($query);

	return $hasil ? true : false;
}



function hapusDataHasilHitungBerdasarkanId(int $id)

{

	global $conn;



	$query = "DELETE FROM `hasil_hitung` WHERE id=$id";

	$hasil = $conn->query($query);



	return $hasil ? true : false;
}

/*
 * DATA UNTUK MODEL VISUALISASI
 */
function ambilDataAkurasi()
{
	global $conn;

	$data = [];
	$query = "SELECT * FROM `knn_akurasi_k` ORDER BY nilai_k ASC";
	$hasil = $conn->query($query);

	if ($hasil && $hasil->num_rows > 0) {
		while ($barisData = $hasil->fetch_assoc()) {
			$data[] = $barisData;
		}
	}

	return $data;
}

function ambilDataConfusionMatrix()
{
	global $conn;

	$data = [];
	$query = "SELECT * FROM `knn_confusion_matrix`";
	$hasil = $conn->query($query);

	if ($hasil && $hasil->num_rows > 0) {
		while ($barisData = $hasil->fetch_assoc()) {
			$data[] = $barisData;
		}
	}

	return $data;
}
function normalizeText($text) {
    if (!is_string($text)) return $text;
    
    $str = strtoupper(trim($text));
    
    if (in_array($str, ['L', 'LAKI LAKI', 'LAKI-LAKI'])) return 'L';
    if (in_array($str, ['P', 'PEREMPUAN'])) return 'P';
    if ($str === 'ILMU PENGETAHUAN SOSIAL') return 'IPS';
    if ($str === 'ILMU PENGETAHUAN ALAM') return 'IPA';
    if (in_array($str, ['DITERIMA', 'LAYAK', '1'])) return 'DITERIMA';
    if (in_array($str, ['TIDAK DITERIMA', 'TIDAK LAYAK', '0'])) return 'TIDAK DITERIMA';
    if (in_array($str, ['CADANGAN'])) return 'CADANGAN';
    
    return $str;
}
