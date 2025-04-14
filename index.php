<?php
session_start();
include('includes/db.php'); // Include the database connection

// Fetch upcoming events (those that are yet to happen)
$sql_upcoming = "SELECT * FROM events WHERE date >= NOW() ORDER BY date ASC";
$upcoming_result = $conn->query($sql_upcoming);

// Fetch past events (those that have already occurred)
$sql_past = "SELECT * FROM events WHERE date < NOW() ORDER BY date DESC";
$past_result = $conn->query($sql_past);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Include Global Navbar -->
    <?php include('includes/navbar_frontend.php'); ?>

    <!-- Hero Section with Full Width and No Gap -->
    <section class="bg-gray-50 py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold text-blue-600 mb-4">Welcome to the Event Management System</h1>
            <p class="text-lg text-gray-600 mb-8">This project is presented as part of CSE317: Software Project V in the Computer Science and Engineering Department.</p>
            <a href="events.php" class="bg-blue-600 text-white py-2 px-6 rounded-full text-lg font-semibold hover:bg-blue-700 transition duration-300">Browse Events</a>
        </div>
    </section>

    <!-- Upcoming Events Title (without blue background) -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">Upcoming Events</h1>
    </header>

    <main class="pt-8 pb-8 px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto">
        <!-- Upcoming Events Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php while ($event = $upcoming_result->fetch_assoc()): ?>
            <div class="bg-white p-6 rounded-lg shadow-lg hover:bg-blue-100 cursor-pointer">
                <h3 class="text-xl font-semibold"><?= $event['title'] ?></h3>
                <div class="flex items-center space-x-2 mt-2">
                    <i class="fas fa-calendar-alt text-blue-500"></i>
                    <p class="text-sm text-gray-600"><?= date("F j, Y, g:i a", strtotime($event['date'])) ?></p>
                </div>
                <div class="flex items-center space-x-2 mt-2">
                    <i class="fas fa-map-marker-alt text-red-600"></i>
                    <p class="text-sm text-gray-600"><?= $event['location'] ?></p>
                </div>
                <a href="view_event.php?id=<?= $event['id'] ?>" class="text-blue-500 hover:underline mt-4 block">View Event</a>
            </div>
            <?php endwhile; ?>
        </div>

        <h2 class="text-3xl font-bold mt-12 text-center">Past Events</h2>

        <!-- Past Events Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
            <?php while ($event = $past_result->fetch_assoc()): ?>
            <div class="bg-white p-6 rounded-lg shadow-lg hover:bg-blue-100 cursor-pointer">
                <h3 class="text-xl font-semibold"><?= $event['title'] ?></h3>
                <div class="flex items-center space-x-2 mt-2">
                    <i class="fas fa-calendar-alt text-blue-600"></i>
                    <p class="text-sm text-gray-600"><?= date("F j, Y, g:i a", strtotime($event['date'])) ?></p>
                </div>
                <div class="flex items-center space-x-2 mt-2">
                    <i class="fas fa-map-marker-alt text-red-600"></i>
                    <p class="text-sm text-gray-600"><?= $event['location'] ?></p>
                </div>
                <a href="view_event.php?id=<?= $event['id'] ?>" class="text-blue-500 hover:underline mt-4 block">View Event</a>
            </div>
            <?php endwhile; ?>
        </div>
    </main>

    <!-- Include Footer -->
    <?php include('includes/footer.php'); ?>

</body>
</html>
