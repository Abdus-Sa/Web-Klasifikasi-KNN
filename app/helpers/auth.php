<?php
require_once __DIR__ . '/../../vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function check_login() {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>
            const getUrl = window.location;
            const baseUrl = getUrl.protocol + '//' + getUrl.host + '/' + getUrl.pathname.split('/')[1];
            window.location.href = baseUrl + '/login.php';
        </script>";
        exit;
    }
}
