<?php

require_once __DIR__ . '/../init.php';

use \Abdus\PMB\KNN\Schema;
use \Abdus\PMB\KNN\DataSet;
use \Abdus\PMB\KNN\Data;

function jalankanEvaluasi($rasioTrain = 0.8)
{
    global $conn;

    $semuaData = ambilSemuaDataset();
    $totalData = count($semuaData);

    if ($totalData < 10) {
        return false; // Tidak cukup data untuk evaluasi yang bermakna
    }

    // Acak urutan data
    shuffle($semuaData);

    // Rasio Train dinamis (default 80%)
    $trainSize = (int)($totalData * $rasioTrain);

    $trainData = array_slice($semuaData, 0, $trainSize);
    $testData = array_slice($semuaData, $trainSize);

    if (count($testData) == 0) return;

    $schema = new Schema();
    $schema
        ->tambahParameter('jalur_pendaftaran')
        ->tambahParameter('gelombang')
        ->tambahParameter('sistem_kuliah')
        ->tambahParameter('l_p')
        ->tambahParameter('usia')
        ->tambahParameter('nilai_lulusan')
        ->tambahParameter('tahun_lulus')
        ->tambahParameter('jenjang_pendidikan')
        ->tambahParameter('jenis_institusi')
        ->tambahParameter('jurusan_sekolah')
        ->tambahParameter('propinsi_institusi')
        ->tambahParameter('prodi_yg_diterima')
        ->setParameterKlasifikasi('klasifikasi');

    $k_values = [3, 5, 7, 9];

    $akurasi_results = [];
    $best_k = 3;
    $best_akurasi = -1;
    $best_confusion_matrix = [];

    foreach ($k_values as $k) {
        $dataset = new DataSet($schema, $k);

        // Masukkan data latih
        foreach ($trainData as $data) {
            $dataset->tambah(new Data([
                'nama' => $data['nama'],
                'jalur_pendaftaran' => $data['jalur_pendaftaran'],
                'gelombang' => $data['gelombang'],
                'sistem_kuliah' => $data['sistem_kuliah'],
                'l_p' => strtolower($data['l_p']),
                'usia' => floatval($data['usia']),
                'nilai_lulusan' => floatval($data['nilai_lulusan']),
                'tahun_lulus' => floatval($data['tahun_lulus']),
                'jenjang_pendidikan' => $data['jenjang_pendidikan'],
                'jenis_institusi' => $data['jenis_institusi'],
                'jurusan_sekolah' => $data['jurusan_sekolah'],
                'propinsi_institusi' => $data['propinsi_institusi'],
                'prodi_yg_diterima' => $data['prodi_yg_diterima'],
                'klasifikasi' => strtolower(trim($data['klasifikasi']))
            ]));
        }

        $correct = 0;

        $confusion_matrix = [
            'diterima' => ['diterima' => 0, 'tidak diterima' => 0],
            'tidak diterima' => ['diterima' => 0, 'tidak diterima' => 0]
        ];

        // Lakukan pengujian pada data uji
        foreach ($testData as $test) {
            $hasil = $dataset->hitung(
                new Data([
                    'nama' => $test['nama'],
                    'jalur_pendaftaran' => $test['jalur_pendaftaran'],
                    'gelombang' => $test['gelombang'],
                    'sistem_kuliah' => $test['sistem_kuliah'],
                    'l_p' => strtolower($test['l_p']),
                    'usia' => floatval($test['usia']),
                    'nilai_lulusan' => floatval($test['nilai_lulusan']),
                    'tahun_lulus' => floatval($test['tahun_lulus']),
                    'jenjang_pendidikan' => $test['jenjang_pendidikan'],
                    'jenis_institusi' => $test['jenis_institusi'],
                    'jurusan_sekolah' => $test['jurusan_sekolah'],
                    'propinsi_institusi' => $test['propinsi_institusi'],
                    'prodi_yg_diterima' => $test['prodi_yg_diterima']
                ])
            );

            // Perbaikan ekstraksi hasil KNN
            $hasilHitungRaw = $hasil["hasil_hitung"];
            if (is_array($hasilHitungRaw) && isset($hasilHitungRaw['klasifikasi'])) {
                $hasilHitung = (string) $hasilHitungRaw['klasifikasi'];
            } elseif (is_array($hasilHitungRaw)) {
                $keyPertama = array_key_first($hasilHitungRaw);
                $valuePertama = $hasilHitungRaw[$keyPertama];
                if (is_string($keyPertama) && !is_numeric($keyPertama)) {
                    $hasilHitung = $keyPertama;
                } else {
                    $hasilHitung = is_array($valuePertama) ? json_encode($valuePertama) : (string) $valuePertama;
                }
            } else {
                $hasilHitung = (string) $hasilHitungRaw;
            }

            $prediksi = strtolower(trim($hasilHitung));
            $asli = strtolower(trim($test['klasifikasi']));

            // Standardisasi nilai (Diterima -> diterima, Tidak Diterima -> tidak diterima)
            if (in_array($prediksi, ['diterima', 'layak', '1'])) $prediksi_std = 'diterima';
            else $prediksi_std = 'tidak diterima';

            if (in_array($asli, ['diterima', 'layak', '1'])) $asli_std = 'diterima';
            else $asli_std = 'tidak diterima';

            if ($prediksi_std == $asli_std) {
                $correct++;
            }

            // Tambahkan ke matrix
            if (isset($confusion_matrix[$asli_std][$prediksi_std])) {
                $confusion_matrix[$asli_std][$prediksi_std]++;
            }
        }

        $akurasi = ($correct / count($testData)) * 100;
        $akurasi_results[$k] = $akurasi;

        if ($akurasi > $best_akurasi) {
            $best_akurasi = $akurasi;
            $best_k = $k;
            $best_confusion_matrix = $confusion_matrix;
        }
    }

    // 1. Simpan hasil Akurasi
    $conn->query("TRUNCATE TABLE knn_akurasi_k");

    // Siapkan teks keterangan
    $persenLatih = $rasioTrain * 100;
    $persenUji = 100 - $persenLatih;
    $keteranganRasio = "{$persenLatih}% Latih / {$persenUji}% Uji";

    foreach ($akurasi_results as $k => $akr) {
        $query_akr = "INSERT INTO knn_akurasi_k (nilai_k, nilai_akurasi, keterangan) VALUES ('$k', '$akr', '$keteranganRasio')";
        $conn->query($query_akr);
    }

    // 2. Simpan hasil Confusion Matrix dari nilai K terbaik
    $conn->query("TRUNCATE TABLE knn_confusion_matrix");

    // Asli Diterima, Prediksi Diterima (TP)
    $tp = $best_confusion_matrix['diterima']['diterima'];
    // Asli Diterima, Prediksi Tidak Diterima (FN)
    $fn = $best_confusion_matrix['diterima']['tidak diterima'];
    // Asli Tidak Diterima, Prediksi Diterima (FP)
    $fp = $best_confusion_matrix['tidak diterima']['diterima'];
    // Asli Tidak Diterima, Prediksi Tidak Diterima (TN)
    $tn = $best_confusion_matrix['tidak diterima']['tidak diterima'];

    $conn->query("INSERT INTO knn_confusion_matrix (kelas_asli, kelas_prediksi, jumlah_data) VALUES ('Diterima', 'Diterima', $tp)");
    $conn->query("INSERT INTO knn_confusion_matrix (kelas_asli, kelas_prediksi, jumlah_data) VALUES ('Diterima', 'Tidak Diterima', $fn)");
    $conn->query("INSERT INTO knn_confusion_matrix (kelas_asli, kelas_prediksi, jumlah_data) VALUES ('Tidak Diterima', 'Diterima', $fp)");
    $conn->query("INSERT INTO knn_confusion_matrix (kelas_asli, kelas_prediksi, jumlah_data) VALUES ('Tidak Diterima', 'Tidak Diterima', $tn)");

    return true;
}
