<?php
$servername = "localhost"; // Typically localhost for local development
$username = "mominul_event_registration";        // Your MySQL username (usually 'root' for local development)
$password = "Ss@350930";            // Your MySQL password (empty for default in local dev)
$dbname = "mominul_event_registration"; // The name of the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
