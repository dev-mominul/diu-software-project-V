<?php 
session_start();
include('../includes/db.php'); // Include the database connection

// If not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $event_id = $_GET['id']; // Get the event ID from the URL

    // Fetch the event data to populate the form
    $sql = "SELECT * FROM events WHERE id = $event_id";
    $result = $conn->query($sql);
    $event = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated event details
    $event_id = $_POST['id'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Update the event in the database
    $sql = "UPDATE events SET title = '$title', date = '$date', location = '$location', description = '$description' WHERE id = $event_id";
    
    if ($conn->query($sql) === TRUE) {
        $success_message = "Event updated successfully!";
        // Re-fetch updated data after successful update to retain the values
        $event['title'] = $title;
        $event['date'] = $date;
        $event['location'] = $location;
        $event['description'] = $description;
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
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Include Global Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Add Event Form -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">Edit Event</h1>
    </header>    

    <main class="pt-8 px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <!-- Success/Error Message -->
            <?php if (isset($success_message)): ?>
                <div class="bg-green-100 text-green-700 p-4 rounded-md mb-6">
                    <p><?= $success_message ?></p>
                </div>
            <?php elseif (isset($error_message)): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6">
                    <p><?= $error_message ?></p>
                </div>
            <?php endif; ?>

            <form action="edit_event.php" method="POST">
                <input type="hidden" name="id" value="<?= $event['id'] ?>">

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Event Title</label>
                    <input type="text" name="title" value="<?= isset($event['title']) ? $event['title'] : '' ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700">Date & Time</label>
                    <input type="datetime-local" name="date" value="<?= isset($event['date']) ? date('Y-m-d\TH:i', strtotime($event['date'])) : '' ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" value="<?= isset($event['location']) ? $event['location'] : '' ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required><?= isset($event['description']) ? $event['description'] : '' ?></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md">Update Event</button>
            </form>
        </div>
    </main>
</body>
</html>
