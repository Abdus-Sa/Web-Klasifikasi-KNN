<?php

require_once __DIR__ . '/app/init.php';
require_once __DIR__ . '/app/helpers/auth.php';
check_login();

if (isset($_GET["id"])) {
    $data = ambilDataBerdasarkanId($_GET["id"]);
} else {
    echo "<script>
            alert('Maaf, aktivitas ini tidak diizinkan!')
            const getUrl = window.location;
            const baseUrl = getUrl .protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
            window.location.href = baseUrl + '/dataset.php';
        </script>";
    die;
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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

    <style>
    /* Ubah teks menjadi hitam */
    body,
    .page-wrapper,
    p,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    label,
    .card-title,
    .breadcrumb-item,
    .breadcrumb-item.active,
    td,
    th,
    li {
        color: #000;
    }

    /* Responsive logo */
    .navbar-brand img {
        transition: all 0.3s ease;
    }

    #main-wrapper.mini-sidebar .navbar-brand img,
    #main-wrapper[data-sidebartype="mini-sidebar"] .navbar-brand img {
        width: 55px !important;
    }

    /* Sidebar Styling */
    .left-sidebar,
    .sidebar-nav,
    #sidebarnav,
    .scroll-sidebar {
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
    .sidebar-nav ul .sidebar-item.selected>.sidebar-link {
        background: rgba(0, 0, 0, 0.08) !important;
        color: #000 !important;
        opacity: 1 !important;
    }

    .sidebar-nav ul .sidebar-item.selected>.sidebar-link i,
    .sidebar-nav ul .sidebar-item .sidebar-link:hover i {
        color: #000 !important;
    }
    </style>
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
                    <div class="navbar-brand"
                        style="display: flex; justify-content: center; align-items: center; width: 100%; min-height: 64px;">
                        <a href="index.php" style="text-decoration: none;">
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <img src="images/unusia-removebg-preview.png" alt="homepage"
                                    style="width: 80px; max-width: 100%;" />
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
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"
                                style="font-size: 24px; color: #1F262D; display: flex; align-items: center; height: 100%; padding-right: 20px;">
                                <span class="mdi mdi-menu"></span>
                            </a>
                        </li>
                        <h4
                            style="flex: 1; text-align: center; margin: 0; align-self: center; font-size: 16px; padding-right: 40px; font-weight: bold; color: #1F262D !important;">
                            Sistem Klasifikasi Penerimaan Mahasiswa Baru Universitas Nahdlatul Ulama Indonesia
                            (UNUSIA)<br>Menggunakan Metode K-Nearest Neighbor (K-NN)</h4>

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
                        <h4 class="page-title">Edit Dataset</h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit DataSet</li>
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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Form Edit Dataset</h3>
                            </div>
                            <div class="card-body">
                                <form action="./app/proses/edit.php" method="POST">
                                    <input type="number" hidden name="id" value="<?= $data['id']; ?>" required>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Nama Calon Mahasiswa" id="nama" name="nama"
                                                    value="<?= $data['nama']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="jalur_pendaftaran">Jalur Pendaftaran</label>
                                                <select name="jalur_pendaftaran" id="jalur_pendaftaran"
                                                    class="form-control" required>
                                                    <option value="">-- Pilih --</option>
                                                    <option value="KIP-Kuliah kampus A (Reguler Pagi)"
                                                        <?= ($data['jalur_pendaftaran'] == 'KIP-Kuliah kampus A (Reguler Pagi)') ? 'selected' : ''; ?>>
                                                        KIP-Kuliah kampus A (Reguler Pagi)</option>
                                                    <option value="KIP-Kuliah kampus B (Reguler Pagi)"
                                                        <?= ($data['jalur_pendaftaran'] == 'KIP-Kuliah kampus B (Reguler Pagi)') ? 'selected' : ''; ?>>
                                                        KIP-Kuliah kampus B (Reguler Pagi)</option>
                                                    <option value="Mandiri S1 kampus A (Ekstensi)"
                                                        <?= ($data['jalur_pendaftaran'] == 'Mandiri S1 kampus A (Ekstensi)') ? 'selected' : ''; ?>>
                                                        Mandiri S1 kampus A (Ekstensi)</option>
                                                    <option value="Mandiri S1 kampus A (Reguler Pagi)"
                                                        <?= ($data['jalur_pendaftaran'] == 'Mandiri S1 kampus A (Reguler Pagi)') ? 'selected' : ''; ?>>
                                                        Mandiri S1 kampus A (Reguler Pagi)</option>
                                                    <option value="Mandiri S1 kampus B (Ekstensi)"
                                                        <?= ($data['jalur_pendaftaran'] == 'Mandiri S1 kampus B (Ekstensi)') ? 'selected' : ''; ?>>
                                                        Mandiri S1 kampus B (Ekstensi)</option>
                                                    <option value="Mandiri S1 kampus B (Reguler Pagi)"
                                                        <?= ($data['jalur_pendaftaran'] == 'Mandiri S1 kampus B (Reguler Pagi)') ? 'selected' : ''; ?>>
                                                        Mandiri S1 kampus B (Reguler Pagi)</option>
                                                    <option value="NU Leader Future Kampus B (Reguler Pagi)"
                                                        <?= ($data['jalur_pendaftaran'] == 'NU Leader Future Kampus B (Reguler Pagi)') ? 'selected' : ''; ?>>
                                                        NU Leader Future Kampus B (Reguler Pagi)</option>
                                                    <option value="PBSB Sarjana (Reguler Pagi)"
                                                        <?= ($data['jalur_pendaftaran'] == 'PBSB Sarjana (Reguler Pagi)') ? 'selected' : ''; ?>>
                                                        PBSB Sarjana (Reguler Pagi)</option>
                                                    <option value="Penjaringan Transmigrasi Kampus B (Reguler Pagi)"
                                                        <?= ($data['jalur_pendaftaran'] == 'Penjaringan Transmigrasi Kampus B (Reguler Pagi)') ? 'selected' : ''; ?>>
                                                        Penjaringan Transmigrasi Kampus B (Reguler Pagi)</option>
                                                    <option value="Pertamina Sobat Bumi (Reguler Pagi)"
                                                        <?= ($data['jalur_pendaftaran'] == 'Pertamina Sobat Bumi (Reguler Pagi)') ? 'selected' : ''; ?>>
                                                        Pertamina Sobat Bumi (Reguler Pagi)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="gelombang">Gelombang</label>
                                                <select name="gelombang" id="gelombang" class="form-control" required>
                                                    <option value="">-- Pilih --</option>
                                                    <option value="GELOMBANG 1"
                                                        <?= ($data['gelombang'] == 'GELOMBANG 1') ? 'selected' : '' ?>>
                                                        Gelombang 1</option>
                                                    <option value="GELOMBANG 2"
                                                        <?= ($data['gelombang'] == 'GELOMBANG 2') ? 'selected' : '' ?>>
                                                        Gelombang 2</option>
                                                    <option value="GELOMBANG 3"
                                                        <?= ($data['gelombang'] == 'GELOMBANG 3') ? 'selected' : '' ?>>
                                                        Gelombang 3</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="sistem_kuliah">Sistem Kuliah</label>
                                                <select name="sistem_kuliah" id="sistem_kuliah" class="form-control"
                                                    required>
                                                    <option value="">-- Pilih --</option>
                                                    <option value="Ekstensi"
                                                        <?= ($data['sistem_kuliah'] == 'Ekstensi') ? 'selected' : ''; ?>>
                                                        Ekstensi</option>
                                                    <option value="Reguler Pagi"
                                                        <?= ($data['sistem_kuliah'] == 'Reguler Pagi') ? 'selected' : ''; ?>>
                                                        Reguler Pagi</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="l_p">L/P</label>
                                                <select name="l_p" id="l_p" class="form-control" required>
                                                    <option value="">-- Pilih --</option>
                                                    <option value="L" <?= ($data['l_p'] == 'L') ? 'selected' : ''; ?>>L
                                                    </option>
                                                    <option value="P" <?= ($data['l_p'] == 'P') ? 'selected' : ''; ?>>P
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="usia">Usia</label>
                                                <input type="number" min="0" name="usia" class="form-control" id="usia"
                                                    value="<?= $data['usia'] ?? ''; ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="nilai_lulusan">Nilai Lulusan</label>
                                                <input type="number" step="any" min="0" name="nilai_lulusan"
                                                    class="form-control" id="nilai_lulusan"
                                                    value="<?= $data['nilai_lulusan'] ?? ''; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="tahun_lulus">Tahun Lulus</label>
                                                <select name="tahun_lulus" class="form-control" id="tahun_lulus"
                                                    required>
                                                    <option value="">-- Pilih --</option>
                                                    <option value="2024"
                                                        <?= ($data['tahun_lulus'] == '2024') ? 'selected' : ''; ?>>2024
                                                    </option>
                                                    <option value="2023"
                                                        <?= ($data['tahun_lulus'] == '2023') ? 'selected' : ''; ?>>2023
                                                    </option>
                                                    <option value="2022"
                                                        <?= ($data['tahun_lulus'] == '2022') ? 'selected' : ''; ?>>2022
                                                    </option>
                                                    <option value="2021"
                                                        <?= ($data['tahun_lulus'] == '2021') ? 'selected' : ''; ?>>2021
                                                    </option>
                                                    <option value="2020"
                                                        <?= ($data['tahun_lulus'] == '2020') ? 'selected' : ''; ?>>2020
                                                    </option>
                                                    <option value="2019"
                                                        <?= ($data['tahun_lulus'] == '2019') ? 'selected' : ''; ?>>2019
                                                    </option>
                                                    <option value="2018"
                                                        <?= ($data['tahun_lulus'] == '2018') ? 'selected' : ''; ?>>2018
                                                    </option>
                                                    <option value="2017"
                                                        <?= ($data['tahun_lulus'] == '2017') ? 'selected' : ''; ?>>2017
                                                    </option>
                                                    <option value="2016"
                                                        <?= ($data['tahun_lulus'] == '2016') ? 'selected' : ''; ?>>2016
                                                    </option>
                                                    <option value="2015"
                                                        <?= ($data['tahun_lulus'] == '2015') ? 'selected' : ''; ?>>2015
                                                    </option>
                                                    <option value="2014"
                                                        <?= ($data['tahun_lulus'] == '2014') ? 'selected' : ''; ?>>2014
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="jenjang_pendidikan">Jenjang Pendidikan</label>
                                                <select name="jenjang_pendidikan" id="jenjang_pendidikan"
                                                    class="form-control" required>
                                                    <option value="">-- Pilih --</option>
                                                    <option value="MA"
                                                        <?= ($data['jenjang_pendidikan'] == 'MA') ? 'selected' : ''; ?>>
                                                        MA</option>
                                                    <option value="SMA"
                                                        <?= ($data['jenjang_pendidikan'] == 'SMA') ? 'selected' : ''; ?>>
                                                        SMA</option>
                                                    <option value="SMK"
                                                        <?= ($data['jenjang_pendidikan'] == 'SMK') ? 'selected' : ''; ?>>
                                                        SMK</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="jenis_institusi">Jenis Institusi</label>
                                                <select name="jenis_institusi" id="jenis_institusi" class="form-control"
                                                    required>
                                                    <option value="">-- Pilih --</option>
                                                    <option value="MAN"
                                                        <?= ($data['jenis_institusi'] == 'MAN') ? 'selected' : ''; ?>>
                                                        MAN</option>
                                                    <option value="MAS"
                                                        <?= ($data['jenis_institusi'] == 'MAS') ? 'selected' : ''; ?>>
                                                        MAS</option>
                                                    <option value="SMAN"
                                                        <?= ($data['jenis_institusi'] == 'SMAN') ? 'selected' : ''; ?>>
                                                        SMAN</option>
                                                    <option value="SMAS"
                                                        <?= ($data['jenis_institusi'] == 'SMAS') ? 'selected' : ''; ?>>
                                                        SMAS</option>
                                                    <option value="SMKN"
                                                        <?= ($data['jenis_institusi'] == 'SMKN') ? 'selected' : ''; ?>>
                                                        SMKN</option>
                                                    <option value="SMKS"
                                                        <?= ($data['jenis_institusi'] == 'SMKS') ? 'selected' : ''; ?>>
                                                        SMKS</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="jurusan_sekolah">Jurusan Sekolah</label>
                                                <input type="text" name="jurusan_sekolah" class="form-control"
                                                    id="jurusan_sekolah" placeholder="Contoh: IPA, RPL"
                                                    value="<?= $data['jurusan_sekolah'] ?? ''; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="propinsi_institusi">Propinsi Institusi</label>
                                                <input type="text" name="propinsi_institusi" class="form-control"
                                                    id="propinsi_institusi" placeholder="Contoh: DKI Jakarta"
                                                    value="<?= $data['propinsi_institusi'] ?? ''; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="prodi_yg_diterima">Prodi yg Diterima</label>
                                                <select name="prodi_yg_diterima" id="prodi_yg_diterima"
                                                    class="form-control" required>
                                                    <option value="">-- Pilih Prodi --</option>
                                                    <option value="S1 - Akuntansi"
                                                        <?= ($data['prodi_yg_diterima'] == 'S1 - Akuntansi') ? 'selected' : ''; ?>>
                                                        S1 - Akuntansi</option>
                                                    <option value="S1 - Ekonomi Syari'ah"
                                                        <?= ($data['prodi_yg_diterima'] == "S1 - Ekonomi Syari'ah") ? 'selected' : ''; ?>>
                                                        S1 - Ekonomi Syari'ah</option>
                                                    <option value="S1 - Hukum Keluarga (Ahwal Syakhshiyah)"
                                                        <?= ($data['prodi_yg_diterima'] == 'S1 - Hukum Keluarga (Ahwal Syakhshiyah)') ? 'selected' : ''; ?>>
                                                        S1 - Hukum Keluarga (Ahwal Syakhshiyah)</option>
                                                    <option value="S1 - Ilmu Hukum"
                                                        <?= ($data['prodi_yg_diterima'] == 'S1 - Ilmu Hukum') ? 'selected' : ''; ?>>
                                                        S1 - Ilmu Hukum</option>
                                                    <option value="S1 - Pendidikan Agama Islam"
                                                        <?= ($data['prodi_yg_diterima'] == 'S1 - Pendidikan Agama Islam') ? 'selected' : ''; ?>>
                                                        S1 - Pendidikan Agama Islam</option>
                                                    <option value="S1 - Pendidikan Anak Usia Dini"
                                                        <?= ($data['prodi_yg_diterima'] == 'S1 - Pendidikan Anak Usia Dini') ? 'selected' : ''; ?>>
                                                        S1 - Pendidikan Anak Usia Dini</option>
                                                    <option value="S1 - Pendidikan Guru Madrasah Ibtidaiyah"
                                                        <?= ($data['prodi_yg_diterima'] == 'S1 - Pendidikan Guru Madrasah Ibtidaiyah') ? 'selected' : ''; ?>>
                                                        S1 - Pendidikan Guru Madrasah Ibtidaiyah</option>
                                                    <option value="S1 - Pendidikan/Tadris Bahasa Inggris"
                                                        <?= ($data['prodi_yg_diterima'] == 'S1 - Pendidikan/Tadris Bahasa Inggris') ? 'selected' : ''; ?>>
                                                        S1 - Pendidikan/Tadris Bahasa Inggris</option>
                                                    <option value="S1 - Psikologi"
                                                        <?= ($data['prodi_yg_diterima'] == 'S1 - Psikologi') ? 'selected' : ''; ?>>
                                                        S1 - Psikologi</option>
                                                    <option value="S1 - Sejarah Peradaban Islam"
                                                        <?= ($data['prodi_yg_diterima'] == 'S1 - Sejarah Peradaban Islam') ? 'selected' : ''; ?>>
                                                        S1 - Sejarah Peradaban Islam</option>
                                                    <option value="S1 - Sistem Informasi"
                                                        <?= ($data['prodi_yg_diterima'] == 'S1 - Sistem Informasi') ? 'selected' : ''; ?>>
                                                        S1 - Sistem Informasi</option>
                                                    <option value="S1 - Sosiologi"
                                                        <?= ($data['prodi_yg_diterima'] == 'S1 - Sosiologi') ? 'selected' : ''; ?>>
                                                        S1 - Sosiologi</option>
                                                    <option value="S1 - Teknik Informatika"
                                                        <?= ($data['prodi_yg_diterima'] == 'S1 - Teknik Informatika') ? 'selected' : ''; ?>>
                                                        S1 - Teknik Informatika</option>
                                                    <option value="S1 - Teknologi Agroindustri"
                                                        <?= ($data['prodi_yg_diterima'] == 'S1 - Teknologi Agroindustri') ? 'selected' : ''; ?>>
                                                        S1 - Teknologi Agroindustri</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="klasifikasi" class="form-label">Klasifikasi (Hasil
                                                    Akhir):</label>
                                                <select name="klasifikasi" id="klasifikasi" class="form-control"
                                                    style="max-width: 300px;" required>
                                                    <option value="">-- Pilih Hasil Klasifikasi --</option>
                                                    <option value="DITERIMA"
                                                        <?= (isset($data['klasifikasi']) && $data['klasifikasi'] == 'DITERIMA') ? 'selected' : '' ?>>
                                                        DITERIMA</option>
                                                    <option value="DITOLAK"
                                                        <?= (isset($data['klasifikasi']) && $data['klasifikasi'] == 'DITOLAK') ? 'selected' : '' ?>>
                                                        DITOLAK</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex " style="gap: 5px;">
                                        <button type="submit" class="btn btn-primary cta">Ubah</button>
                                        <a href="./dataset.php" class="btn btn-secondary cta">Kembali</a>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

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
                var isMini = wrapper.getAttribute('data-sidebartype') === 'mini-sidebar' || wrapper
                    .classList.contains('mini-sidebar');
                img.style.setProperty('width', isMini ? '65px' : '80px', 'important');
                img.style.setProperty('max-width', isMini ? 'none' : '100%', 'important');
                img.style.setProperty('transform', isMini ? 'scale(1.2)' : 'scale(1)', 'important');
                img.style.setProperty('transition', 'width 0.3s ease');
            };

            var observer = new MutationObserver(updateLogoSize);
            observer.observe(wrapper, {
                attributes: true,
                attributeFilter: ['data-sidebartype', 'class']
            });

            // Initial check
            updateLogoSize();
        }
    });
    </script>
</body>

</html>