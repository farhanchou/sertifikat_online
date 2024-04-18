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

// Query untuk mendapatkan jumlah sertifikat
$sql_certificates_count = "SELECT COUNT(*) as total FROM certificates";
$result_certificates_count = $conn->query($sql_certificates_count);

// Periksa kesalahan pada query
if (!$result_certificates_count) {
    die("Error in query: " . $conn->error);
}

$row_certificates_count = $result_certificates_count->fetch_assoc();
$total_certificates = $row_certificates_count['total'];

// Query untuk mendapatkan jumlah pengguna
$sql_users_count = "SELECT COUNT(*) as total FROM users";
$result_users_count = $conn->query($sql_users_count);

// Periksa kesalahan pada query
if (!$result_users_count) {
    die("Error in query: " . $conn->error);
}

$row_users_count = $result_users_count->fetch_assoc();
$total_users = $row_users_count['total'];

// Query untuk mendapatkan jumlah acara
$sql_events_count = "SELECT COUNT(*) as total FROM events";
$result_events_count = $conn->query($sql_events_count);

// Periksa kesalahan pada query
if (!$result_events_count) {
    die("Error in query: " . $conn->error);
}

$row_events_count = $result_events_count->fetch_assoc();
$total_events = $row_events_count['total'];

// Query untuk mendapatkan jumlah penugasan sertifikat
$sql_assignments_count = "SELECT COUNT(*) as total FROM certificate_assignments";
$result_assignments_count = $conn->query($sql_assignments_count);

// Periksa kesalahan pada query
if (!$result_assignments_count) {
    die("Error in query: " . $conn->error);
}

$row_assignments_count = $result_assignments_count->fetch_assoc();
$total_assignments = $row_assignments_count['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/admin_dashboard.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
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
    </div>

    <div class="content">
        <div class="container">
            <h1>Welcome, Admin!</h1>
            <div class="summary">
                <div class="summary-item">
                    <h2>Total Certificates</h2>
                    <p><?php echo $total_certificates; ?></p>
                </div>
                <div class="summary-item">
                    <h2>Total Users</h2>
                    <p><?php echo $total_users; ?></p>
                </div>
                <div class="summary-item">
                    <h2>Total Events</h2>
                    <p><?php echo $total_events; ?></p>
                </div>
                <div class="summary-item">
                    <h2>Total Assignments</h2>
                    <p><?php echo $total_assignments; ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

