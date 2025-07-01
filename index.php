<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Bimbel & Login</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f0f0f0;
        display: flex;
        justify-content: center;
        padding: 50px;
    }

    .container {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        width: 400px;
    }

    input,
    select,
    button {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        font-size: 14px;
    }

    h2 {
        text-align: center;
        margin-bottom: 10px;
    }

    hr {
        margin: 30px 0;
    }

    .error {
        color: red;
        text-align: center;
        margin-bottom: 10px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Daftar Bimbel</h2>

        <?php if (isset($_SESSION['error'])): ?>
        <p class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <form action="proses/daftar.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required>
            <input type="password" name="password" placeholder="Password" required>
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

            <input type="hidden" name="role" value="siswa">

            <button type="submit">Daftar Sekarang</button>
        </form>

        <hr>

        <h2>Login</h2>
        <form action="proses/login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>