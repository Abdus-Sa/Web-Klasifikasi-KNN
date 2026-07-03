<?php
require_once 'app/helpers/auth.php';
check_login();
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
    <link href="dist/css/style.min.css?v=2" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

    <style>
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
                            <div class="card-header text-center">
                                <h4>K-Nearest Neighbor (K-NN)</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <p style="text-align: justify;">K-Nearest Neighbor (K-NN) adalah suatu metode
                                            yang menggunakan algoritma supervised dimana hasil dari query instance yang
                                            baru diklasifikan berdasarkan mayoritas dari kategori pada K-NN. Tujuan dari
                                            algoritma ini adalah mengklasifikasikan objek baru bedasarkan atribut dan
                                            training sample. Classifier tidak menggunakan model apapun untuk dicocokkan
                                            dan hanya berdasarkan pada memori. Diberikan titik query akan ditemukan
                                            sejumlah k objek atau titik training yang paling dekat dengan titik query.
                                            Klasifikasi menggunakan voting terbanyak diantara klasifikasi dari k objek.
                                            Algoritma K-NN menggunakan klasifikasi ketetanggaan sebagai nilai prediksi
                                            dari query instance yang baru.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <h4>Definisi dan Proses KNN</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <p style="font-size: 16px; font-weight: bold;">Algoritma K-Nearest Neighbors
                                            (K-NN)</p>
                                        <p style="text-align: justify;">merupakan sistem yang menggunakan klasifikasi
                                            ketetanggaan (neighbor) sebagai nilai prediksi dari query instance yang
                                            baru. Algoritma ini sederhana, bekerja berdasarkan jarak terpendek dari
                                            query instance ke training sample untuk menentukan ketetanggaannya.
                                            Keunggulan utama algoritma K-Nearest Neighbor (K-NN) adalah kesederhanaan
                                            dan kemudahan implementasinya, fleksibilitas dan adaptasi terhadap data
                                            baru, serta kemampuannya untuk menangkap interaksi kompleks antar variabel
                                            tanpa memerlukan model statistik yang rumit.</p>
                                    </div>
                                    <div class="col-6 d-flex align-items-center justify-content-center">
                                        <img src="images/gambar_knn.jfif" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <h4>Langkah Langkah Algortima KNN</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <p style="font-weight: bold;">Ringkasan :</p>

                                        <ol style="text-align: justify;">
                                            <li>Menentukan parameter k (jumlah tetangga paling dekat).</li>

                                            <li>Menghitung selisih absolut (jarak manhattan) objek terhadap data training yang
                                                diberikan.</li>

                                            <li>Mengurutkan hasil no 2 secara ascending (berurutan dari nilai tinggi ke
                                                rendah).</li>

                                            <li>Mengumpulkan kategori Y (Klasifikasi nearest neighbor berdasarkan nilai
                                                k).</li>

                                            <li>Dengan menggunakan kategori nearest neighbor yang paling mayoritas maka
                                                dapat dipredisikan kategori objek.</li>
                                        </ol>
                                        <p style="text-align: justify;">Algoritma k-NN mengklasifikasikan data baru dengan mengukur jaraknya ke seluruh data latih, kemudian menentukan hasil klasifikasinya berdasarkan kelas mayoritas dari sejumlah <em>k</em> tetangga terdekat.</p>
                                    </div>
                                    <div class="col-4 d-flex justify-content-center align-items-center flex-column">
                                        <p class="mb-0" style="font-weight: bold;">Rumus KNN</p>
                                        <img src="images/rumus_knn_manhattan.svg" style="width: 80%; margin-top: 15px;" alt="Rumus KNN Manhattan">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


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
    <!--This page JavaScript -->
    <script src="assets/libs/jquery.repeater/jquery.repeater.min.js"></script>
    <script src="assets/extra-libs/jquery.repeater/repeater-init.js"></script>
    <script src="assets/extra-libs/jquery.repeater/dff.js"></script>

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