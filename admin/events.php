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
    <title>Event List</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Include Global Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Event List Title (without blue background) -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">Event List</h1>
    </header>

    <main class="pt-8 pb-8 px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto">
        <!-- Success Message Notification -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-md mb-6">
                <p>Event deleted successfully!</p>
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="table-auto w-full">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Location</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($event = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $event['id'] ?></td>
                        <td class="border px-4 py-2"><?= $event['title'] ?></td>
                        <td class="border px-4 py-2"><?= $event['date'] ?></td>
                        <td class="border px-4 py-2"><?= $event['location'] ?></td>
                        <td class="border px-4 py-2">
                         
                             <!-- View Registrants -->
                            <a href="view_registrants.php?id=<?= $event['id'] ?>" class="text-green-500 hover:underline">View Registrants</a> |
                             <!-- Edit Event -->
                            <a href="edit_event.php?id=<?= $event['id'] ?>" class="text-blue-500 hover:underline">Edit</a> |
                             <!-- Delete Event -->
                            <a href="delete_event.php?id=<?= $event['id'] ?>" class="text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
