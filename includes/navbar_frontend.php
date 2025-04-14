<?php
session_start();
?>

<!-- Frontend Navbar -->
<nav class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center max-w-screen-xl">
        <!-- Left: Logo/Project Name -->
        <div class="text-white font-bold text-2xl">
            <a href="index.php">Event Management System</a>
        </div>

        <!-- Right: Navigation Links for Frontend -->
        <div class="space-x-4">
            <a href="index.php" class="text-white">Home</a>
            <a href="events.php" class="text-white">Events</a>

            <!-- Admin Login link -->
            <a href="/sp/5/admin/login.php" class="text-white">Admin Login</a>

        </div>
    </div>
</nav>
