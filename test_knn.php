<?php
require_once 'app/init.php';

use \Abdus\PMB\KNN\Schema;
use \Abdus\PMB\KNN\DataSet;
use \Abdus\PMB\KNN\Data;

$semuaData = ambilSemuaDataset();
$schema = new Schema();
$schema->tambahParameter('jalur_pendaftaran')->tambahParameter('gelombang')->tambahParameter('sistem_kuliah')
    ->tambahParameter('l_p')->tambahParameter('usia')->tambahParameter('nilai_lulusan')
    ->tambahParameter('tahun_lulus')->tambahParameter('jenjang_pendidikan')->tambahParameter('jenis_institusi')
    ->tambahParameter('jurusan_sekolah')->tambahParameter('propinsi_institusi')->tambahParameter('prodi_yg_diterima')
    ->setParameterKlasifikasi('klasifikasi');

$dataset = new DataSet($schema, 7);
foreach ($semuaData as $data) {
    $dataset->tambah(new Data([
        'jalur_pendaftaran' => $data['jalur_pendaftaran'],
        'gelombang' => $data['gelombang'],
        'sistem_kuliah' => $data['sistem_kuliah'],
        'l_p' => $data['l_p'],
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

$testData = new Data([
    'jalur_pendaftaran' => 'KIP-KULIAH KAMPUS A (REGULER PAGI)',
    'gelombang' => 'GELOMBANG 1',
    'sistem_kuliah' => 'REGULER PAGI',
    'l_p' => 'L',
    'usia' => 21,
    'nilai_lulusan' => 87,
    'tahun_lulus' => 2021,
    'jenjang_pendidikan' => 'SMK',
    'jenis_institusi' => 'SMKS',
    'jurusan_sekolah' => 'IPA',
    'propinsi_institusi' => 'JAWA TIMUR',
    'prodi_yg_diterima' => 'S1 - TEKNIK INFORMATIKA'
]);

$hasil = $dataset->hitung($testData);
print_r($hasil['hasil_hitung']);
