<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Cek input kosong
    if (empty($username) || empty($password)) {
        header("Location: login.php?error=Username atau Password tidak boleh kosong");
        exit();
    }

    // Ambil user dari database
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah user ditemukan
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect sesuai role
            switch ($user['role']) {
                case 'direktur':
                    header("Location: dashboard_direktur.php");
                    break;
                case 'vp':
                    header("Location: dashboard_vp.php");
                    break;
                case 'manager':
                    header("Location: dashboard_manager.php");
                    break;
                case 'secretary':
                case 'sekretaris': // Tambahkan ini jika masih ada data lama
                    header("Location: dashboard_secretary.php");
                    break;
                case 'staff':
                    header("Location: dashboard_staff.php");
                    break;
                default:
                    header("Location: login.php?error=Role tidak dikenali");
            }
            exit();
        } else {
            header("Location: login.php?error=Password salah");
            exit();
        }
    } else {
        header("Location: login.php?error=Username tidak ditemukan");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
