<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    // Jika belum, redirect ke halaman login
    header("Location: login_user.php");
    exit();
}

// Di sini Anda dapat menambahkan logika lain yang relevan dengan halaman dasbor pengguna, misalnya mengambil data pengguna dari database, menampilkan informasi, dll.
// Contoh sederhana:

// Ambil nama pengguna dari sesi
$username = $_SESSION['user'];
?>

<!-- dashboard_user.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $username; ?>!</h1>
        <p>This is your user dashboard.</p>
        <ul>
            
            <li><a href="create_event.php">Create Event</a></li>
            <li><a href="view_certificates.php">View Certificates</a></li>
            <li><a href="../pages/logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>



