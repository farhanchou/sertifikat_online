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

// Ambil informasi pengguna dari database berdasarkan ID
$query = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    // Data pengguna ditemukan
    $user = $result->fetch_assoc();

    // Cek apakah formulir disubmit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil data dari formulir
        $username = $_POST['username'];
        $email = $_POST['email'];

        // Lakukan validasi data

        // Update informasi pengguna ke database
        $update_query = "UPDATE users SET username='$username', email='$email' WHERE user_id=$user_id";
        if ($conn->query($update_query) === TRUE) {
            // Redirect kembali ke halaman manajemen pengguna dengan pesan sukses
            header("Location: manage_users.php?success=1");
            exit();
        } else {
            // Tampilkan pesan kesalahan jika gagal menyimpan perubahan
            $error_message = "Error updating user: " . $conn->error;
        }
    }
} else {
    // Data pengguna tidak ditemukan
    // Redirect kembali ke halaman manajemen pengguna dengan pesan kesalahan
    header("Location: manage_users.php?error=1");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Tautkan file CSS edit_user.css -->
    <link rel="stylesheet" href="../assets/css/edit_user.css">
</head>
<body>
    <!-- Konten halaman -->
</body>
</html>

<body>
    <!-- Tampilkan navigasi -->
    <div class="container">
        <h1>Edit User</h1>
        <?php if (isset($error_message)) { ?>
            <p><?php echo $error_message; ?></p>
        <?php } ?>
        <form method="post">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>">
            </div>
            <div>
                <button type="submit">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
