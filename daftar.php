<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_hp = $_POST['no_hp'];
    $paket_bimbel = $_POST['paket_bimbel'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    // Simpan ke tabel users
    $stmt1 = $conn->prepare("INSERT INTO users (username, password, nama_lengkap, role, no_hp) VALUES (?, ?, ?, 'siswa', ?)");
    $stmt1->bind_param("ssss", $username, $password, $nama_lengkap, $no_hp);
    
    if ($stmt1->execute()) {
        $user_id = $stmt1->insert_id;

        // Simpan ke tabel pendaftaran
        $stmt2 = $conn->prepare("INSERT INTO pendaftaran (user_id, paket_bimbel, metode_pembayaran) VALUES (?, ?, ?)");
        $stmt2->bind_param("iss", $user_id, $paket_bimbel, $metode_pembayaran);
        $stmt2->execute();

        header("Location: login.php?berhasil=1");
        exit;
    } else {
        echo "Gagal mendaftar. Coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Daftar Bimbel</title>
    <style>
    body {
        font-family: Arial;
        padding: 40px;
        background: #f4f4f4;
    }

    form {
        background: white;
        padding: 20px;
        border-radius: 10px;
        width: 400px;
        margin: auto;
        box-shadow: 0 0 10px #ccc;
    }

    input,
    select,
    button {
        width: 100%;
        margin: 10px 0;
        padding: 10px;
    }

    button {
        background: #28a745;
        color: white;
        border: none;
    }
    </style>
</head>

<body>
    <form method="POST">
        <h2>Formulir Pendaftaran Bimbel</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required>
        <input type="text" name="no_hp" placeholder="Nomor HP" required>

        <select name="paket_bimbel" required>
            <option value="">-- Pilih Paket --</option>
            <option value="Reguler">Reguler</option>
            <option value="Intensif">Intensif</option>
        </select>

        <select name="metode_pembayaran" required>
            <option value="">-- Metode Pembayaran --</option>
            <option value="Transfer Bank">Transfer Bank</option>
            <option value="E-wallet">E-wallet</option>
            <option value="Bayar di Tempat">Bayar di Tempat</option>
        </select>

        <button type="submit">Daftar Sekarang</button>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </form>
</body>

</html>