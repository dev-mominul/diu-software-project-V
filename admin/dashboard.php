<?php
session_start();
include('../includes/db.php'); // Include the database connection

// If not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Fetch all events
$sql = "SELECT * FROM events";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Include Global Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Admin Dashboard Title (Separated from Navbar) -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">Welcome to Admin Dashboard</h1>
    </header>

    <!-- Main Content -->
    <main class="pt-8 px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- Card 1: Event List -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:bg-blue-100 cursor-pointer">
                <h3 class="text-xl font-semibold">Event List</h3>
                <p class="text-sm text-gray-600">View all the events created for the portal.</p>
                <a href="events.php" class="mt-4 inline-block text-blue-500 hover:underline">Go to Event List</a>
            </div>

            <!-- Card 2: Add New Event -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:bg-blue-100 cursor-pointer">
                <h3 class="text-xl font-semibold">Add New Event</h3>
                <p class="text-sm text-gray-600">Create new events for the students to register.</p>
                <a href="add_event.php" class="mt-4 inline-block text-blue-500 hover:underline">Go to Add Event</a>
            </div>

            <!-- Card 3: View All Students -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:bg-blue-100 cursor-pointer">
                <h3 class="text-xl font-semibold">View All Students</h3>
                <p class="text-sm text-gray-600">View the list of all students who have registered for events.</p>
                <a href="view_students.php" class="mt-4 inline-block text-blue-500 hover:underline">View All Students</a>
            </div>
        </div>
    </main>
    
</body>
</html>
