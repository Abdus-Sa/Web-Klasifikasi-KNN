<?php
require_once __DIR__ . '/app/helpers/auth.php';
check_login();

// 1. Panggil file inisialisasi/koneksi database
require_once '../init.php';

// 2. Cek apakah ada pengiriman data menggunakan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // 3. Tangkap semua data dari form input (mencegah SQL Injection)
  $nama               = mysqli_real_escape_string($koneksi, $_POST['nama']);
  $jalur_pendaftaran  = mysqli_real_escape_string($koneksi, $_POST['jalur_pendaftaran']);
  $gelombang          = mysqli_real_escape_string($koneksi, $_POST['gelombang']);
  $sistem_kuliah      = mysqli_real_escape_string($koneksi, $_POST['sistem_kuliah']);
  $l_p                = mysqli_real_escape_string($koneksi, $_POST['l_p']);
  $usia               = mysqli_real_escape_string($koneksi, $_POST['usia']);
  $nilai_lulusan      = mysqli_real_escape_string($koneksi, $_POST['nilai_lulusan']);
  $tahun_lulus        = mysqli_real_escape_string($koneksi, $_POST['tahun_lulus']);
  $jenjang_pendidikan = mysqli_real_escape_string($koneksi, $_POST['jenjang_pendidikan']);
  $jenis_institusi    = mysqli_real_escape_string($koneksi, $_POST['jenis_institusi']);
  $jurusan_sekolah    = mysqli_real_escape_string($koneksi, $_POST['jurusan_sekolah']);
  $propinsi_institusi = mysqli_real_escape_string($koneksi, $_POST['propinsi_institusi']);
  $prodi_yg_diterima  = mysqli_real_escape_string($koneksi, $_POST['prodi_yg_diterima']);
  $klasifikasi        = mysqli_real_escape_string($koneksi, $_POST['klasifikasi']);

  // 4. Susun Query SQL untuk memasukkan data (INSERT)
  // Nama tabel sudah disesuaikan menjadi 'dataset'
  $query = "INSERT INTO dataset (
                nama, jalur_pendaftaran, gelombang, sistem_kuliah, l_p, 
                usia, nilai_lulusan, tahun_lulus, jenjang_pendidikan, 
                jenis_institusi, jurusan_sekolah, propinsi_institusi, 
                prodi_yg_diterima, klasifikasi
              ) VALUES (
                '$nama', '$jalur_pendaftaran', '$gelombang', '$sistem_kuliah', '$l_p', 
                '$usia', '$nilai_lulusan', '$tahun_lulus', '$jenjang_pendidikan', 
                '$jenis_institusi', '$jurusan_sekolah', '$propinsi_institusi', 
                '$prodi_yg_diterima', '$klasifikasi'
              )";

  // 5. Eksekusi query tersebut
  $eksekusi = mysqli_query($koneksi, $query);

  // 6. Cek apakah proses insert berhasil atau gagal
  if ($eksekusi) {
    echo "<script>
                alert('Data calon mahasiswa berhasil ditambahkan ke tabel dataset!');
                window.location.href = '../../dataset.php';
              </script>";
  } else {
    echo "<script>
                alert('Waduh, gagal menambahkan data: " . mysqli_error($koneksi) . "');
                window.location.href = '../../dataset.php';
              </script>";
  }
} else {
  // Jika diakses langsung tanpa lewat form, kembalikan ke halaman dataset
  header("Location: ../../dataset.php");
  exit;
}
