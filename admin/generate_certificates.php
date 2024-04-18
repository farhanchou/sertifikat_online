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

// Fetch events from database
$sql_select_events = "SELECT * FROM events";
$result_events = $conn->query($sql_select_events);

// Fetch users from database
$sql_select_users = "SELECT * FROM users";
$result_users = $conn->query($sql_select_users);

// Generate certificates
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $user_ids = $_POST['user_id']; // Changed to array
    $certificate_text = $_POST['certificate_text'];

    foreach ($user_ids as $user_id) {
        // Fetch event details
        $sql_select_event = "SELECT * FROM events WHERE event_id = $event_id";
        $result_event = $conn->query($sql_select_event);

        if ($result_event->num_rows > 0) {
            $row_event = $result_event->fetch_assoc();
            $event_name = $row_event['event_name'];
            $event_date = $row_event['event_date'];

            // Fetch user details
            $sql_select_user = "SELECT * FROM users WHERE user_id = $user_id";
            $result_user = $conn->query($sql_select_user);

            if ($result_user->num_rows > 0) {
                $row_user = $result_user->fetch_assoc();
                $participant_name = $row_user['full_name'];

                // Insert certificate into database
                $sql_insert_certificate = "INSERT INTO certificates (participant_name, event_name, event_date, certificate_text) 
                                           VALUES ('$participant_name', '$event_name', '$event_date', '$certificate_text')";
                $conn->query($sql_insert_certificate);

                echo "Certificate generated successfully for user: $participant_name.<br>";
            } else {
                echo "User not found for ID: $user_id.<br>";
            }
        } else {
            echo "Event not found for ID: $event_id.<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Certificates</title>
    <link rel="stylesheet" href="../assets/css/generate_certificates.css">
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
        <h2>Generate Certificates</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="event_id">Select Event:</label><br>
            <select id="event_id" name="event_id" required>
                <option value="">Select</option>
                <?php
                if ($result_events->num_rows > 0) {
                    while ($row = $result_events->fetch_assoc()) {
                        echo "<option value='".$row['event_id']."'>".$row['event_name']."</option>";
                    }
                }
                ?>
            </select><br><br>
            <label for="user_id">Select User(s):</label><br>
            <select id="user_id" name="user_id[]" multiple required>
                <option value="">Select</option>
                <?php
                if ($result_users->num_rows > 0) {
                    while ($row = $result_users->fetch_assoc()) {
                        echo "<option value='".$row['user_id']."'>".$row['full_name']."</option>";
                    }
                }
                ?>''
            </select><br><br>
            <label for="certificate_text">Certificate Text:</label><br>
            <textarea id="certificate_text" name="certificate_text" rows="4" cols="50" required></textarea><br><br>
            <input type="submit" value="Generate Certificate">
        </form>
    </div>
    <footer>
        <p>&copy; 2024 Sertifikat Online</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
