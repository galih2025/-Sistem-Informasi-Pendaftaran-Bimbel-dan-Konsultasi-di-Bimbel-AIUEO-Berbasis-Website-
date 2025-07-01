<?php
session_start();
require_once 'config/db.php';

$error = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id'];

        // Arahkan berdasarkan role
        if ($user['role'] === 'siswa') {
            header("Location: siswa/dashboard.php");
        } elseif ($user['role'] === 'tutor') {
            header("Location: tutor/dashboard.php");
        } elseif ($user['role'] === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            $error = "Role tidak dikenal.";
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Bimbel</title>
    <style>
    body {
        font-family: Arial;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: #e0e0e0;
    }

    .box {
        background: white;
        padding: 30px;
        width: 350px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    input,
    button {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
    }

    button {
        background: #007BFF;
        color: white;
        border: none;
    }

    a {
        text-decoration: none;
        color: #007BFF;
    }
    </style>
</head>

<body>
    <div class="box">
        <h2>Login Akun Bimbel</h2>
        <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
        <?php if (isset($_GET['berhasil'])) echo "<p style='color:green;'>Pendaftaran berhasil, silakan login.</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Masuk</button>
        </form>
        <p>Belum punya akun? <a href="daftar.php">Daftar di sini</a></p>
    </div>
</body>

</html>