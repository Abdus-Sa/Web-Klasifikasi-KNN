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
                        <h4 class="page-title">Import Dataset</h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Import Dataset</li>
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
                            <div class="card-body">
                                <h4 class="card-title">Contoh Dataset</h4>
                                <h4 class="my-2"><b>NB: Susunan kolom di file (xls/xlsx) harus sama persis mengikuti
                                        format tabel
                                        berikut ini!</b></h4>
                                <div class="table-responsive">
                                    <table id="scrollhor" class="table table-striped table-bordered display"
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td align="center">1</td>
                                                <td class="text-wrap">Abdus</td>
                                                <td align="center">KIP-Kuliah Kampus A (Reguler Pagi)</td>
                                                <td align="center">1</td>
                                                <td align="center">Reguler</td>
                                                <td align="center">L</td>
                                                <td align="center">24</td>
                                                <td align="center">88.50</td>
                                                <td align="center">2019</td>
                                                <td align="center">SMK</td>
                                                <td align="center">Swasta</td>
                                                <td align="center">TKJ</td>
                                                <td align="center">Jawa Timur</td>
                                                <td align="center" class="text-wrap">Sistem Informasi</td>
                                                <td align="center">Diterima</td>
                                            </tr>
                                            <tr>
                                                <td align="center">2</td>
                                                <td class="text-wrap">Salam</td>
                                                <td align="center">Mandiri Kampus A (Ekstensi)</td>
                                                <td align="center">2</td>
                                                <td align="center">Ekstensi</td>
                                                <td align="center">P</td>
                                                <td align="center">20</td>
                                                <td align="center">82.10</td>
                                                <td align="center">2022</td>
                                                <td align="center">SMK</td>
                                                <td align="center">Swasta</td>
                                                <td align="center">TKJ</td>
                                                <td align="center">DKI Jakarta</td>
                                                <td align="center" class="text-wrap">Teknik Informatika</td>
                                                <td align="center">Tidak Diterima</td>
                                            </tr>
                                            <tr>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                                <td align="center">...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="./app/proses/import.php" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                                <input type="text" class="form-control" id="fileNameDisplay"
                                                    value="Choose file" readonly
                                                    style="background-color: white; color: #6c757d; cursor: default;">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        id="browseButton">Browse</button>
                                                </div>
                                                <input type="file" name="file_dataset" id="file_dataset" required
                                                    style="display: none;">
                                            </div>

                                            <div class="row">
                                                <div class="col-6 offset-6">
                                                    <button type="submit"
                                                        class="btn btn-rounded btn-block btn-info">Import Data</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- order table -->

                <!-- multi-column ordering -->

                <!-- complex headers -->

                <!-- DOM Positioning -->

                <!-- alternative pagination -->

                <!-- scroll-vertical -->

                <!-- scroll-vetical-dynamic height -->

                <!-- scroll horizontal -->

                <!-- scroll horizontal & vertical -->

                <!-- Language - Comma decimal place  -->

                <!-- language options -->

                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->

            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
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
        $('#browseButton').on('click', function() {
            $('#file_dataset').click();
        });

        $('#file_dataset').on('change', function() {
            let fileName = $(this).val().split('\\').pop();

            if (fileName) {
                let ext = fileName.split('.').pop().toLowerCase();
                if (ext !== 'xls' && ext !== 'xlsx') {
                    alert('File tidak didukung! Mohon hanya pilih file Excel (.xls atau .xlsx).');
                    $(this).val('');
                    $('#fileNameDisplay').val('Choose file');
                    return;
                }
            }

            $('#fileNameDisplay').val(fileName ? fileName : 'Choose file');
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