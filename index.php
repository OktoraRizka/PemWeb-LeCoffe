<?php
session_start();
include 'php/koneksi.php';

if (!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
    header("Location: php/login.php");
    exit();
}

$user_id = $_SESSION['id_user'];

$query = "SELECT * FROM coffe";
$result = mysqli_query($conn, $query);

$queryUser = "SELECT * FROM user WHERE id_user = ?";
$stmtUser = mysqli_prepare($conn, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $user_id);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$rowUser = mysqli_fetch_assoc($resultUser);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Coffe.</title>
    <link rel="stylesheet" href="Style/style.css">
    <style>
        header .navbar a#btnLogin {
        background-color: #3e2723; 
        color: #ffffff;          
        padding: 8px 20px;       
        border-radius: 5px;                   
        display: inline-block;               
        margin-left: 20px;
        font-weight: bold;
        text-decoration: none;    
        transition: 0.3s;
        }

        /* Efek Hover */
        header .navbar a#btnLogin:hover {
            background-color: #5d4037; 
            color: #ffffff;
            text-decoration: none;   
        }
    </style>
</head>
<body id="top">

<header>
    <a href="#top" class="logo">Le coffee.</a>
    
    <nav class="navbar">
        <a href="#top">home</a>
        <a href="#foto-kopi">about</a>
        <a href="#menu">Katalog</a> 
        <a href="#contact">contact</a>
        <a href="php/order.php" id="btnLogin">Order</a>
        <a href="php/logout.php">Logout</a>
    </nav>

</header>

<section class="home" style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('images/home-bg.jpg') center/cover;
">
    <div class="content">
        <h3>Hi <?php echo $rowUser['username'] ?></h3>
        <span>start your day with a coffee</span>
        <p>Nikmati perpaduan biji kopi pilihan dengan suasana yang menenangkan. Kami menyajikan kebahagiaan dalam setiap cangkir untuk menemani produktivitas Anda.</p>
        <a href="php/order.php" class="btn">ORDER NOW</a>
    </div>
</section>


<section class="foto-kopi" id="foto-kopi">
    <div class="jenis-kopi">
        <img src="images/art1.jpg" class="kopi-img" alt="foto1">
        <img src="images/art2.jpg" class="kopi-img" alt="foto1">
        <img src="images/art3.jpg" class="kopi-img" alt="foto1">
    </div>

    <div>
        <h1>About Le Coffe.</h1>
        <p>"Lebih dari sekadar kafe, Le Coffe. adalah teman setia pagi Anda. Kami memadukan kualitas rasa premium dengan suasana nyaman untuk menciptakan pengalaman minum kopi yang tak terlupakan."</p>
    </div>
</section>

<table border="1" id="menu">
    <caption>Katalog Le coffe.</caption>
    <thead>
        <tr>
            <th>Jenis</th>
            <th>Satuan</th>
            <th>harga</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
       <?php 
            if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['jenis'] . "</td>";
                echo "<td>" . $row['satuan'] . "</td>";
                // Mengformat angka harga agar rapi (Rp 165.000)
                echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                echo "<td>" . $row['keterangan'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' style='text-align:center;'>Belum ada data kopi.</td></tr>";
        }
       ?>
    </tbody>
</table>

<footer class="kopi-footer" id="contact">
    <div class="footer-container">
        <div class="footer-section">
            <h2>Le Coffe.</h2>
            <p>Menyajikan kehangatan di setiap cangkir sejak 2024. Temukan ketenangan dalam aroma kopi pilihan kami.</p>
        </div>

        <div class="footer-section">
            <h3>Contact Us</h3>
            <ul>
                <li>Jl. Pramuka No. 10, Mataram</li>
                <li>+62 812 345 678</li>
                <li>lecoffe@gmail.com</li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Jam Operasional</h3>
            <p>Senin - Jumat: 09:00 - 22:00</p>
            <p>Sabtu - Minggu: 10:00 - 23:00</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2026 Le Coffe. All rights reserved.</p>
    </div>
</footer>

</body>
</html>