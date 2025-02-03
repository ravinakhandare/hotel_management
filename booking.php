<?php
include 'db.php'; // Include the database connection

// Initialize variables
$message = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize inputs
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $room_id = intval($_POST['room_id']);

    try {
        // Check if room exists and is available
        $stmt = $conn->prepare("SELECT id FROM rooms WHERE id = ? AND availability = TRUE");
        $stmt->execute([$room_id]);
        $room = $stmt->fetch();

        if ($room) {
            // Insert booking
            $insertStmt = $conn->prepare("INSERT INTO bookings (room_id, guest_name, guest_email, check_in, check_out) 
                                        VALUES (?, ?, ?, ?, ?)");
            $insertStmt->execute([$room_id, $name, $email, $check_in, $check_out]);
            
            $message = '<div class="success">Booking successful! Thank you for choosing us.</div>';
        } else {
            $message = '<div class="error">Invalid room selection or room not available.</div>';
        }
    } catch (PDOException $e) {
        $message = '<div class="error">Error: ' . $e->getMessage() . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Room - Hotel Management</title>
    <link rel="stylesheet" href="bookingstyles.css">
    <style>
        .success { color: green; padding: 10px; margin: 10px 0; border: 1px solid green; }
        .error { color: red; padding: 10px; margin: 10px 0; border: 1px solid red; }
    </style>
</head>
<body>
    <header>
        <h1>Book a Room</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="rooms.php">Rooms</a></li>
                <li><a href="booking.php">Book Now</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php echo $message; ?>
        <section class="booking-form">
            <h2>Reserve Your Stay</h2>
            <form action="booking.php" method="POST">
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required 
                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="check_in">Check-In Date:</label>
                    <input type="date" id="check_in" name="check_in" required 
                           value="<?php echo isset($_POST['check_in']) ? htmlspecialchars($_POST['check_in']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="check_out">Check-Out Date:</label>
                    <input type="date" id="check_out" name="check_out" required 
                           value="<?php echo isset($_POST['check_out']) ? htmlspecialchars($_POST['check_out']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="room_id">Room Type:</label>
                    <select id="room_id" name="room_id" required>
                        <option value="">Select a Room</option>
                        <?php
                        $rooms = $conn->query("SELECT id, room_type FROM rooms WHERE availability = TRUE");
                        while ($row = $rooms->fetch(PDO::FETCH_ASSOC)) {
                            $selected = (isset($_POST['room_id']) && $_POST['room_id'] == $row['id']) ? 'selected' : '';
                            echo '<option value="' . $row['id'] . '" ' . $selected . '>' 
                                 . htmlspecialchars($row['room_type']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit">Book Now</button>
                </div>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Hotel Management</p>
    </footer>
</body>
</html>