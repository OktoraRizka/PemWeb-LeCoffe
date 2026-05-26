<?php
session_start();
include 'koneksi.php'; 

if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit();
}

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $alamat   = mysqli_real_escape_string($conn, $_POST['alamat']);

    $cekUser = "SELECT * FROM user WHERE username = ?";
    $stmtCek = mysqli_prepare($conn, $cekUser);
    mysqli_stmt_bind_param($stmtCek, "s", $username);
    mysqli_stmt_execute($stmtCek);
    $resultCek = mysqli_stmt_get_result($stmtCek);

    if (mysqli_num_rows($resultCek) > 0) {
        $error_message = "Username sudah digunakan, silakan pilih nama lain.";
    } else {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $queryInsert = "INSERT INTO user (username, email, password, alamat) VALUES (?, ?, ?, ?)";
        $stmtInsert  = mysqli_prepare($conn, $queryInsert);
        mysqli_stmt_bind_param($stmtInsert, "ssss", $username, $email, $password_hashed, $alamat);

        if (mysqli_stmt_execute($stmtInsert)) {
            echo "<script>
                    alert('Pendaftaran Berhasil! Silakan Login.');
                    window.location.href='login.php';
                  </script>";
            exit();
        } else {
            $error_message = "Gagal mendaftarkan akun. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Le Coffe</title>
    <link rel="stylesheet" href="../Style/style.css"> 
    <style>
        h1 {
            text-align: center; 
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
        .form-footer-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 0.85rem;
            color: #666;
            text-decoration: none;
        }
        .form-footer-link:hover {
            color: #3e2723;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<section class="order-container">
    <div class="order-card">
        <h1>Registrasi</h1>

        <?php if (!empty($error_message)): ?>
            <div class="error-box"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="" method="POST" class="order-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukan Nama Anda" required>
                <label id="namaError">.</label>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan Email Anda" required>
                <label id="emailEr">.</label>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password Anda" required>
                <label id="passwordEr">.</label>
            </div>
            
            <div class="form-group">
                <label for="alamat">Alamat Pengiriman</label>
                <textarea id="alamat" name="alamat" rows="4" placeholder="Tulis Alamat Lengkap Anda" required></textarea>
                <label id="alamatError">.</label>
            </div>

            <button type="submit" id="tombolCek" class="btn-order">Daftar Akun</button>   
            
            <a href="login.php" class="form-footer-link">Sudah punya akun? Login di sini</a>
        </form>
    </div>
</section>

</body>
</html>