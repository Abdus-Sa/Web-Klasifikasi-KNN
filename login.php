<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, name FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
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
    <meta name="description" content="Login Aplikasi KNN">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/unusia_512x512.png">
    <title>Login | Klasifikasi Penerimaan Mahasiswa Baru UNUSIA</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-page {
            background-color: #f0f2f5;
            background-image: url('images/bg.png');
            background-repeat: repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        
        .login-container {
            display: flex;
            width: 85%;
            max-width: 900px;
            height: 70vh;
            min-height: 580px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .login-left {
            flex: 1;
            background: url('images/kampus.png') no-repeat center center;
            background-size: cover;
            position: relative;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 40px;
        }

        /* Gradient overlay to make text readable */
        .login-left::before {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.1) 100%);
            z-index: 1;
        }

        .login-left-content {
            position: relative;
            z-index: 2;
        }

        .login-left-content h5 {
            color: #a3e635; /* hijau pupus / lime */
            font-weight: 600;
            margin-bottom: 5px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .login-left-content h2 {
            font-weight: 700;
            font-size: 22px;
            line-height: 1.4;
            margin: 0;
            color: #ffffff;
        }

        .login-right {
            width: 400px;
            padding: 20px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #fff;
        }

        .login-right .logo {
            text-align: center;
            margin-bottom: -10px;
        }
        .login-right .logo img {
            width: 160px;
        }

        .login-right h4 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            color: #1F262D;
        }
        .login-right .subtext {
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .form-control {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px 15px;
            font-size: 14px;
            color: #495057;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #0056b3;
            box-shadow: none;
            outline: none;
        }

        .forgot-password {
            display: block;
            text-align: right;
            font-size: 13px;
            margin-top: -10px;
            margin-bottom: 20px;
            color: #0056b3;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-login {
            background: #0056b3;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            font-weight: bold;
            width: 100%;
            margin-bottom: 20px;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-login:hover {
            background: #004494;
        }

        .register-link {
            text-align: center;
            font-size: 13px;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
                width: 90%;
            }
            .login-left {
                min-height: 250px;
            }
            .login-right {
                width: 100%;
            }
        }
    </style>
</head>

<body class="login-page">
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    
    <div class="login-container">
        <!-- Sisi Kiri: Gambar Kampus & Teks -->
        <div class="login-left">
            <div class="login-left-content">
                <h2>Sistem Klasifikasi Penerimaan Mahasiswa Baru Universitas Nahdlatul Ulama Indonesia</h2>
            </div>
        </div>
        
        <!-- Sisi Kanan: Form Login -->
        <div class="login-right">
            <div class="logo">
                <img src="images/unusia-removebg-preview.png" alt="UNUSIA">
            </div>
            <h4>Login</h4>
            <p class="subtext">Silakan masukkan email dan password Anda untuk mengakses Sistem Klasifikasi Penerimaan Mahasiswa Baru Universitas Nahdlatul Ulama Indonesia berbasis K-Nearest Neighbor (KNN).</p>
            
            <?php if(!empty($error)): ?>
                <div class="alert alert-danger" role="alert" style="font-size: 13px; padding: 10px; text-align: center;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group mb-3">
                    <label>Email/akun pengguna<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                </div>
                <div class="form-group mb-3">
                    <label>Password<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                
                <button class="btn-login" type="submit">Login</button>
                
                <div class="register-link">
                    Belum punya akun? <a href="register.php" class="text-primary font-weight-bold">Tambah Akun</a>
                </div>
            </form>
        </div>
    </div>

    <!-- All Jquery -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <script>
        $(".preloader").fadeOut();
    </script>
</body>

</html>