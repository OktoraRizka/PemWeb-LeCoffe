<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit();
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $queryUser = "SELECT * FROM user WHERE username = ?";
    $stmtUser = mysqli_prepare($conn, $queryUser);
    mysqli_stmt_bind_param($stmtUser, "s", $username);
    mysqli_stmt_execute($stmtUser);
    $resultUser = mysqli_stmt_get_result($stmtUser);

    if (mysqli_num_rows($resultUser) === 1) {
        $rowUser = mysqli_fetch_assoc($resultUser);
        
        if (password_verify($password, $rowUser['password'])) {
            $_SESSION['id_user'] = $rowUser['id_user'];
            
            echo "<script>
                    alert('Login Berhasil!');
                    window.location.href='../index.php';
                  </script>";
            exit();
        } else {
            $error_message = "Password yang Anda masukkan salah.";
        }
    } else {
        $error_message = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- PERBAIKAN LOGIKA: Mengubah judul agar sesuai dengan fungsi halaman -->
    <title>Login - Le Coffe</title> 
    <link rel="stylesheet" href="../Style/style.css"> 
    <style>
        h1 {
            text-align: center; 
        }
        .form-footer {
            display: flex;
            justify-content: space-between; 
            align-items: center;            
            margin-top: 20px;
            width: 100%;
        }

        #noAkun {
            font-size: 0.8rem;
            color: #666;
            text-decoration: none;
            transition: 0.3s;
        }

        #noAkun:hover {
            color: #3e2723; 
            text-decoration: underline;
        }
        
        .error-box {
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 0.9rem;
            border: 1px solid #ffcdd2;
        }
    </style>
</head>
<body>

<section class="order-container">
    <div class="order-card">
        <h1>Login Akun</h1>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-box"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <form action="" method="POST" class="order-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan Username Anda" required>
                <label id="namaError" style="color: red; font-size: 0.8rem; display: none;"></label>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password Anda" required>
                <label id="passwordHPError" style="color: red; font-size: 0.8rem; display: none;"></label>
            </div>
            
            <div class="form-footer">
                <button id="tombolCek" type="submit" class="btn-order">Masuk</button>
                <a href="signIn.php" id="noAkun">Belum punya akun?</a>
            </div>        
        </form>
    </div>
</section>

<script src="../Js/cekOrder.js"></script>

</body>
</html>