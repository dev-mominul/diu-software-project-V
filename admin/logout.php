<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to homepage or login page
header('Location: login.php'); // For admin logout
exit;
?>
