<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'siswa') {
    header("Location: ../login.php");
    exit;
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

$success = $error = "";

// Proses upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] === 0) {
        $targetDir = "../uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($_FILES["bukti"]["name"]);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];

        if (in_array($fileType, $allowedTypes)) {
            $newFileName = "bukti_" . $user_id . "_" . time() . "." . $fileType;
            $targetFilePath = $targetDir . $newFileName;

            if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $targetFilePath)) {
                $conn->query("INSERT INTO bukti_pembayaran (user_id, filename) VALUES ($user_id, '$newFileName')");
                $success = "Bukti pembayaran berhasil diunggah.";
            } else {
                $error = "Gagal mengunggah file.";
            }
        } else {
            $error = "Format file tidak didukung (hanya jpg, jpeg, png, pdf).";
        }
    } else {
        $error = "Silakan pilih file untuk diunggah.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Upload Bukti Pembayaran</title>
    <style>
        body {
            font-family: Arial;
            padding: 40px;
            background-color: #f0f2f5;
        }

        .container {
            background-color: white;
            max-width: 700px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="file"] {
            width: 100%;
            margin-bottom: 15px;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        a.back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #555;
            text-decoration: none;
        }

        a.back:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Upload Bukti Pembayaran</h2>

        <?php if ($success) echo "<div class='message success'>$success</div>"; ?>
        <?php if ($error) echo "<div class='message error'>$error</div>"; ?>

        <form method="POST" enctype="multipart/form-data">
            <label for="bukti">Pilih File (jpg, jpeg, png, pdf):</label>
            <input type="file" name="bukti" required>
            <button type="submit">Upload</button>
        </form>

        <hr>
        <h3>Riwayat Upload Anda</h3>
        <table>
            <tr>
                <th>No</th>
                <th>Nama File</th>
                <th>Tanggal Upload</th>
                <th>Lihat File</th>
            </tr>
            <?php
            $no = 1;
            $result = $conn->query("SELECT * FROM bukti_pembayaran WHERE user_id = $user_id ORDER BY tanggal_upload DESC");

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $no++ . "</td>
                            <td>" . htmlspecialchars($row['filename']) . "</td>
                            <td>" . $row['tanggal_upload'] . "</td>
                            <td><a href='../uploads/" . htmlspecialchars($row['filename']) . "' target='_blank'>Lihat</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Belum ada bukti pembayaran.</td></tr>";
            }
            ?>
        </table>

        <a class="back" href="dashboard.php">← Kembali ke Dashboard</a>
    </div>
</body>

</html>
