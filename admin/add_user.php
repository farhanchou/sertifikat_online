<?php
// Panggil koneksi ke database
include '../includes/koneksi.php';

// Definisikan pesan kesalahan dan kesuksesan
$error = $success = '';

// Periksa apakah formulir telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari formulir jika tersedia
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $full_name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Pastikan data yang dibutuhkan tidak kosong
    if (!empty($username) && !empty($password) && !empty($full_name) && !empty($email)) {
        // Enkripsi kata sandi menggunakan password_hash()
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk menambahkan pengguna ke database
        $sql = "INSERT INTO users (username, password, full_name, email) VALUES ('$username', '$hashed_password', '$full_name', '$email')";
        
        // Eksekusi query
        if ($conn->query($sql) === TRUE) {
            $success = "New user added successfully.";
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="../assets/css/admin_dashboard.css">
</head>
<body>
    <nav>
        <!-- Tautan menu lainnya -->
    </nav>
    <div class="container">
        <h1>Add User</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" name="full_name" id="full_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <button type="submit">Add User</button>
        </form>
        <p class="error"><?php echo $error; ?></p>
        <p class="success"><?php echo $success; ?></p>
    </div>
</body>
</html>
