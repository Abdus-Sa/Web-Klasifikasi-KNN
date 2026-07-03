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
    <link rel="icon" type="image/png" sizes="16x16" href="images/unusia.png">
    <title>Login | Klasifikasi Penerimaan Mahasiswa Baru UNUSIA</title>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
        }
        .login-page {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f6f9;
        }
        .login-card {
            background: rgba(255, 255, 255, 1);
            padding: 40px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-card .logo {
            text-align: center;
            margin-bottom: 25px;
        }
        .login-card .logo img {
            width: 120px;
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

<body class="login-page">
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    
    <div class="login-card">
        <div class="logo">
            <img src="images/unusia-removebg-preview.png" alt="UNUSIA">
            <h4 class="mt-3 text-dark font-weight-bold">Web Klasifikasi</h4>
            <p class="text-muted">Penerimaan Mahasiswa Baru UNUSIA</p>
        </div>
        
        <?php if(!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-white"><i class="ti-user"></i></span>
                </div>
                <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-white"><i class="ti-pencil"></i></span>
                </div>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group text-center mt-4">
                <button class="btn btn-primary btn-block text-white" type="submit">Login</button>
            </div>
            <div class="form-group text-center mt-3 mb-0">
                <p class="text-muted mb-0">Belum punya akun? <a href="register.php" class="text-primary font-weight-bold ml-1">Tambah Akun</a></p>
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
