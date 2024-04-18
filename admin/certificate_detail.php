<?php
session_start();

// Periksa apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    // Jika belum, redirect ke halaman login
    header("Location: login_admin.php");
    exit();
}

// Periksa apakah parameter ID sertifikat diberikan di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Jika tidak, kembalikan ke halaman sebelumnya atau tampilkan pesan kesalahan
    header("Location: view_certificates.php");
    exit();
}

// Ambil ID sertifikat dari parameter URL
$certificate_id = $_GET['id'];

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sertifikat_online";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mendapatkan detail sertifikat berdasarkan ID
$sql_certificate_detail = "SELECT * FROM certificates WHERE certificate_id = $certificate_id";
$result_certificate_detail = $conn->query($sql_certificate_detail);

// Periksa apakah sertifikat ditemukan
if ($result_certificate_detail->num_rows > 0) {
    // Sertifikat ditemukan, tampilkan detailnya
    $certificate = $result_certificate_detail->fetch_assoc();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Certificate Detail</title>
        <link rel="stylesheet" href="../assets/css/admin_dashboard.css">
    </head>
    
        </nav>
        <div class="container">
            <h1>Certificate Detail</h1>
            <div class="certificate-details">
                <p><strong>Participant Name:</strong> <?php echo $certificate['participant_name']; ?></p>
                <p><strong>Event Name:</strong> <?php echo $certificate['event_name']; ?></p>
                <p><strong>Event Date:</strong> <?php echo $certificate['event_date']; ?></p>
                <p><strong>Certificate Text:</strong></p>
                <pre><?php echo $certificate['certificate_text']; ?></pre>
                <!-- Tambahkan iframe untuk menampilkan PDF -->
                <iframe src="generate_pdf.php?id=<?php echo $certificate['certificate_id']; ?>" style="width: 100%; height: 500px;"></iframe>
            </div>
        </div>
    </body>
    </html>

    <?php
} else {
    // Sertifikat tidak ditemukan
    echo "Certificate not found.";
}

$conn->close();
?>