<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pesan = $_POST['pesan'];
    $file = $_FILES['file_upload']['name'];
    $tmp_name = $_FILES['file_upload']['tmp_name'];

    if ($file) {
        $upload_path = '../uploads/' . basename($file);
        move_uploaded_file($tmp_name, $upload_path);
    } else {
        $file = null;
    }

    $stmt = $conn->prepare("INSERT INTO konsultasi (user_id, pesan, file_upload) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $pesan, $file);

    if ($stmt->execute()) {
        $success = "Pesan konsultasi berhasil dikirim.";
    } else {
        $error = "Gagal mengirim pesan.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Konsultasi</title>
    <style>
    body {
        font-family: Arial;
        background: #f7f7f7;
        padding: 20px;
    }

    .box {
        background: white;
        padding: 20px;
        border-radius: 10px;
        max-width: 600px;
        margin: auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    }

    textarea,
    input[type="file"],
    button {
        width: 100%;
        margin-top: 10px;
        padding: 10px;
    }

    .msg {
        margin-top: 10px;
        color: green;
    }

    .error {
        margin-top: 10px;
        color: red;
    }
    </style>
</head>

<body>
    <div class="box">
        <h2>Konsultasi dengan Tutor</h2>
        <?php if ($success) echo "<p class='msg'>$success</p>"; ?>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" enctype="multipart/form-data">
            <textarea name="pesan" placeholder="Tulis pesan..." required></textarea>
            <input type="file" name="file_upload">
            <button type="submit">Kirim</button>
        </form>
        <br>
        <a href="riwayat_konsultasi.php">📄 Lihat Riwayat Konsultasi & Ekspor PDF</a>
    </div>
</body>

</html>