<?php
session_start();
include('includes/db.php'); // Include the database connection

// If not logged in, redirect to login page
if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id']; // Assuming student ID is stored in session
$event_id = $_POST['event_id']; // Get the event ID from the form

// Check if the student is already registered for this event
$sql_check = "SELECT * FROM registrations WHERE event_id = $event_id AND student_id = $student_id";
$check_result = $conn->query($sql_check);

if ($check_result->num_rows > 0) {
    echo "You are already registered for this event.";
} else {
    // Register the student for the event
    $sql_register = "INSERT INTO registrations (event_id, student_id) VALUES ($event_id, $student_id)";
    if ($conn->query($sql_register) === TRUE) {
        // Event Ticket Generation
        $ticket = "Event Ticket for " . $_SESSION['student_name'] . "\nEvent: " . $event_id . "\nRegistered on: " . date('Y-m-d H:i:s');
        echo "You have successfully registered for the event!<br><pre>" . $ticket . "</pre>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
