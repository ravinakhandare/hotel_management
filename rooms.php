<?php
include 'db.php'; // Include the database connection

$sql = "SELECT * FROM rooms WHERE availability = TRUE";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Rooms - Hotel Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Our Rooms</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="rooms.php">Rooms</a></li>
                <li><a href="booking.html">Book Now</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="rooms">
            <h2>Explore Our Rooms</h2>
            <div class="room-list">
                <?php
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="room-card">';
                        echo '<img src="' . $row['room_type'] . '.jpg" alt="' . $row['room_type'] . '">';
                        echo '<div class="room-details">';
                        echo '<h3>' . $row['room_type'] . '</h3>';
                        echo '<p class="price">$' . $row['price'] . ' per night</p>';
                        echo '<p class="description">' . $row['description'] . '</p>';
                        echo '<a href="booking.html" class="btn">Book Now</a>';
                        echo '</div></div>';
                    }
                } else {
                    echo '<p>No rooms available.</p>';
                }
                ?>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Hotel Management</p>
    </footer>
</body>
</html>