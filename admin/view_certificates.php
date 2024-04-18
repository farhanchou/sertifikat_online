<?php
session_start();

// Periksa apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    // Jika belum, redirect ke halaman login
    header("Location: login_admin.php");
    exit();
}

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

// Query untuk mendapatkan daftar sertifikat
$sql_certificates = "SELECT * FROM certificates";
$result_certificates = $conn->query($sql_certificates);

// Periksa apakah ada sertifikat yang ditemukan
if ($result_certificates->num_rows > 0) {
    // Data sertifikat ditemukan, tampilkan dalam tabel
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Certificates</title>
        <link rel="stylesheet" href="../assets/css/view_certificates.css">
    </head>
    <body>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="create_event.php">Create Event</a></li>
                <li><a href="view_event.php">View Events</a></li>
                <li><a href="generate_certificates.php">Generate Certificates</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="view_certificates.php">View Certificates</a></li>
                <li><a href="../pages/logout.php">Logout</a></li>
            </ul>
        </nav>
        <div class="container">
            <h1>View Certificates</h1>
            <table>
                <thead>
                    <tr>
                        <th>Certificate ID</th>
                        <th>Participant Name</th>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through each row of data
                    while ($row = $result_certificates->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['certificate_id']; ?></td>
                            <td><?php echo $row['participant_name']; ?></td>
                            <td><?php echo $row['event_name']; ?></td>
                            <td><?php echo $row['event_date']; ?></td>
                            <td><a href="certificate_detail.php?id=<?php echo $row['certificate_id']; ?>" target="_blank">View PDF</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
    </html>

    <?php
} else {
    // Tidak ada sertifikat yang ditemukan
    echo "No certificates found.";
}

$conn->close();
?>
