# Implementasi Metode K-Nearest Neighbor Untuk Klasifikasi Penerimaan Mahasiswa Baru Universitas Nahdlatul Ulama Indonesia

Repositori ini berisi *source code* aplikasi pendukung untuk skripsi dengan judul **"Implementasi Metode K-Nearest Neighbor Untuk Klasifikasi Penerimaan Mahasiswa Baru Universitas Nahdlatul Ulama Indonesia"**. Aplikasi ini dibangun secara murni menggunakan PHP Native tanpa bantuan *framework* Machine Learning dari luar (seperti Python/Scikit-Learn), menunjukkan implementasi matematis logis algoritma K-NN dari dasar.

## 🚀 Fitur Utama

- **Algoritma K-NN Native:** Implementasi perhitungan jarak *Manhattan Distance* murni menggunakan PHP.
- **Normalisasi Robust Scaler:** Pra-pemrosesan data numerik secara otomatis sebelum perhitungan jarak (menggunakan perhitungan Kuartil dan IQR).
- **Evaluasi Model Dinamis:** Menghitung *Confusion Matrix* dan Akurasi model secara otomatis dengan opsi *Data Splitting* (Rasio Data Latih/Uji) yang bisa dipilih (misal: 80/20, 70/30, 90/10, dll).
- **Visualisasi Data:** Menampilkan grafik garis (Akurasi vs Nilai K) interaktif menggunakan Chart.js.
- **Import/Export Excel:** Fitur mutakhir untuk mengelola dataset skala besar. Dilengkapi dengan **Validasi Keamanan Import (*Bulletproof*)** untuk mencegah aplikasi *crash* akibat kesalahan input angka/huruf dari pengguna.
- **Manajemen Riwayat:** Dapat melihat riwayat kalkulasi sebelumnya dan melakukan pencarian ulang (Hitung Ulang) untuk melihat detail spesifik data uji terhadap data latih.

## 💻 Teknologi yang Digunakan

- **Bahasa Pemrograman:** PHP Native (PHP 8.x)
- **Database:** MySQL / MariaDB
- **User Interface:** Bootstrap 4 (Template: Matrix Admin)
- **Visualisasi Grafik:** Chart.js
- **Library Tambahan:** PhpOffice/PhpSpreadsheet (Untuk pengolahan `.xlsx`)

## 📸 Preview Tampilan Aplikasi

### Halaman Login
[![Halaman Login](images/Login.png)](login.php)

### Halaman Tambah Akun
[![Halaman Tambah Akun](images/Register.png)](register.php)

### Halaman Home
[![Halaman Home](images/Dashboard.png)](index.php)

### Halaman Dashboard Visualisasi Evaluasi Model K-NN
[![Halaman Visualisasi](images/Model%20Visualisasi.png)](visualisasi.php)

### Halaman Hitung Data Baru K-NN
[![Halaman Hitung Data](images/Hitung%20Data%20Baru%20K-NN.png)](hasil_hitung.php)

### Halaman List Riwayat Perhitungan
[![Halaman Riwayat Hitung](images/Hitung%20Nilai%20K.png)](hasil_hitung.php)

### Halaman Dataset
[![Halaman Dataset](images/Dataset%20PMB.png)](dataset.php)

### Halaman Edit Dataset
[![Halaman Edit Dataset](images/Edit%20Dataset.png)](edit_dataset.php)

### Form Tambah Dataset
[![Form Tambah Dataset](images/Form%20Tambah%20Dataset.png)](tambah.php)

### Halaman Import Dataset dari Excel
[![Halaman Import Dataset](images/Import%20Dataset.png)](import_dataset.php)

---
*Dibuat untuk memenuhi tugas akhir / skripsi.*