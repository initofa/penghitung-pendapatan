<?php
session_start();

// Inisialisasi total pendapatan jika belum ada
if (!isset($_SESSION['totalPendapatan'])) {
    $_SESSION['totalPendapatan'] = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['tambahPendapatan'])) {
        tambahPendapatan();
    }
}

function tambahPendapatan() {
    $pendapatanInput = floatval($_POST["pendapatan"]) ?? 0;

    if ($pendapatanInput > 0) {
        $_SESSION['totalPendapatan'] += $pendapatanInput;

        // Tambahkan pendapatan ke daftar dengan tanggal
        $_SESSION['listPendapatan'][] = [
            'tanggal' => date('Y-m-d'),
            'jumlah' => $pendapatanInput
        ];
    } else {
        echo '<script>alert("Masukkan jumlah pendapatan yang valid.")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penghitung Pendapatan dalam Sebulan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #3498db;
            color: #fff;
            padding: 10px; /* mengurangi padding */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .form-container {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #ecf0f1;
        }

        input {
            padding: 8px;
            margin-bottom: 10px;
            width: 70%;
            border: 1px solid #3498db;
            border-radius: 4px;
        }

        button {
            padding: 8px;
            cursor: pointer;
            background-color: #2ecc71;
            color: #fff;
            border: none;
            border-radius: 4px;
        }

        button:hover {
            background-color: #27ae60;
        }

        .pendapatan-container {
            margin-top: 20px;
            color: #ecf0f1;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
        }

        .total-container {
            margin-top: 20px;
        }

        h1, h2, p {
            color: #ecf0f1;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Penghitung Pendapatan dalam Sebulan</h1>
        <div class="form-container">
            <form method="post" action="">
                <label for="pendapatan">Pendapatan perhari:</label>
                <input type="number" name="pendapatan" placeholder="Masukkan pendapatan...">
                <button type="submit" name="tambahPendapatan">Tambah</button>
            </form>

            <div class="pendapatan-container">
                <h2>Daftar Pendapatan perhari</h2>
                <ul>
                    <?php
                    $counter = 1;
                    foreach ($_SESSION['listPendapatan'] as $pendapatan) {
                        echo '<li>' . $counter . '. ' . $pendapatan['tanggal'] . ' - Rp ' . number_format($pendapatan['jumlah'], 3) . '</li>';
                        $counter++;
                        if ($counter > 30) break; // Hanya tampilkan 30 entri
                    }
                    ?>
                </ul>
            </div>

            <div class="total-container">
                <h2>Total Pendapatan Bulan Ini:</h2>
                <p>Rp <?= number_format($_SESSION['totalPendapatan'], 3) ?></p>
            </div>
        </div>
    </div>
</body>
</html>
