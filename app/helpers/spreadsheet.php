<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

function importDataset(string $path)
{
	$spreadsheet = IOFactory::load($path);
	$sheet = $spreadsheet->getActiveSheet();
	$dataExcel = $sheet->toArray(null, true, true, true);

	// Ambil header
	$header = array_shift($dataExcel);

	// Mapping header
	$colMap = array_flip($header);

	$fields = [
		'nama',
		'jalur_pendaftaran',
		'gelombang',
		'sistem_kuliah',
		'l_p',
		'usia',
		'nilai_lulusan',
		'tahun_lulus',
		'jenjang_pendidikan',
		'jenis_institusi',
		'jurusan_sekolah',
		'propinsi_institusi',
		'prodi_yg_diterima',
		'klasifikasi'
	];

	$dataset = [];
	$barisKe = 2; // Mulai dari baris ke-2 (karena baris ke-1 adalah header)

	foreach ($dataExcel as $row) {

		$data = [];

		foreach ($fields as $field) {

			if (isset($colMap[$field])) {

				$index = $colMap[$field];
				$value = trim((string)$row[$index]);

				// Pengecualian khusus L/P
				if ($field === 'l_p') {
					if ($value === '0') $value = 'L';
					if ($value === '1') $value = 'P';
				}

				// Validasi Keamanan (Data Validation)
				if (in_array($field, ['usia', 'nilai_lulusan', 'tahun_lulus'])) {
					// Pastikan jika tidak kosong, nilainya wajib berupa angka!
					if ($value !== '' && !is_numeric($value)) {
						throw new Exception("GAGAL IMPORT! Ada kesalahan pada Baris ke-$barisKe di Excel Anda. Kolom '$field' harus berupa angka, tetapi isinya teks: '$value'. Silakan perbaiki dan coba lagi.");
					}
				} else {
					// Teks biasa dinormalisasi menjadi UPPERCASE
					$value = normalizeText($value);
				}

				$data[] = $value;
			} else {

				$data[] = '';
			}
		}

		if (count($data) == 14) {
			$dataset[] = $data;
		}

		$barisKe++;
	}

	// DEBUG HASIL SEBELUM INSERT
	// echo "<pre>";
	// print_r($dataset);
	// echo "</pre>";
	// die();

	foreach ($dataset as $dtset) {
		tambahData($dtset, 'dataset');
	}

	return true;
}
