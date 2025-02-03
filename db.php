<?php
$host = 'localhost'; // Server name
$dbname = 'hotel_management'; // Database name
$username = 'root'; // Default username for XAMPP/WAMP
$password = ''; // Default password for XAMPP/WAMP is empty

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; // Remove this line after testing
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>