<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'hotel_management');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the booking
    $sql = "DELETE FROM bookings WHERE id = $booking_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_panel.php"); // Redirect back to admin panel
    } else {
        echo "Error deleting booking: " . $conn->error;
    }
    $conn->close();
}
?>