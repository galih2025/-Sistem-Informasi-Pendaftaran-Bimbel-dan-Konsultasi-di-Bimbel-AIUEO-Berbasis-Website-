<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data user berdasarkan username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verifikasi password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id'];

        // Arahkan ke dashboard berdasarkan role
        if ($user['role'] === 'siswa') {
            header("Location: siswa/dashboard.php");
        } elseif ($user['role'] === 'tutor') {
            header("Location: tutor/dashboard.php");
        } elseif ($user['role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            $_SESSION['error'] = "Role tidak dikenali.";
            header("Location: login.php");
        }
        exit;
    } else {
        $_SESSION['error'] = "Username atau password salah!";
        header("Location: login.php");
        exit;
    }
}
?>