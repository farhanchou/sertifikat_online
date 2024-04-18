<?php
session_start();
// Pastikan admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}
// Koneksi ke database
include_once("../includes/koneksi.php");

// Periksa apakah parameter ID pengguna diberikan di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Jika tidak, kembalikan ke halaman manajemen pengguna
    header("Location: manage_users.php");
    exit();
}

// Ambil ID pengguna dari parameter URL
$user_id = $_GET['id'];

// Lakukan penghapusan pengguna dari database
$delete_query = "DELETE FROM users WHERE user_id = $user_id";

if ($conn->query($delete_query) === TRUE) {
    // Penghapusan berhasil
    // Redirect kembali ke halaman manajemen pengguna dengan pesan sukses
    header("Location: manage_users.php?delete_success=1");
    exit();
} else {
    // Penghapusan gagal
    // Redirect kembali ke halaman manajemen pengguna dengan pesan kesalahan
    header("Location: manage_users.php?delete_error=1");
    exit();
}
?>
