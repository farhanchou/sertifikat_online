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
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses pembaruan event jika ada permintaan POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $organizer = $_POST['organizer'];

    // Query untuk melakukan pembaruan data event
    $sql_update = "UPDATE events 
                   SET event_name='$event_name', event_date='$event_date', location='$location', organizer='$organizer' 
                   WHERE event_id=$event_id";

    // Eksekusi query pembaruan
    if ($conn->query($sql_update) === TRUE) {
        // Redirect ke halaman tampilan event setelah pembaruan berhasil
        header("Location: view_event.php");
        exit();
    } else {
        echo "Error updating event: " . $conn->error;
    }
}

// Ambil detail event yang akan diperbarui
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Query untuk mendapatkan detail event berdasarkan ID
    $sql_select = "SELECT * FROM events WHERE event_id=$event_id";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Simpan detail event dalam variabel untuk ditampilkan pada form
        $event_name = $row['event_name'];
        $event_date = $row['event_date'];
        $location = $row['location'];
        $organizer = $row['organizer'];
    } else {
        echo "Event not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="../assets/css/update_event.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="create_event.php">Create Event</a></li>
            <li><a href="view_event.php">View Events</a></li>
            <li><a href="generate_certificates.php">Generate Certificates</a></li>
            <li><a href="../pages/../pages/logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Edit Event</h2>
        <!-- Form untuk pembaruan event -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
            <label for="event_name">Event Name:</label><br>
            <input type="text" id="event_name" name="event_name" value="<?php echo $event_name; ?>" required><br>
            <label for="event_date">Event Date:</label><br>
            <input type="date" id="event_date" name="event_date" value="<?php echo $event_date; ?>" required><br>
            <label for="location">Location:</label><br>
            <input type="text" id="location" name="location" value="<?php echo $location; ?>" required><br>
            <label for="organizer">Organizer:</label><br>
            <input type="text" id="organizer" name="organizer" value="<?php echo $organizer; ?>"><br><br>
            <input type="submit" value="Update Event">
        </form>
    </div>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
