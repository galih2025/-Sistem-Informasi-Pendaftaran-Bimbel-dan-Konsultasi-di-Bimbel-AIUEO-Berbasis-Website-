<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$data = [];

$query = "SELECT paket_bimbel, tanggal_daftar, status_pembayaran FROM pendaftaran WHERE user_id = $user_id";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Pendaftaran & Pembayaran</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f1f4f9;
        padding: 40px;
    }

    .container {
        max-width: 800px;
        margin: auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 25px;
    }

    table th,
    table td {
        padding: 12px;
        border-bottom: 1px solid #ccc;
        text-align: center;
    }

    table th {
        background: #4CAF50;
        color: white;
    }

    .btn-kembali {
        display: inline-block;
        padding: 10px 20px;
        background: #888;
        color: white;
        text-decoration: none;
        border-radius: 6px;
    }

    .btn-kembali:hover {
        background: #555;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Riwayat Pendaftaran & Pembayaran</h2>

        <table>
            <tr>
                <th>Paket</th>
                <th>Tanggal Pendaftaran</th>
                <th>Status Pembayaran</th>
            </tr>
            <?php if (!empty($data)): ?>
            <?php foreach ($data as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d['paket_bimbel']) ?></td>
                <td><?= htmlspecialchars($d['tanggal_daftar']) ?></td>
                <td><?= htmlspecialchars($d['status_pembayaran']) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="3">Belum ada riwayat pendaftaran.</td>
            </tr>
            <?php endif; ?>
        </table>

        <a href="dashboard.php" class="btn-kembali">⬅ Kembali</a>
    </div>
</body>

</html>