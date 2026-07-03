<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $conn->real_escape_string($_POST['name']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password !== $password_confirm) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah username sudah ada
        $check_sql = "SELECT id FROM users WHERE username = '$username'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $error = "Username sudah digunakan, silakan pilih yang lain!";
        } else {
            // Hash password dan simpan
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $insert_sql = "INSERT INTO users (username, password, name) VALUES ('$username', '$password_hash', '$name')";
            
            if ($conn->query($insert_sql) === TRUE) {
                $success = "Akun berhasil dibuat! Silakan login.";
            } else {
                $error = "Terjadi kesalahan saat membuat akun: " . $conn->error;
            }
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Register Aplikasi KNN">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/unusia.png">
    <title>Tambah Akun | Klasifikasi Penerimaan Mahasiswa Baru UNUSIA</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
        }
        .register-page {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f4f6f9;
        }
        .register-card {
            background: rgba(255, 255, 255, 1);
            padding: 40px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
            margin: 20px;
        }
        .register-card .logo {
            text-align: center;
            margin-bottom: 25px;
        }
        .register-card .logo img {
            width: 60px;
        }
        .form-control {
            background-color: #eef3f9;
            border: 1px solid #ced4da;
            color: #495057;
        }
        .form-control:focus {
            background-color: #eef3f9;
            box-shadow: none;
            border-color: #007bff;
        }
        .input-group-text {
            border: 1px solid #007bff;
        }
        .text-muted {
            font-size: 14px;
        }
    </style>
</head>

<body class="register-page">
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    
    <div class="register-card">
        <div class="logo">
            <img src="images/unusia-removebg-preview.png" alt="UNUSIA">
            <h4 class="mt-3 text-dark font-weight-bold">Tambah Akun</h4>
            <p class="text-muted">Penerimaan Mahasiswa Baru KNN</p>
        </div>
        
        <?php if(!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($success)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-white"><i class="ti-id-badge"></i></span>
                </div>
                <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" required autofocus>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-white"><i class="ti-user"></i></span>
                </div>
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-white"><i class="ti-pencil"></i></span>
                </div>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-white"><i class="ti-pencil"></i></span>
                </div>
                <input type="password" class="form-control" name="password_confirm" placeholder="Konfirmasi Password" required>
            </div>
            <div class="form-group text-center mt-4">
                <button class="btn btn-primary btn-block text-white" type="submit">Daftar</button>
            </div>
            <div class="form-group text-center mt-3 mb-0">
                <p class="text-muted mb-0">Sudah punya akun? <a href="login.php" class="text-primary font-weight-bold ml-1">Login</a></p>
            </div>
        </form>
    </div>

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <script>
        $(".preloader").fadeOut();
    </script>
</body>

</html>
