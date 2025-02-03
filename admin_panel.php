<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login if not logged in
    exit();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'hotel_management');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all bookings
$sql = "SELECT bookings.id, bookings.guest_name, bookings.guest_email, bookings.check_in, bookings.check_out, rooms.room_type 
        FROM bookings 
        JOIN rooms ON bookings.room_id = rooms.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <nav>
            <ul>
                <li><a href="admin_panel.php">View Bookings</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>All Bookings</h2>
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Guest Name</th>
                    <th>Guest Email</th>
                    <th>Room Type</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['guest_name'] . "</td>";
                        echo "<td>" . $row['guest_email'] . "</td>";
                        echo "<td>" . $row['room_type'] . "</td>";
                        echo "<td>" . $row['check_in'] . "</td>";
                        echo "<td>" . $row['check_out'] . "</td>";
                        echo "<td><a href='delete_booking.php?id=" . $row['id'] . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No bookings found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2023 Hotel Management</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>