<?php

require_once __DIR__ . '/app/init.php';
require_once __DIR__ . '/app/helpers/auth.php';
check_login();

bersihkanHasilHitungDariSession();

$data = ambilSemuaDataset();

?>


<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/unusia.png">
    <title>Home | Klasifikasi Penerimaan Mahasiswa Baru UNUSIA</title>
    <!-- Custom CSS -->
    <!-- Custom CSS -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="dist/css/style.min.css?v=2" rel="stylesheet">
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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark" style="background: #e3f2fd !important;">
                <div class="navbar-header" data-logobg="skin5" style="background: #e3f2fd !important;">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-brand" style="display: flex; justify-content: center; align-items: center; width: 100%; min-height: 64px;">
                        <a href="index.php" style="text-decoration: none;">
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <img src="images/unusia-removebg-preview.png" alt="homepage" style="width: 80px; max-width: 100%;" />
                            </div>
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto" style="width: 100%;">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar" style="font-size: 24px; color: #1F262D; display: flex; align-items: center; height: 100%; padding-right: 20px;">
                                <span class="mdi mdi-menu"></span>
                            </a>
                        </li>
                        <h4 style="flex: 1; text-align: center; margin: 0; align-self: center; font-size: 16px; padding-right: 40px; font-weight: bold; color: #1F262D !important;">Sistem Klasifikasi Penerimaan Mahasiswa Baru Universitas Nahdlatul Ulama Indonesia (UNUSIA)<br>Menggunakan Metode K-Nearest Neighbor (K-NN)</h4>
                        
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->

                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        
                        
                        
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="index.php"
                                aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <span class="hide-menu">Home</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="import_dataset.php"
                                aria-expanded="false">
                                <i class="fas fa-upload"></i>
                                <span class="hide-menu">Import Dataset</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dataset.php"
                                aria-expanded="false">
                                <i class="fas fa-database"></i>
                                <span class="hide-menu">Dataset</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="hasil_hitung.php"
                                aria-expanded="false">
                                <i class="fas fa-folder"></i>
                                <span class="hide-menu">Hasil Hitung</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="visualisasi.php"
                                aria-expanded="false">
                                <i class="fas fa-chart-line"></i>
                                <span class="hide-menu">Model Visualisasi</span>
                            </a>
                        </li>
                        <li class="sidebar-item mt-4">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link text-danger" href="logout.php"
                                aria-expanded="false" style="border-top: 1px solid #ff4d4d; padding-top: 15px;">
                                <i class="fas fa-sign-out-alt text-danger"></i>
                                <span class="hide-menu font-weight-bold">Logout</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Dataset</h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Dataset</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- basic table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href ="javascript:void(1)" data-toggle="modal" data-target="#modalTambah" class="btn btn-sm btn-primary"><i class="fas fa-plus mr-2"></i>Tambah Data</a>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">List Dataset</h4>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered display"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Jalur Pendaftaran</th>
                                                <th class="text-center">Gelombang</th>
                                                <th class="text-center">Sistem Kuliah</th>
                                                <th class="text-center">L/P</th>
                                                <th class="text-center">Usia</th>
                                                <th class="text-center">Nilai Lulusan</th>
                                                <th class="text-center">Tahun Lulus</th>
                                                <th class="text-center">Jenjang Pendidikan</th>
                                                <th class="text-center">Jenis Institusi</th>
                                                <th class="text-center">Jurusan Sekolah</th>
                                                <th class="text-center">Provinsi Institusi</th>
                                                <th class="text-center">Prodi Yg Diterima</th>
                                                <th class="text-center">Klasifikasi</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($data as $dt) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $i++; ?></td>
                                                    <td class="text-wrap"><?= $dt['nama']; ?></td>
                                                    <td align="center" class="text-wrap"><?= $dt['jalur_pendaftaran']; ?></td>
                                                    <td align="center" class="text-wrap"><?= $dt['gelombang']; ?></td>
                                                    <td align="center" class="text-wrap"><?= $dt['sistem_kuliah']; ?></td>
                                                    <td align="center" class="text-wrap"><?= $dt['l_p']; ?></td>
                                                    <td align="center" class="text-wrap"><?= $dt['usia']; ?></td>
                                                    <td align="center" class="text-wrap"><?= $dt['nilai_lulusan']; ?></td>
                                                    <td align="center" class="text-wrap"><?= $dt['tahun_lulus']; ?></td>
                                                    <td align="center" class="text-wrap"><?= $dt['jenjang_pendidikan']; ?></td>
                                                    <td align="center" class="text-wrap"><?= $dt['jenis_institusi']; ?></td>
                                                    <td align="center" class="text-wrap"><?= $dt['jurusan_sekolah']; ?></td>
                                                    <td align="center" class="text-wrap"><?= $dt['propinsi_institusi']; ?></td>
                                                    <td align="center" class="text-wrap"><?= $dt['prodi_yg_diterima']; ?></td>

                                                    <td align="center">
                                                        <?php
                                                        $klasifikasi = strtolower(trim($dt['klasifikasi']));
                                                        if ($klasifikasi == 'diterima' || $klasifikasi == 'layak') {
                                                            echo '<span class="badge badge-success">' . ucfirst($dt['klasifikasi']) . '</span>';
                                                        } else if ($klasifikasi == 'ditolak' || $klasifikasi == 'tidak layak') {
                                                            echo '<span class="badge badge-danger">' . ucfirst($dt['klasifikasi']) . '</span>';
                                                        } else {
                                                            echo '<span class="badge badge-primary">' . ucfirst($dt['klasifikasi']) . '</span>';
                                                        }
                                                        ?>
                                                    </td>

                                                    <td align="center">
                                                        <a href="./edit_dataset.php?id=<?= $dt['id']; ?>" role="button"
                                                            class="btn btn-sm btn-warning w-100 mb-1" style="border-radius: 0; padding: 4px;">Edit</a>
                                                        <a href="./app/proses/hapus.php?id=<?= $dt['id']; ?>" role="button"
                                                            class="btn btn-sm btn-danger w-100" style="border-radius: 0; padding: 4px;"
                                                            onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="modal" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Tambah Dataset</h5>
                    <div role="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </div>
                </div>

                <form action="./app/proses/tambah.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" placeholder="Nama Calon Mahasiswa" id="nama"
                                        name="nama" required>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="jalur_pendaftaran">Jalur Pendaftaran</label>
                                    <select name="jalur_pendaftaran" id="jalur_pendaftaran" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="KIP-Kuliah kampus A (Reguler Pagi)">KIP-Kuliah kampus A (Reguler Pagi)</option>
                                        <option value="KIP-Kuliah kampus B (Reguler Pagi)">KIP-Kuliah kampus B (Reguler Pagi)</option>
                                        <option value="Mandiri S1 kampus A (Ekstensi)">Mandiri S1 kampus A (Ekstensi)</option>
                                        <option value="Mandiri S1 kampus A (Reguler Pagi)">Mandiri S1 kampus A (Reguler Pagi)</option>
                                        <option value="Mandiri S1 kampus B (Ekstensi)">Mandiri S1 kampus B (Ekstensi)</option>
                                        <option value="Mandiri S1 kampus B (Reguler Pagi)">Mandiri S1 kampus B (Reguler Pagi)</option>
                                        <option value="NU Leader Future Kampus B (Reguler Pagi)">NU Leader Future Kampus B (Reguler Pagi)</option>
                                        <option value="PBSB Sarjana (Reguler Pagi)">PBSB Sarjana (Reguler Pagi)</option>
                                        <option value="Penjaringan Transmigrasi Kampus B (Reguler Pagi)">Penjaringan Transmigrasi Kampus B (Reguler Pagi)</option>
                                        <option value="Pertamina Sobat Bumi (Reguler Pagi)">Pertamina Sobat Bumi (Reguler Pagi)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="gelombang">Gelombang</label>
                                    <select name="gelombang" id="gelombang" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="GELOMBANG 1">Gelombang 1</option>
                                        <option value="GELOMBANG 2">Gelombang 2</option>
                                        <option value="GELOMBANG 3">Gelombang 3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="sistem_kuliah">Sistem Kuliah</label>
                                    <select name="sistem_kuliah" id="sistem_kuliah" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Ekstensi">Ekstensi</option>
                                        <option value="Reguler Pagi">Reguler Pagi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="l_p">L/P</label>
                                    <select name="l_p" id="l_p" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="L">L</option>
                                        <option value="P">P</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="usia">Usia</label>
                                    <input type="number" min="0" name="usia" class="form-control" id="usia" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="nilai_lulusan">Nilai Lulusan</label>
                                    <input type="number" step="any" min="0" name="nilai_lulusan" class="form-control"
                                        id="nilai_lulusan" required>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="tahun_lulus">Tahun Lulus</label>
                                    <select name="tahun_lulus" class="form-control" id="tahun_lulus" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                                        <option value="2021">2021</option>
                                        <option value="2020">2020</option>
                                        <option value="2019">2019</option>
                                        <option value="2018">2018</option>
                                        <option value="2017">2017</option>
                                        <option value="2016">2016</option>
                                        <option value="2015">2015</option>
                                        <option value="2014">2014</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="jenjang_pendidikan">Jenjang Pendidikan</label>
                                    <select name="jenjang_pendidikan" id="jenjang_pendidikan" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="MA">MA</option>
                                        <option value="SMA">SMA</option>
                                        <option value="SMK">SMK</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="jenis_institusi">Jenis Institusi</label>
                                    <select name="jenis_institusi" id="jenis_institusi" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="MAN">MAN</option>
                                        <option value="MAS">MAS</option>
                                        <option value="SMAN">SMAN</option>
                                        <option value="SMAS">SMAS</option>
                                        <option value="SMKN">SMKN</option>
                                        <option value="SMKS">SMKS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="jurusan_sekolah">Jurusan Sekolah</label>
                                    <input type="text" name="jurusan_sekolah" class="form-control" id="jurusan_sekolah"
                                        placeholder="Contoh: IPA, RPL" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="propinsi_institusi">Propinsi Institusi</label>
                                    <input type="text" name="propinsi_institusi" class="form-control"
                                        id="propinsi_institusi" placeholder="Contoh: DKI Jakarta" required>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="prodi_yg_diterima">Prodi yg Diterima</label>
                                    <select name="prodi_yg_diterima" id="prodi_yg_diterima" class="form-control" required>
                                        <option value="">-- Pilih Prodi --</option>
                                        <option value="S1 - Akuntansi">S1 - Akuntansi</option>
                                        <option value="S1 - Ekonomi Syari'ah">S1 - Ekonomi Syari'ah</option>
                                        <option value="S1 - Hukum Keluarga (Ahwal Syakhshiyah)">S1 - Hukum Keluarga (Ahwal Syakhshiyah)</option>
                                        <option value="S1 - Ilmu Hukum">S1 - Ilmu Hukum</option>
                                        <option value="S1 - Pendidikan Agama Islam">S1 - Pendidikan Agama Islam</option>
                                        <option value="S1 - Pendidikan Anak Usia Dini">S1 - Pendidikan Anak Usia Dini</option>
                                        <option value="S1 - Pendidikan Guru Madrasah Ibtidaiyah">S1 - Pendidikan Guru Madrasah Ibtidaiyah</option>
                                        <option value="S1 - Pendidikan/Tadris Bahasa Inggris">S1 - Pendidikan/Tadris Bahasa Inggris</option>
                                        <option value="S1 - Psikologi">S1 - Psikologi</option>
                                        <option value="S1 - Sejarah Peradaban Islam">S1 - Sejarah Peradaban Islam</option>
                                        <option value="S1 - Sistem Informasi">S1 - Sistem Informasi</option>
                                        <option value="S1 - Sosiologi">S1 - Sosiologi</option>
                                        <option value="S1 - Teknik Informatika">S1 - Teknik Informatika</option>
                                        <option value="S1 - Teknologi Agroindustri">S1 - Teknologi Agroindustri</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="klasifikasi">Klasifikasi (Label Data)</label>
                                    <select name="klasifikasi" id="klasifikasi" class="form-control" required>
                                        <option value="">-- Pilih Klasifikasi --</option>
                                        <option value="Diterima">Diterima</option>
                                        <option value="Tidak Diterima">Tidak Diterima</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="chat-windows"></div>
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/app.init.js"></script>
    <script src="dist/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!--This page plugins -->
    <script src="assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="dist/js/pages/datatable/datatable-basic.init.js"></script>

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