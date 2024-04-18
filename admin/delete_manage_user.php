<?php
// Include file koneksi ke database
include '../includes/koneksi.php';

// Inisialisasi variabel untuk menyimpan pesan kesalahan
$error = '';

// Periksa apakah ada parameter ID pengguna yang diberikan melalui URL
if (isset($_GET['id'])) {
    // Jika ada, lakukan query untuk menghapus pengguna dengan ID tersebut
    $user_id = $_GET['id'];
    $sql_delete_user = "DELETE FROM users WHERE user_id = $user_id";

    // Jalankan query SQL
    if ($conn->query($sql_delete_user) === TRUE) {
        // Jika pengguna berhasil dihapus, redirect kembali ke halaman manage_users.php
        header("Location: manage_users.php");
        exit();
    } else {
        // Jika terjadi kesalahan saat menjalankan query, simpan pesan kesalahan
        $error = "Error deleting user: " . $conn->error;
    }
} else {
    // Jika tidak ada parameter ID pengguna, tampilkan pesan kesalahan
    $error = "User ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="../assets/css/admin_dashboard.css"> <!-- Gunakan stylesheet yang sudah ada -->
</head>
<body>
    <nav>
        <!-- Tautan menu lainnya -->
    </nav>
    <div class="container">
        <h1>Delete User</h1>
        <!-- Tampilkan pesan kesalahan jika ada -->
        <span class="error"><?php echo $error; ?></span>
    </div>
</body>
</html>
