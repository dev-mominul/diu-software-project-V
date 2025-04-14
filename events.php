<?php
// Fetch events from the database
include('includes/db.php');
$sql = "SELECT * FROM events";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Events</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Include Global Frontend Navbar -->
    <?php include('includes/navbar_frontend.php'); ?>

    <!-- Events Section Title (No Blue Background) -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-4xl font-bold text-blue-600">All Events</h1>
        <p class="text-lg text-gray-600">Browse through all the events and register now</p>
    </header>

    <!-- Main Content with Bottom Padding -->
    <main class="pt-8 pb-8 px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php while ($event = $result->fetch_assoc()): ?>
            <div class="bg-white p-6 rounded-lg shadow-lg hover:bg-blue-50 transition duration-300 cursor-pointer">
                <!-- Event Title -->
                <h3 class="text-xl font-semibold text-black"><?= $event['title'] ?></h3>
                
                <!-- Event Description -->
                <p class="text-sm text-gray-600 mt-2"><?= substr($event['description'], 0, 100) . '...' ?></p>
                
                <!-- Event Date -->
                <div class="flex items-center mt-2 text-sm text-gray-600">
                    <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                    <p><?= date("F j, Y, g:i a", strtotime($event['date'])) ?></p>
                </div>
                
                <!-- Event Location -->
                <div class="flex items-center mt-2 text-sm text-gray-600">
                    <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                    <p><?= $event['location'] ?></p>
                </div>
                
                <!-- View Event Link -->
                <a href="view_event.php?id=<?= $event['id'] ?>" class="mt-4 inline-block text-blue-600 font-semibold hover:underline">View Event</a>
            </div>
            <?php endwhile; ?>
        </div>
    </main>

    <!-- Include Footer -->
    <?php include('includes/footer.php'); ?>

</body>
</html>
