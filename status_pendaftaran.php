<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Ambil data pendaftaran
$query = $conn->prepare("SELECT * FROM pendaftaran WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$pendaftaran = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Status Pendaftaran</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', sans-serif;
        background-color: #f1f2f6;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background: #ffffff;
        padding: 40px 30px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 450px;
        width: 90%;
    }

    h2 {
        margin-bottom: 25px;
        color: #2f3542;
    }

    p {
        margin: 12px 0;
        font-size: 16px;
        color: #333;
    }

    .label {
        font-weight: 600;
        color: #57606f;
    }

    .status-belum {
        color: #e84118;
        font-weight: bold;
    }

    .status-sudah {
        color: #2ecc71;
        font-weight: bold;
    }

    .btn {
        display: inline-block;
        margin-top: 25px;
        background-color: #3498db;
        color: #ffffff;
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #2980b9;
    }
    </style>
</head>

<body>

    <div class="container">
        <h2>Status Pendaftaran</h2>
        <p><span class="label">Nama Pengguna:</span> <?= htmlspecialchars($username) ?></p>

        <?php if ($pendaftaran): ?>
        <p><span class="label">Status Pendaftaran:</span> <span class="status-sudah">Sudah Mendaftar</span></p>
        <p><span class="label">Tanggal Daftar:</span> <?= date('d M Y', strtotime($pendaftaran['tanggal_daftar'])) ?>
        </p>
        <?php else: ?>
        <p><span class="label">Status Pendaftaran:</span> <span class="status-belum">Belum Mendaftar</span></p>
        <p><span class="label">Tanggal Daftar:</span> -</p>
        <?php endif; ?>

        <a class="btn" href="dashboard.php">🔙 Kembali ke Dashboard</a>
    </div>

</body>

</html>