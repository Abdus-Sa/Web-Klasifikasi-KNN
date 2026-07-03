<?php

require_once __DIR__ . '/app/init.php';
require_once __DIR__ . '/app/helpers/auth.php';
check_login();

// bersihkanHasilHitungDariSession();

$data = ambilSemuaDataHasilHitung();

$dataHasilHitung = [];

$semuaData = ambilSemuaDataset();
$n = count($semuaData);

$hitungDone = true;

if (adaHasilHitung()) {
    $hitungDone = true;
    $dataSession = ambilSemuaHasilDariSession();
    $dataHasilHitung = $dataSession["hasil_hitung"];
    $nilaiK = $dataSession["nilai_k"];
    $klasifikasi = strtolower($dataSession["klasifikasi_yang_terpilih"]);
} else {
    $hitungDone = false;
    // echo "<script>
    //         alert('Maaf, aktivitas ini tidak diizinkan!')
    //         const getUrl = window.location;
    //         const baseUrl = getUrl .protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
    //         window.location.href = baseUrl + '/index.php';
    //     </script>";
    // die;
}

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
            padding: 6px 4px;
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
    <style>
        #formHitung {
            display: none;
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
                        <h4 class="page-title">Hasil Hitung</h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Hasil Hitung</li>
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
                                <button type="button" id="btnHitungData" class="btn btn-sm btn-primary">
                                    Hitung Data
                                </button>
                                <a href="./app/proses/export_excel.php" class="btn btn-sm btn-success ml-2" target="_blank">
                                    <i class="fas fa-file-excel mr-1"></i> Export ke Excel
                                </a>

                                <form id="formHitung" action="./app/proses/hitung.php" class="mt-3" method="POST">
                                    <hr>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                                <label for="nama">Nama</label>
                                                <input type="text" name="nama" class="form-control" placeholder="Nama Calon Mahasiswa Baru"
                                                    id="nama" required>
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
                                                    <option value="2027">2027</option> 
                                                    <option value="2026">2026</option>
                                                    <option value="2025">2025</option>
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
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="tetanggaTerdekat">Tetangga Terdekat (k):</label>
                                                <input type="number" min="1" name="tetangga_terdekat" class="form-control"
                                                    id="tetanggaTerdekat" required>
                                                <small id="passwordHelpBlock" class="form-text text-muted">
                                                    Disarankan untuk tidak melebihi setengah dari total dataset (yaitu <?= $n; ?>) dan
                                                    sebaiknya ganjil.
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary cta mt-3">Hitung</button>
                                </form>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">List Hasil Hitung</h4>
                                <div class="table-responsive">
                                     <table id="zero_config" class="table table-striped table-bordered display"
                                        style="width:100%">
                                        <thead class="thead-light">
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
                                                <th class="text-center" style="background-color: #d1ecf1;">Nilai K</th>
                                                <th class="text-center" style="background-color: #d1ecf1;">Hasil Jarak Terdekat</th>
                                                <th class="text-center" style="background-color: #d4edda;">Klasifikasi</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($data) > 0) : ?>
                                                
                                                <?php $no1 = 1; foreach ($data as $row) : ?>
                                                    <tr>
                                                        <td class="text-center"><?= $no1++; ?></td>
                                                        <td class="text-wrap"><?= $row['nama'] ?></td>
                                                        <td class="text-center"><?= $row['jalur_pendaftaran'] ?></td>
                                                        <td class="text-center"><?= $row['gelombang'] ?></td>
                                                        <td class="text-center"><?= $row['sistem_kuliah'] ?></td>
                                                        <td class="text-center"><?= $row['l_p'] ?></td>
                                                        <td class="text-center"><?= $row['usia'] ?></td>
                                                        <td class="text-center"><?= $row['nilai_lulusan'] ?></td>
                                                        <td class="text-center"><?= $row['tahun_lulus'] ?></td>
                                                        <td class="text-center"><?= $row['jenjang_pendidikan'] ?></td>
                                                        <td class="text-center"><?= $row['jenis_institusi'] ?></td>
                                                        <td class="text-center"><?= $row['jurusan_sekolah'] ?></td>
                                                        <td class="text-center"><?= $row['propinsi_institusi'] ?></td>
                                                        <td class="text-center"><?= $row['prodi_yg_diterima'] ?></td>
                                                        <td class="text-center" style="background-color: #e2e3e5;">
                                                            <b><?= $row['nilai_k'] ?></b>
                                                        </td>
                                                        <td class="text-center" style="background-color: #e2e3e5;">
                                                            <?= $row['jarak_hasil'] ?></td>
                                                        <td class="text-center"
                                                            style="background-color: #c3e6cb; font-weight: bold;"><?= $row['klasifikasi'] ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <form action="./app/proses/hitung.php" method="POST" class="mb-1" onsubmit="return confirm('Proses ini akan menghitung ulang data ini dan menampilkan detail K terdekatnya. Lanjutkan?')">
                                                                <input type="hidden" name="recalc_id" value="<?= $row['id'] ?>">
                                                                <input type="hidden" name="nama" value="<?= $row['nama'] ?>">
                                                                <input type="hidden" name="jalur_pendaftaran" value="<?= $row['jalur_pendaftaran'] ?>">
                                                                <input type="hidden" name="gelombang" value="<?= $row['gelombang'] ?>">
                                                                <input type="hidden" name="sistem_kuliah" value="<?= $row['sistem_kuliah'] ?>">
                                                                <input type="hidden" name="l_p" value="<?= $row['l_p'] ?>">
                                                                <input type="hidden" name="usia" value="<?= $row['usia'] ?>">
                                                                <input type="hidden" name="nilai_lulusan" value="<?= $row['nilai_lulusan'] ?>">
                                                                <input type="hidden" name="tahun_lulus" value="<?= $row['tahun_lulus'] ?>">
                                                                <input type="hidden" name="jenjang_pendidikan" value="<?= $row['jenjang_pendidikan'] ?>">
                                                                <input type="hidden" name="jenis_institusi" value="<?= $row['jenis_institusi'] ?>">
                                                                <input type="hidden" name="jurusan_sekolah" value="<?= $row['jurusan_sekolah'] ?>">
                                                                <input type="hidden" name="propinsi_institusi" value="<?= $row['propinsi_institusi'] ?>">
                                                                <input type="hidden" name="prodi_yg_diterima" value="<?= $row['prodi_yg_diterima'] ?>">
                                                                <input type="number" name="tetangga_terdekat" value="<?= $row['nilai_k'] ?>" class="form-control form-control-sm text-center w-100 mb-1" style="border-radius: 0; padding: 2px;" min="1" required title="Ubah nilai K">
                                                                <button type="submit" class="btn btn-sm btn-info w-100" style="border-radius: 0; padding: 4px;" title="Hitung ulang dengan nilai K ini">Hitung Ulang</button>
                                                            </form>
                                                            <a href="./app/proses/hapus.php?id=<?= $row['id'] ?>&type=hasil_hitung" role="button"
                                                                class="btn btn-sm btn-danger w-100" style="border-radius: 0; padding: 4px;"
                                                                onclick="return confirm('Yakin ingin menghapus riwayat hitung ini?')">Hapus</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="17" class="text-center">Belum ada riwayat hasil perhitungan K-NN.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row <?= (!$hitungDone) ? "d-none" :  "" ?>">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-center">Hasil Perhitungan Klasifikasi Penerimaan Mahasiswa Baru UNUSIA</h4>
                            </div>
                            <div class="card-body">
                                <h4>Kesimpulan</h4>
                                <p>Nilai K : <span class="badge badge-primary"><?= $nilaiK; ?></span></p>
                                <p>Klasifikasi : 
                                    <?php
                                    if ($klasifikasi == 'diterima' || $klasifikasi == 'layak') {
                                        echo '<span class="badge badge-success">' . ucfirst($klasifikasi) . '</span>';
                                    } else if ($klasifikasi == 'ditolak' || $klasifikasi == 'tidak layak') {
                                        echo '<span class="badge badge-danger">' . ucfirst($klasifikasi) . '</span>';
                                    } else if ($klasifikasi == 'cadangan') {
                                        echo '<span class="badge badge-warning">' . ucfirst($klasifikasi) . '</span>';
                                    } else {
                                        echo '<span class="badge badge-primary">' . ucfirst($klasifikasi) . '</span>';
                                    }
                                    ?>
                                </p>

                                <h4 class="my-2"><b><?= $nilaiK; ?> Tetangga Terdekat : </b></h4>

                                <div class="table-responsive">
                                    <table id="complex_header" class="table table-striped table-bordered display"
                                        style="width:100%">
                                        <thead class="thead-light">
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
                                                <th class="text-center" style="background-color: #d1ecf1;">Nilai K</th>
                                                <th class="text-center" style="background-color: #d1ecf1;">Hasil Jarak Terdekat</th>
                                                <th class="text-center" style="background-color: #d4edda;">Klasifikasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!isset($dataHasilHitung) || $dataHasilHitung === null || empty($dataHasilHitung)) { ?>
                                            <tr>
                                                <th colspan="15" style="padding: 1rem; text-align: center;">Tidak ada data hasil
                                                    hitung</th>
                                            </tr>
                                            <?php } else { ?>
                                            <?php $i = 1; $no2 = 1; ?>
                                            <?php foreach ($dataHasilHitung as $data) : ?>
                                            <?php if ($i > $nilaiK) {
                                                        break; // Diubah dari return menjadi break agar tidak menghentikan seluruh script di bawah tabel
                                                    } ?>

                                            <?php $jarakHasilYangTerformat = number_format($data->getJarakHasil(), 5, '.', ''); ?>
                                            <tr>
                                                <td class="text-center"><?= $no2++; ?></td>
                                                <td class="text-wrap"><?= $data->get('nama'); ?></td>
                                                <td align="center"><?= $data->get('jalur_pendaftaran'); ?></td>
                                                <td align="center"><?= $data->get('gelombang'); ?></td>
                                                <td align="center"><?= $data->get('sistem_kuliah'); ?></td>
                                                <td align="center"><?= $data->get('l_p'); ?></td>
                                                <td align="center"><?= $data->get('usia'); ?></td>
                                                <td align="center"><?= $data->get('nilai_lulusan'); ?></td>
                                                <td align="center"><?= $data->get('tahun_lulus'); ?></td>
                                                <td align="center"><?= $data->get('jenjang_pendidikan'); ?></td>
                                                <td align="center"><?= $data->get('jenis_institusi'); ?></td>
                                                <td align="center"><?= $data->get('jurusan_sekolah'); ?></td>
                                                <td align="center"><?= $data->get('propinsi_institusi'); ?></td>
                                                <td align="center"><?= $data->get('prodi_yg_diterima'); ?></td>

                                                <td align="center" style="background-color: #e2e3e5; font-weight:bold;"><?= $nilaiK; ?></td>
                                                <td align="center" class="highlight fw-bold"><?= $jarakHasilYangTerformat; ?></td>

                                                <td align="center">
                                                    <?php
                                                            $klasifikasiTabel = strtolower($data->get('klasifikasi'));
                                                            if ($klasifikasiTabel == 'diterima' || $klasifikasiTabel == 'layak') {
                                                                echo '<span class="badge badge-success">' . ucfirst($data->get('klasifikasi')) . '</span>';
                                                            } else if ($klasifikasiTabel == 'ditolak' || $klasifikasiTabel == 'tidak layak') {
                                                                echo '<span class="badge badge-danger">' . ucfirst($data->get('klasifikasi')) . '</span>';
                                                            } else if ($klasifikasiTabel == 'cadangan') {
                                                                echo '<span class="badge badge-warning">' . ucfirst($data->get('klasifikasi')) . '</span>';
                                                            } else {
                                                                echo '<span class="badge badge-primary">' . ucfirst($data->get('klasifikasi')) . '</span>';
                                                            }
                                                            ?>
                                                </td>

                                            </tr>
                                            <?php $i++; ?>
                                            <?php endforeach; ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>

    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
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

    <script>
        $(document).ready(function() {
            $("#btnHitungData").click(function() {
                $("#formHitung").slideToggle(500);
            });
        });
    </script>

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