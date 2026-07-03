<?php

require_once __DIR__ . '/app/init.php';

bersihkanHasilHitungDariSession();

$data = ambilSemuaDataHasilHitung();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/css/style.css">
    <link rel="stylesheet" href="./public/css/app.css">
    <style>
        .table-responsive .table td, .table-responsive .table th {
            font-size: 11px;
            padding: 8px 4px;
            text-align: center !important;
            vertical-align: middle !important;
            word-wrap: break-word;
            white-space: normal !important;
        }
            .table-bordered, .table-bordered td, .table-bordered th {
            border: 1px solid #555 !important;
            color: #000 !important;
        }
            /* Ubah teks menjadi hitam */
        body, .page-wrapper, p, h1, h2, h3, h4, h5, h6, label, .card-title, .breadcrumb-item, .breadcrumb-item.active, td, th, li {
            color: #000;
        }
    
        /* Responsive logo */
        .navbar-brand img { transition: all 0.3s ease; }
        #main-wrapper.mini-sidebar .navbar-brand img,
        #main-wrapper[data-sidebartype="mini-sidebar"] .navbar-brand img {
            width: 55px !important;
        }
    
        /* Sidebar Styling */
        .left-sidebar, .sidebar-nav, #sidebarnav, .scroll-sidebar {
            background: #e3f2fd !important;
        }
        .sidebar-nav ul .sidebar-item .sidebar-link {
            color: #1F262D !important;
            opacity: 1 !important;
            font-weight: 500;
        }
        .sidebar-nav ul .sidebar-item .sidebar-link i {
            color: #1F262D !important;
        }
        .sidebar-nav ul .sidebar-item .sidebar-link:hover,
        .sidebar-nav ul .sidebar-item.selected > .sidebar-link {
            background: rgba(0,0,0,0.08) !important;
            color: #000 !important;
            opacity: 1 !important;
        }
        .sidebar-nav ul .sidebar-item.selected > .sidebar-link i,
        .sidebar-nav ul .sidebar-item .sidebar-link:hover i {
            color: #000 !important;
        }

    </style>

    <title>Data Hasil Hitung | Klasifikasi Penerimaan Mahasiswa Baru UNUSIA </title>
</head>

<body>

    <nav class="nav mb-4">
        <div class="container">
            <h3 class="page-title mb-0 p-0 text-dark" style="font-weight: bold; text-align: center; width: 100%; line-height: 1.4;">Sistem Klasifikasi Penerimaan Mahasiswa Baru Universitas Nahdlatul Ulama Indonesia (UNUSIA)<br>Menggunakan Metode K-Nearest Neighbor (K-NN)</h3>
        </div>
    </nav>

    <div class="container">

        <div class="button-group">
            <a href="index.php" class="btn btn-secondary-outline btn-sm link">Home</a>
            <a href="dataset.php" class="btn btn-secondary-outline btn-sm link">Dataset</a>
            <a href="data_hasil_hitung.php" class="btn btn-secondary-outline btn-sm link"
                style="margin-right: 20px;">Data Hasil Hitung</a>
        </div>

        <div class="container-fluid my-4">
            <div class="card">
                <div class="card-title">
                    <h3>Tabel Riwayat Data Hasil Hitung</h3>
                </div>
                <div class="card-body mt-3">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center text-wrap">No</th>
                                    <th class="text-center text-wrap">Nama</th>
                                    <th class="text-center text-wrap">Jalur</th>
                                    <th class="text-center text-wrap">Gelombang</th>
                                    <th class="text-center text-wrap">Sistem Kuliah</th>
                                    <th class="text-center text-wrap">L/P</th>
                                    <th class="text-center text-wrap">Usia</th>
                                    <th class="text-center text-wrap">Nilai Lulusan</th>
                                    <th class="text-center text-wrap">Tahun Lulus</th>
                                    <th class="text-center text-wrap">Jenjang</th>
                                    <th class="text-center text-wrap">Jenis Institusi</th>
                                    <th class="text-center text-wrap">Jurusan</th>
                                    <th class="text-center text-wrap">Propinsi Asal</th>
                                    <th class="text-center text-wrap">Prodi Diterima</th>
                                    <th class="text-center text-wrap" style="background-color: #d1ecf1;">Nilai K</th>
                                    <th class="text-center text-wrap" style="background-color: #d1ecf1;">Jarak</th>
                                    <th class="text-center text-wrap" style="background-color: #d4edda;">Klasifikasi
                                        (Hasil)</th>
                                    <th class="text-center text-wrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($data) > 0) : ?>
                                    
                                    <?php $no = 1; foreach ($data as $row) : ?>
                                        <tr>
                                            <td class="text-center text-wrap"><?= $no++; ?></td>
                                            <td class="text-wrap"><?= $row['nama'] ?></td>
                                            <td class="text-center text-wrap"><?= $row['jalur_pendaftaran'] ?></td>
                                            <td class="text-center text-wrap"><?= $row['gelombang'] ?></td>
                                            <td class="text-center text-wrap"><?= $row['sistem_kuliah'] ?></td>
                                            <td class="text-center text-wrap"><?= $row['l_p'] ?></td>
                                            <td class="text-center text-wrap"><?= $row['usia'] ?> Tahun</td>
                                            <td class="text-center text-wrap"><?= $row['nilai_lulusan'] ?></td>
                                            <td class="text-center text-wrap"><?= $row['tahun_lulus'] ?></td>
                                            <td class="text-center text-wrap"><?= $row['jenjang_pendidikan'] ?></td>
                                            <td class="text-center text-wrap"><?= $row['jenis_institusi'] ?></td>
                                            <td class="text-center text-wrap"><?= $row['jurusan_sekolah'] ?></td>
                                            <td class="text-center text-wrap"><?= $row['propinsi_institusi'] ?></td>
                                            <td class="text-center text-wrap"><?= $row['prodi_yg_diterima'] ?></td>
                                            <td class="text-center text-wrap" style="background-color: #e2e3e5;">
                                                <b><?= $row['nilai_k'] ?></b>
                                            </td>
                                            <td class="text-center text-wrap" style="background-color: #e2e3e5;">
                                                <?= $row['jarak_hasil'] ?></td>
                                            <td class="text-center text-wrap"
                                                style="background-color: #c3e6cb; font-weight: bold;"><?= $row['klasifikasi'] ?>
                                            </td>
                                            <td class="text-center text-wrap">
                                                <a href="./hapus_hasil.php?id=<?= $row['id'] ?>" role="button"
                                                    class="badge badge-danger"
                                                    onclick="return confirm('Yakin ingin menghapus riwayat hitung ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="18" class="text-center">Belum ada riwayat hasil perhitungan K-NN.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Script to dynamically resize logo based on sidebar state -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var wrapper = document.getElementById('main-wrapper');
            var img = document.querySelector('.navbar-brand img');
            if (wrapper && img) {
                var updateLogoSize = function() {
                    var isMini = wrapper.getAttribute('data-sidebartype') === 'mini-sidebar' || wrapper.classList.contains('mini-sidebar');
                    img.style.setProperty('width', isMini ? '65px' : '80px', 'important');
                    img.style.setProperty('max-width', isMini ? 'none' : '100%', 'important');
                    img.style.setProperty('transform', isMini ? 'scale(1.2)' : 'scale(1)', 'important');
                    img.style.setProperty('transition', 'width 0.3s ease');
                };
                
                var observer = new MutationObserver(updateLogoSize);
                observer.observe(wrapper, { attributes: true, attributeFilter: ['data-sidebartype', 'class'] });
                
                // Initial check
                updateLogoSize();
            }
        });
    </script>
</body>
</html>