<?php
require_once __DIR__ . '/../app/init.php';

function normalizeTextLocally($text) {
    if (!is_string($text)) return $text;
    
    $str = strtoupper(trim($text));
    
    // Mapping L/P
    if (in_array($str, ['L', 'LAKI LAKI', 'LAKI-LAKI'])) return 'LAKI-LAKI';
    if (in_array($str, ['P', 'PEREMPUAN'])) return 'PEREMPUAN';
    
    // Mapping Jurusan
    if ($str === 'ILMU PENGETAHUAN SOSIAL') return 'IPS';
    if ($str === 'ILMU PENGETAHUAN ALAM') return 'IPA';
    
    // Mapping Kelas/Klasifikasi
    if (in_array($str, ['DITERIMA', 'LAYAK', '1'])) return 'DITERIMA';
    if (in_array($str, ['TIDAK DITERIMA', 'TIDAK LAYAK', '0'])) return 'TIDAK DITERIMA';
    
    return $str;
}

global $conn;

$tables = ['dataset', 'hasil_hitung'];

foreach ($tables as $table) {
    $result = $conn->query("SELECT id, l_p, jurusan_sekolah, klasifikasi, jalur_pendaftaran, sistem_kuliah, jenjang_pendidikan, jenis_institusi, propinsi_institusi, prodi_yg_diterima FROM $table");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $lp = $conn->real_escape_string(normalizeTextLocally($row['l_p']));
            $jurusan = $conn->real_escape_string(normalizeTextLocally($row['jurusan_sekolah']));
            $klasifikasi = $conn->real_escape_string(normalizeTextLocally($row['klasifikasi']));
            $jalur = $conn->real_escape_string(normalizeTextLocally($row['jalur_pendaftaran']));
            $sistem = $conn->real_escape_string(normalizeTextLocally($row['sistem_kuliah']));
            $jenjang = $conn->real_escape_string(normalizeTextLocally($row['jenjang_pendidikan']));
            $institusi = $conn->real_escape_string(normalizeTextLocally($row['jenis_institusi']));
            $propinsi = $conn->real_escape_string(normalizeTextLocally($row['propinsi_institusi']));
            $prodi = $conn->real_escape_string(normalizeTextLocally($row['prodi_yg_diterima']));
            
            $conn->query("UPDATE $table SET l_p='$lp', jurusan_sekolah='$jurusan', klasifikasi='$klasifikasi', jalur_pendaftaran='$jalur', sistem_kuliah='$sistem', jenjang_pendidikan='$jenjang', jenis_institusi='$institusi', propinsi_institusi='$propinsi', prodi_yg_diterima='$prodi' WHERE id=$id");
        }
    }
}
echo 'Normalisasi Database Selesai!';
