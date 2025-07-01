<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = $conn->query("SELECT * FROM konsultasi WHERE user_id = $user_id ORDER BY tanggal_konsultasi DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Konsultasi</title>
    <style>
    body {
        font-family: Arial;
        background: #f4f4f4;
        padding: 20px;
    }

    .box {
        max-width: 800px;
        margin: auto;
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        margin-bottom: 20px;
    }

    .item {
        background: #fafafa;
        padding: 15px;
        border-left: 5px solid #4CAF50;
        margin-bottom: 15px;
        border-radius: 6px;
    }

    .balasan {
        color: green;
        font-style: italic;
        margin-top: 10px;
    }

    .belum {
        color: red;
        font-style: italic;
    }

    .notif {
        color: #d35400;
        font-weight: bold;
    }

    .file-lampiran {
        margin-top: 5px;
    }

    .file-lampiran a {
        color: #2980b9;
        text-decoration: none;
    }

    .kembali-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 15px;
        background-color: #3498db;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.2s ease;
    }

    .kembali-btn:hover {
        background-color: #2980b9;
    }
    </style>
</head>

<body>
    <div class="box">
        <h2>Riwayat Konsultasi</h2>
        <?php while ($row = $query->fetch_assoc()): ?>
        <div class="item">
            <strong>Pesan:</strong><br>
            <?= nl2br(htmlspecialchars($row['pesan'])) ?><br>
            <small><em>Dikirim: <?= htmlspecialchars($row['tanggal_konsultasi']) ?></em></small>

            <?php if (!empty($row['file'])): ?>
            <div class="file-lampiran">📎 <a href="../uploads/<?= $row['file'] ?>" target="_blank">Lihat Lampiran</a>
            </div>
            <?php endif; ?>

            <?php if (!empty($row['balasan'])): ?>
            <div class="balasan">💬 Balasan Tutor: <?= nl2br(htmlspecialchars($row['balasan'])) ?></div>
            <?php else: ?>
            <div class="belum">⏳ Belum dibalas</div>
            <?php endif; ?>

            <?php if ($row['status_konsultasi'] === 'Sudah Dibalas'): ?>
            <div class="notif">🔔 Anda memiliki balasan baru!</div>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>

        <a href="dashboard.php" class="kembali-btn">← Kembali ke Dashboard</a>
    </div>
</body>

</html>