<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Koneksi ke database
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "sertifikat_online";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mencari pengguna berdasarkan username
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Jika berhasil, simpan sesi dan redirect ke halaman user dashboard
            $_SESSION['user'] = $username;
            header("Location: user_dashboard.php");
            exit();
        } else {
            // Jika password salah, tampilkan pesan error
            echo "<script>alert('Password salah. Silakan coba lagi.');</script>";
        }
    } else {
        // Jika username tidak ditemukan, tampilkan pesan error
        echo "<script>alert('Username tidak ditemukan. Silakan coba lagi.');</script>";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="../assets/css/login_user.css">
</head>
<body>
    <div class="container">
        <h2>User Login</h2>
        <form action="login_user.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="../register/register_user.php">Register</a></p>
    </div>
</body>
</html>

