<?php
$files = ['dataset.php', 'import_dataset.php', 'hasil_hitung.php', 'edit_dataset.php'];
$search = '                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="hasil_hitung.php"
                                aria-expanded="false">
                                <i class="fas fa-folder"></i>
                                <span class="hide-menu">Hasil Hitung</span>
                            </a>
                        </li>';
$replace = $search . '
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="visualisasi.php"
                                aria-expanded="false">
                                <i class="fas fa-chart-line"></i>
                                <span class="hide-menu">Model Visualisasi</span>
                            </a>
                        </li>';

foreach ($files as $file) {
    $path = __DIR__ . '/../' . $file;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        // Normalize line endings to avoid mismatch
        $content = str_replace("\r\n", "\n", $content);
        $searchNorm = str_replace("\r\n", "\n", $search);
        
        $newContent = str_replace($searchNorm, $replace, $content);
        if ($newContent !== $content) {
            file_put_contents($path, $newContent);
            echo "Updated $file\n";
        } else {
            echo "Search string not found in $file\n";
        }
    }
}
?>
