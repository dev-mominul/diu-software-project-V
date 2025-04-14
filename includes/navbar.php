<?php
session_start();
?>

<!-- Admin Navbar -->
<nav class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Left: Logo/Project Name -->
        <div class="text-white font-bold text-2xl">
            <a href="https://mominulislam.com/sp/5/index.php">Event Management System</a> <!-- Links to front-end homepage -->
        </div>

        <!-- Right: Navigation Links for Admin -->
        <div class="space-x-4">
            <a href="dashboard.php" class="text-white">Dashboard</a>
            <a href="add_event.php" class="text-white">Add Event</a>
            <a href="events.php" class="text-white">Event List</a>
            <a href="view_students.php" class="text-white">View All Students</a>
            <a href="logout.php" class="text-white">Logout</a>
        </div>
    </div>
</nav>
