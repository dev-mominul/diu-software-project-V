<?php 
session_start();
include('../includes/db.php'); // Include the database connection

// If not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $title = $_POST['title'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Insert new event into the database
    $sql = "INSERT INTO events (title, date, location, description) VALUES ('$title', '$date', '$location', '$description')";
    
    if ($conn->query($sql) === TRUE) {
        $success_message = "Event added successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Event</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Include Global Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Add Event Form -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">Add New Event</h1>
    </header>

    <main class="pt-8 pb-8 px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <?php if (isset($success_message)): ?>
                <div class="bg-green-100 text-green-700 p-4 rounded-md mb-6">
                    <p><?= $success_message ?></p>
                </div>
            <?php elseif (isset($error_message)): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6">
                    <p><?= $error_message ?></p>
                </div>
            <?php endif; ?>

            <form action="add_event.php" method="POST">
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Event Title</label>
                    <input type="text" name="title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700">Date & Time</label>
                    <input type="datetime-local" name="date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md">Add Event</button>
            </form>
        </div>
    </main>

</body>
</html>
