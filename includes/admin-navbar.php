<?php
session_start();
?>

<!-- Global Navbar -->
<nav class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Left: Logo/Project Name -->
        <div class="text-white font-bold text-2xl">
            <a href="index.php">Event Registration Portal</a>
        </div>

        <!-- Right: Dynamic Links -->
        <div class="space-x-4">
            <!-- For Students -->
            <?php if (isset($_SESSION['student_logged_in']) && $_SESSION['student_logged_in'] == true): ?>
                <a href="student_dashboard.php" class="text-white">Student Dashboard</a>
                <a href="view_events.php" class="text-white">Events</a>
                <a href="logout.php" class="text-white">Logout</a>

            <!-- For Admins -->
            <?php elseif (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true): ?>
                <a href="admin/dashboard.php" class="text-white">Dashboard</a>
                <a href="admin/events.php" class="text-white">Events</a>
                <a href="admin/view_registrations.php" class="text-white">View Registrations</a>
                <a href="logout.php" class="text-white">Logout</a>

            <!-- If Not Logged In -->
            <?php else: ?>
                <a href="index.php" class="text-white">Home</a>
                <a href="events.php" class="text-white">Events</a>
                <a href="login.php" class="text-white">Login</a>
                <a href="register.php" class="text-white">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
