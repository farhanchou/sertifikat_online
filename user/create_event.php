<!-- create_event.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link rel="stylesheet" href="assets/css/dashboard.css"> <!-- Tautkan CSS yang sama dengan dasbor pengguna -->
</head>
<body>
    <div class="container">
        <h1>Create New Event</h1>
        <form action="process_create_event.php" method="post">
            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name" required>
            <label for="event_date">Event Date:</label>
            <input type="date" id="event_date" name="event_date" required>
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
            <button type="submit">Create Event</button>
        </form>
    </div>
</body>
</html>
