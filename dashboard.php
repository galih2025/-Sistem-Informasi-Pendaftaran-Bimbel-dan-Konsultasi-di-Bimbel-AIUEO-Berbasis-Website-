<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Cek apakah user sudah daftar
$cekPendaftaran = $conn->prepare("SELECT * FROM pendaftaran WHERE user_id = ?");
$cekPendaftaran->bind_param("i", $user_id);
$cekPendaftaran->execute();
$result = $cekPendaftaran->get_result();
$sudah_daftar = $result->num_rows > 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa</title>
    <style>
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(to right, #74ebd5, #9face6);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .dashboard {
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 90%;
        max-width: 500px;
    }

    .dashboard h2 {
        margin-bottom: 10px;
    }

    .dashboard p {
        margin-bottom: 20px;
        color: #555;
    }

    .menu {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .menu a {
        display: block;
        background: #4CAF50;
        color: white;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 10px;
        transition: background 0.3s ease;
        font-size: 16px;
    }

    .menu a:hover {
        background: #45a049;
    }

    .logout {
        margin-top: 25px;
        background: #f44336 !important;
    }

    .logout:hover {
        background: #d73833 !important;
    }

    .status {
        font-weight: bold;
        margin-bottom: 20px;
    }

    .status.sudah {
        color: green;
    }

    .status.belum {
        color: red;
    }
    </style>
</head>

<body>
    <div class="dashboard">
        <h2>Selamat Datang, <?= htmlspecialchars($username) ?> 👋</h2>
        <p>Silakan akses fitur berikut:</p>

        <?php if ($sudah_daftar): ?>
        <p class="status sudah">Status: Sudah Mendaftar ✅</p>
        <?php else: ?>
        <p class="status belum">Status: Belum Mendaftar ❌</p>
        <?php endif; ?>

        <div class="menu">
            <a href="status_pendaftaran.php">📄 Status Pendaftaran</a>
            <a href="upload_bukti.php">💳 Upload Bukti Bayar</a>
            <a href="konsultasi.php">💬 Konsultasi</a>
            <a href="jadwal_konsultasi.php">📆 Jadwal Konsultasi</a>
            <a href="riwayat_pendaftaran.php">📋 Riwayat Pendaftaran</a>
            <a href="../logout.php" class="logout">🔓 Logout</a>
        </div>
    </div>
</body>

</html>