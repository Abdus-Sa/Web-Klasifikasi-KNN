<?php

require_once __DIR__ . '/../app/init.php';

global $conn;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. Create table knn_akurasi_k
$sql1 = "CREATE TABLE IF NOT EXISTS knn_akurasi_k (
    id_evaluasi INT AUTO_INCREMENT PRIMARY KEY,
    nilai_k INT NOT NULL,
    nilai_akurasi DECIMAL(5,2) NOT NULL,
    keterangan VARCHAR(100) NULL,
    tanggal_proses TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql1) === TRUE) {
    echo "Table knn_akurasi_k created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Truncate table
$conn->query("TRUNCATE TABLE knn_akurasi_k");

// Insert sample data
$sql2 = "INSERT INTO knn_akurasi_k (nilai_k, nilai_akurasi) VALUES 
(3, 50.15),
(5, 54.20),
(7, 58.39),
(9, 62.50)";
if ($conn->query($sql2) === TRUE) {
    echo "Sample data inserted into knn_akurasi_k successfully\n";
} else {
    echo "Error inserting data: " . $conn->error . "\n";
}

// 2. Create table knn_confusion_matrix
$sql3 = "CREATE TABLE IF NOT EXISTS knn_confusion_matrix (
    id_matrix INT AUTO_INCREMENT PRIMARY KEY,
    kelas_asli VARCHAR(50) NOT NULL,
    kelas_prediksi VARCHAR(50) NOT NULL,
    jumlah_data INT NOT NULL,
    tanggal_proses TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql3) === TRUE) {
    echo "Table knn_confusion_matrix created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Truncate table
$conn->query("TRUNCATE TABLE knn_confusion_matrix");

// Insert sample data
$sql4 = "INSERT INTO knn_confusion_matrix (kelas_asli, kelas_prediksi, jumlah_data) VALUES 
('Diterima', 'Diterima', 120),
('Diterima', 'Tidak Diterima', 45),
('Tidak Diterima', 'Diterima', 30),
('Tidak Diterima', 'Tidak Diterima', 85)";
if ($conn->query($sql4) === TRUE) {
    echo "Sample data inserted into knn_confusion_matrix successfully\n";
} else {
    echo "Error inserting data: " . $conn->error . "\n";
}

$conn->close();
?>
