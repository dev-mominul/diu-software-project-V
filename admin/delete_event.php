<?php
include('../includes/db.php');

$event_id = $_GET['id']; // Get the event ID from the URL

// Delete the event from the database
$sql_delete = "DELETE FROM events WHERE id = ?";
$stmt = $conn->prepare($sql_delete);
$stmt->bind_param("i", $event_id);

if ($stmt->execute()) {
    // Redirect back to events.php with a success message
    header("Location: events.php?status=deleted");
    exit();
} else {
    echo "Error deleting event: " . $conn->error;
}
?>
