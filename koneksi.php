<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "work_activity_ho"; // database yang digunakan

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
