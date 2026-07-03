<?php
require_once '../init.php';
require_once '../helpers/auth.php';
check_login();

$target_dir = "../../uploads/";
$old_files = glob($target_dir . "visualisasi_*.*");
foreach($old_files as $file){
    if(is_file($file)) {
        unlink($file);
    }
}

header("Location: ../../visualisasi.php?success=hapus_gambar");
exit;
