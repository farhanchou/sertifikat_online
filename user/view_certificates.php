<?php
// Koneksi ke database
include '../includes/koneksi.php';

// Query untuk mendapatkan daftar sertifikat
$sql_certificates = "SELECT * FROM certificates";
$result_certificates = $conn->query($sql_certificates);

// Periksa kesalahan pada query
if (!$result_certificates) {
    die("Error in query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Certificates</title>
    <link rel="stylesheet" href="../assets/css/admin_dashboard.css">
</head>
<body>
    <nav>
        <!-- Tautan menu lainnya -->
    </nav>
    <div class="container">
        <h1>View Certificates</h1>
        <p><a href="generate_pdf.php">Download PDF</a></p>
        <div>
            <?php
            // Tampilkan daftar sertifikat
            while ($row = $result_certificates->fetch_assoc()) {
                echo "<div>";
                echo "<p>Certificate ID: " . $row['certificate_id'] . "</p>";
                echo "<p>Participant Name: " . $row['participant_name'] . "</p>";
                echo "<p>Event Name: " . $row['event_name'] . "</p>";
                echo "<p>Event Date: " . $row['event_date'] . "</p>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
