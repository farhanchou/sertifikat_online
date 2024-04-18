<!-- view_event -->
<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    // If not, redirect to login page
    header("Location: login_admin.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sertifikat_online";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete event
if (isset($_POST['delete'])) {
    $event_id = $_POST['event_id'];

    $sql_delete = "DELETE FROM events WHERE event_id=$event_id";

    if ($conn->query($sql_delete) === TRUE) {
        echo "Event deleted successfully";
    } else {
        echo "Error deleting event: " . $conn->error;
    }
}

// Fetch events from database
$sql_select = "SELECT * FROM events";
$result = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Events</title>
    <link rel="stylesheet" href="../assets/css/view_event.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <nav>
    <ul>
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="create_event.php">Create Event</a></li>
        <li><a href="view_event.php">View Events</a></li>
        <li><a href="generate_certificates.php">Generate Certificates</a></li>
        <li><a href="manage_users.php">Manage Users</a></li> <!-- Tautan baru untuk mengelola pengguna -->
        <li><a href="view_certificates.php">View Certificates</a></li>
        <li><a href="../pages/logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>View Events</h2>
        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Event ID</th><th>Event Name</th><th>Event Date</th><th>Location</th><th>Organizer</th><th>Action</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["event_id"]."</td>";
                echo "<td>".$row["event_name"]."</td>";
                echo "<td>".$row["event_date"]."</td>";
                echo "<td>".$row["location"]."</td>";
                echo "<td>".$row["organizer"]."</td>";
                echo "<td>
                        <form method='post' action=''>
                            <input type='hidden' name='event_id' value='".$row["event_id"]."'>
                            <button type='submit' name='delete' class='delete-btn'><i class='fas fa-trash'></i></button>
                        </form>
                        <form method='get' action='update_event.php'>
                            <input type='hidden' name='event_id' value='".$row["event_id"]."'>
                            <button type='submit' class='edit-btn'><i class='fas fa-edit'></i></button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No events found";
        }
        ?>
    </div>
</body>
</html>