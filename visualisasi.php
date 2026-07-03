<?php
require_once __DIR__ . '/app/init.php';
require_once __DIR__ . '/app/helpers/auth.php';
check_login();

$dataAkurasi = ambilDataAkurasi();
$dataMatrix = ambilDataConfusionMatrix();
$semuaData = ambilSemuaDataset();
$totalDataset = count($semuaData);

// Siapkan data untuk Chart.js (Line Chart)
$labels_k = [];
$data_akurasi = [];
$keteranganRasio = "80% Latih / 20% Uji"; // Default jika kosong
foreach ($dataAkurasi as $row) {
    $labels_k[] = "K" . $row['nilai_k'];
    $data_akurasi[] = $row['nilai_akurasi'];
    if (!empty($row['keterangan'])) {
        $keteranganRasio = $row['keterangan'];
    }
}

// Transformasi Confusion Matrix menjadi format matriks 2x2
// Asumsi kelas: Diterima & Tidak Diterima
$matrix = [
    'Diterima' => ['Diterima' => 0, 'Tidak Diterima' => 0],
    'Tidak Diterima' => ['Diterima' => 0, 'Tidak Diterima' => 0]
];
$totalTest = 0;
foreach ($dataMatrix as $row) {
    if (isset($matrix[$row['kelas_asli']][$row['kelas_prediksi']])) {
        $matrix[$row['kelas_asli']][$row['kelas_prediksi']] = $row['jumlah_data'];
        $totalTest += $row['jumlah_data'];
    }
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Model Visualisasi KNN">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/unusia.png">
    <title>Model Visualisasi | Klasifikasi Penerimaan Mahasiswa Baru UNUSIA</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css?v=2" rel="stylesheet">
    <!-- Chart.js CSS (Opsional) -->
    <style>
        .heatmap-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }
        .heatmap-table th, .heatmap-table td {
            border: 1px solid #dee2e6;
            padding: 15px;
            font-size: 16px;
        }
        .heatmap-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        /* Heatmap colors based on intensity */
        .heat-high { background-color: #28a745; color: white; } /* True Positives/Negatives (High) */
        .heat-med { background-color: #ffc107; color: black; } /* False Positives/Negatives (Medium) */
        .heat-low { background-color: #dc3545; color: white; } /* Errors (High) */
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
    <!-- Preloader -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    
    <div id="main-wrapper">
        <!-- Topbar header -->
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
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav float-left mr-auto" style="width: 100%;">
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar" style="font-size: 24px; color: #1F262D; display: flex; align-items: center; height: 100%; padding-right: 20px;">
                                <span class="mdi mdi-menu"></span>
                            </a>
                        </li>
                        <h4 style="flex: 1; text-align: center; margin: 0; align-self: center; font-size: 16px; padding-right: 40px; font-weight: bold; color: #1F262D !important;">Sistem Klasifikasi Penerimaan Mahasiswa Baru Universitas Nahdlatul Ulama Indonesia (UNUSIA)<br>Menggunakan Metode K-Nearest Neighbor (K-NN)</h4>
                    </ul>
                    <ul class="navbar-nav float-right">
                        
                    </ul>
                </div>
            </nav>
        </header>
        
        <!-- Left Sidebar -->
        <aside class="left-sidebar">
            <div class="scroll-sidebar">
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
            </div>
        </aside>
        
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Model Visualisasi</h4>
                    </div>
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Model Visualisasi</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Container fluid  -->
            <div class="container-fluid">
                
                <?php if(isset($_GET['success']) && $_GET['success'] == 'evaluasi'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Evaluasi model telah selesai dijalankan berdasarkan data terbaru.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif; ?>

                <?php if(isset($_GET['success']) && $_GET['success'] == 'hapus_gambar'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil!</strong> Gambar Python berhasil dihapus. Grafik bawaan website kini ditampilkan kembali.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif; ?>

                <?php if(isset($_GET['error']) && $_GET['error'] == 'nodata'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> Data tidak cukup untuk dievaluasi (minimal 10 data). Silakan <b>Import Dataset</b> asli Anda terlebih dahulu.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php endif; ?>

                <div class="row mb-3">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <form action="./app/proses/upload_gambar.php" method="POST" enctype="multipart/form-data" class="form-inline">
                            <label for="gambar_visualisasi" class="mr-2 font-weight-bold"><i class="fas fa-image text-success mr-1"></i> Import Gambar:</label>
                            <input type="file" name="gambar_visualisasi[]" id="gambar_visualisasi" class="form-control-file form-control-sm mr-2" accept="image/*" multiple required style="max-width: 200px;">
                            <button type="submit" class="btn btn-success btn-sm" title="Upload Gambar">
                                <i class="fas fa-upload"></i>
                            </button>
                        </form>

                        <form action="./app/proses/trigger_evaluasi.php" method="GET" class="form-inline" onsubmit="return confirm('Proses ini akan mengevaluasi ulang model K-NN berdasarkan rasio yang dipilih. Proses ini mungkin memakan waktu beberapa saat. Lanjutkan?')">
                            <label for="rasio" class="mr-2 font-weight-bold">Rasio Data:</label>
                            <select name="rasio" id="rasio" class="form-control form-control-sm mr-2 shadow-sm" style="min-width: 200px;">
                                <option value="0.9">90% Latih / 10% Uji</option>
                                <option value="0.8" selected>80% Latih / 20% Uji (Standar)</option>
                                <option value="0.75">75% Latih / 25% Uji</option>
                                <option value="0.7">70% Latih / 30% Uji</option>
                                <option value="0.6">60% Latih / 40% Uji</option>
                                <option value="0.5">50% Latih / 50% Uji</option>
                            </select>
                            <button type="submit" class="btn btn-warning btn-sm shadow-sm">
                                <i class="fas fa-sync-alt mr-1"></i> Mulai Evaluasi Ulang
                            </button>
                        </form>
                    </div>
                </div>

                <?php 
                $uploaded_images = glob("uploads/visualisasi_*.*");
                ?>
                
                <?php if (!empty($uploaded_images)): ?>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                <h4 class="mb-0 text-white"><i class="fas fa-image mr-1"></i> Gambar Visualisasi Python</h4>
                                <a href="./app/proses/hapus_gambar_visualisasi.php" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus gambar Python dan menampilkan kembali grafik asli bawaan sistem?')">
                                    <i class="fas fa-trash-alt mr-1"></i> Tampilkan Grafik Asli
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <?php foreach($uploaded_images as $img): ?>
                                        <div class="col-md-6 col-lg-6 text-center mb-4">
                                            <img src="<?= $img ?>?t=<?= time() ?>" alt="Visualisasi" class="img-fluid rounded shadow" style="max-width: 100%; height: auto; max-height: 500px;">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (empty($uploaded_images)): ?>
                <div class="row">
                    <!-- Line Chart Col -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 mb-0">
                            <div class="card-header bg-info">
                                <h4 class="mb-0 text-white">Grafik Akurasi vs Nilai K <small>(Berdasarkan <?= $keteranganRasio; ?>)</small></h4>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div style="position: relative; height: 350px; width: 100%;">
                                    <canvas id="akurasiChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Confusion Matrix Col -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 mb-0">
                            <div class="card-header bg-success">
                                <h4 class="mb-0 text-white">Confusion Matrix (Heatmap)</h4>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center">
                                <div class="table-responsive">
                                    <table class="heatmap-table">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" colspan="2" style="background: transparent; border: none;"></th>
                                                <th colspan="2">Kelas Prediksi</th>
                                            </tr>
                                            <tr>
                                                <th>Diterima</th>
                                                <th>Tidak Diterima</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th rowspan="2" style="vertical-align: middle;">Kelas Asli</th>
                                                <th>Diterima</th>
                                                <td class="heat-high">
                                                    <h2><?= $matrix['Diterima']['Diterima'] ?></h2>
                                                    <small>True Positive</small>
                                                </td>
                                                <td class="heat-med">
                                                    <h2><?= $matrix['Diterima']['Tidak Diterima'] ?></h2>
                                                    <small>False Negative</small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Tidak Diterima</th>
                                                <td class="heat-med">
                                                    <h2><?= $matrix['Tidak Diterima']['Diterima'] ?></h2>
                                                    <small>False Positive</small>
                                                </td>
                                                <td class="heat-high">
                                                    <h2><?= $matrix['Tidak Diterima']['Tidak Diterima'] ?></h2>
                                                    <small>True Negative</small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    <p class="text-muted text-center" style="font-size: 13px;">Tabel di atas memvisualisasikan perbandingan antara kelas asli pada dataset dengan kelas yang diprediksi oleh model K-NN.</p>
                                    <p class="text-info text-center" style="font-weight: bold; font-size: 13px;">Evaluasi ini dihitung berdasarkan <?= $keteranganRasio; ?> (Total Data Uji: <?= $totalTest ?> dari <?= $totalDataset ?> total dataset)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <!-- End Container fluid  -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    
    <div class="chat-windows"></div>
    
    <!-- All Jquery -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
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
    
    <!-- Chart.js Library & Datalabels Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    
    <script>
        $(document).ready(function() {
            // Data dari PHP ke Javascript Array
            var labelsK = <?php echo json_encode($labels_k); ?>;
            var dataAkurasi = <?php echo json_encode($data_akurasi); ?>;
            
            Chart.register(ChartDataLabels);
            var ctx = document.getElementById('akurasiChart').getContext('2d');
            var akurasiChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labelsK,
                    datasets: [{
                        label: 'Persentase Akurasi (%) - <?= $keteranganRasio; ?>',
                        data: dataAkurasi,
                        backgroundColor: 'rgba(30, 136, 229, 0.2)', // Info color with opacity
                        borderColor: '#1e88e5',
                        borderWidth: 3,
                        pointBackgroundColor: '#1e88e5',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#1e88e5',
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: {
                            align: 'bottom',
                            color: '#1e88e5',
                            font: {
                                weight: 'bold',
                                size: 12
                            },
                            formatter: function(value) {
                                return value + '%';
                            }
                        },
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            suggestedMin: 40,
                            suggestedMax: 100,
                            title: {
                                display: true,
                                text: 'Akurasi (%)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Nilai K'
                            }
                        }
                    }
                }
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
