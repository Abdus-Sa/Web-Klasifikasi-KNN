<?php
require_once '../init.php';
require_once '../helpers/auth.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['gambar_visualisasi'])) {
    $target_dir = "../../uploads/";
    
    // Buat folder jika belum ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Hapus SEMUA gambar lama terlebih dahulu
    $old_files = glob($target_dir . "visualisasi_*.*");
    foreach($old_files as $file){
        if(is_file($file)) {
            unlink($file);
        }
    }
    
    $success_count = 0;
    
    // Loop melalui setiap file yang diupload
    $total_files = count($_FILES['gambar_visualisasi']['name']);
    for ($i = 0; $i < $total_files; $i++) {
        if ($_FILES['gambar_visualisasi']['error'][$i] == 0) {
            $file_extension = strtolower(pathinfo($_FILES["gambar_visualisasi"]["name"][$i], PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["gambar_visualisasi"]["tmp_name"][$i]);
            
            if($check !== false) {
                // Beri nama unik visualisasi_1, visualisasi_2, dst
                $target_file = $target_dir . "visualisasi_" . ($i + 1) . "." . $file_extension;
                
                if (move_uploaded_file($_FILES["gambar_visualisasi"]["tmp_name"][$i], $target_file)) {
                    $success_count++;
                }
            }
        }
    }
    
    if ($success_count > 0) {
        header("Location: ../../visualisasi.php?success=upload");
    } else {
        header("Location: ../../visualisasi.php?error=upload");
    }
} else {
    header("Location: ../../visualisasi.php");
}
