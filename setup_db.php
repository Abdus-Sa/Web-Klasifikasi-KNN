<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully.\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

$password_hash = password_hash('admin123', PASSWORD_DEFAULT);
$sql_insert = "INSERT INTO `users` (`username`, `password`, `name`) SELECT 'admin', '$password_hash', 'Administrator' WHERE NOT EXISTS (SELECT * FROM `users` WHERE `username` = 'admin')";

if ($conn->query($sql_insert) === TRUE) {
    echo "Default user inserted successfully.\n";
} else {
    echo "Error inserting user: " . $conn->error . "\n";
}

$conn->close();
