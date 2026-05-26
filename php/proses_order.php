<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $jenis_kopi        = isset($_POST['jenis_kopi']) ? trim($_POST['jenis_kopi']) : '';
    $jumlah            = isset($_POST['jumlah']) ? intval($_POST['jumlah']) : 0;
    $metode_pembayaran = isset($_POST['metode_pembayaran']) ? trim($_POST['metode_pembayaran']) : '';
    
    $total_harga       = isset($_POST['total_harga']) ? floatval($_POST['total_harga']) : 0.0;
    
    if (empty($jenis_kopi) || $jumlah <= 0 || empty($metode_pembayaran) || $total_harga <= 0) {
        echo "<script>
                alert('Data order tidak valid!');
                window.location.href='order.php';
              </script>";
        exit();
    }

    $queryInsert = "INSERT INTO orders (jenis_kopi, jumlah, metode_pembayaran, total_harga) VALUES (?, ?, ?, ?)";
    $stmtInsert  = mysqli_prepare($conn, $queryInsert);
    
    mysqli_stmt_bind_param($stmtInsert, "sisd", $jenis_kopi, $jumlah, $metode_pembayaran, $total_harga);

    if (mysqli_stmt_execute($stmtInsert)) {
        echo "<script>
                alert('Pesanan sukses dibuat! Total Bayar: Rp " . number_format($total_harga, 0, ',', '.') . "');
                window.location.href='../index.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Gagal menyimpan pesanan ke database.');
                window.location.href='order.php';
              </script>";
        exit();
    }
} else {
    header("Location: order.php");
    exit();
}
?>