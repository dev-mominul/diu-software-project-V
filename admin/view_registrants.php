<?php
session_start();
include('../includes/db.php'); // Include the database connection

// If not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$event_id = $_GET['id']; // Get the event ID from the URL

// Fetch students who registered for this event
$sql = "SELECT * FROM registrations WHERE event_id = $event_id";
$result = $conn->query($sql);

// Fetch event details
$sql_event = "SELECT * FROM events WHERE id = $event_id";
$event_result = $conn->query($sql_event);
$event = $event_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registrants for <?= $event['title'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Include Global Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Registrants List -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">Registrants for <?= $event['title'] ?></h1>
    </header>

    <main class="pt-8 px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto">
        <!-- List of Registered Students -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="table-auto w-full">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-2">Student Name</th>
                        <th class="px-4 py-2">Student ID</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $student['name'] ?></td>
                        <td class="border px-4 py-2"><?= $student['student_id'] ?></td>
                        <td class="border px-4 py-2"><?= $student['email'] ?></td>
                        <td class="border px-4 py-2"><?= $student['phone'] ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
