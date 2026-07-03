<?php
require_once __DIR__ . '/../init.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$hasil_hitung = ambilSemuaDataHasilHitung();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set Header
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'Jalur Pendaftaran');
$sheet->setCellValue('D1', 'Gelombang');
$sheet->setCellValue('E1', 'Sistem Kuliah');
$sheet->setCellValue('F1', 'L/P');
$sheet->setCellValue('G1', 'Usia');
$sheet->setCellValue('H1', 'Nilai Lulusan');
$sheet->setCellValue('I1', 'Tahun Lulus');
$sheet->setCellValue('J1', 'Jenjang Pendidikan');
$sheet->setCellValue('K1', 'Jenis Institusi');
$sheet->setCellValue('L1', 'Jurusan Sekolah');
$sheet->setCellValue('M1', 'Provinsi Institusi');
$sheet->setCellValue('N1', 'Prodi Yg Diterima');
$sheet->setCellValue('O1', 'Jarak Hasil');
$sheet->setCellValue('P1', 'Nilai K');
$sheet->setCellValue('Q1', 'Hasil Klasifikasi');

// Styling Header
$headerStyleArray = [
    'font' => [
        'bold' => true,
        'color' => ['argb' => 'FFFFFFFF'],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FF28A745', // Hijau
        ],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$sheet->getStyle('A1:Q1')->applyFromArray($headerStyleArray);

$row = 2;
$no = 1;
foreach ($hasil_hitung as $dt) {
    $sheet->setCellValue('A' . $row, $no++);
    $sheet->setCellValue('B' . $row, $dt['nama']);
    $sheet->setCellValue('C' . $row, $dt['jalur_pendaftaran']);
    $sheet->setCellValue('D' . $row, $dt['gelombang']);
    $sheet->setCellValue('E' . $row, $dt['sistem_kuliah']);
    $sheet->setCellValue('F' . $row, $dt['l_p']);
    $sheet->setCellValue('G' . $row, $dt['usia']);
    $sheet->setCellValue('H' . $row, $dt['nilai_lulusan']);
    $sheet->setCellValue('I' . $row, $dt['tahun_lulus']);
    $sheet->setCellValue('J' . $row, $dt['jenjang_pendidikan']);
    $sheet->setCellValue('K' . $row, $dt['jenis_institusi']);
    $sheet->setCellValue('L' . $row, $dt['jurusan_sekolah']);
    $sheet->setCellValue('M' . $row, $dt['propinsi_institusi']);
    $sheet->setCellValue('N' . $row, $dt['prodi_yg_diterima']);
    $sheet->setCellValue('O' . $row, round($dt['jarak_hasil'], 4));
    $sheet->setCellValue('P' . $row, $dt['nilai_k']);
    $sheet->setCellValue('Q' . $row, strtoupper($dt['klasifikasi']));
    $row++;
}

// Auto size columns
foreach (range('A', 'Q') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Border data
$dataStyleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$sheet->getStyle('A2:Q' . ($row - 1))->applyFromArray($dataStyleArray);

$writer = new Xlsx($spreadsheet);
$filename = 'Laporan_Prediksi_PMB_KNN_' . date('Ymd_His') . '.xlsx';

ob_end_clean(); // Bersihkan output buffer
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'. $filename .'"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
