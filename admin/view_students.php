<?php
session_start();
include('../includes/db.php'); // Include the database connection

// If not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Handle delete student
if (isset($_GET['delete'])) {
    $student_id = $_GET['delete'];

    // Delete the student record from the registrations table
    $sql_delete = "DELETE FROM registrations WHERE student_id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("s", $student_id);

    if ($stmt->execute()) {
        // Redirect after deletion with a success message
        header("Location: view_students.php?status=deleted");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch students who have registered for events
$sql = "SELECT * FROM registrations";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Include Global Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- View Students -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">View Registered Students</h1>
    </header>

    <main class="pt-8 px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto">
        <!-- Success Message Notification -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-md mb-6">
                <p>Student deleted successfully!</p>
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="table-auto w-full">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-2">Student ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Phone Number</th>
                        <th class="px-4 py-2">Joined Events</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $student['student_id'] ?></td>
                        <td class="border px-4 py-2"><?= $student['name'] ?></td>
                        <td class="border px-4 py-2"><?= $student['email'] ?></td>
                        <td class="border px-4 py-2"><?= $student['phone'] ?></td>
                        <td class="border px-4 py-2"><?= $student['event_id'] ?></td>
                        <td class="border px-4 py-2">
                            <!-- Edit Button -->
                            <a href="edit_student.php?student_id=<?= $student['student_id'] ?>" class="text-blue-500 hover:underline">Edit</a> | 
                            <!-- Delete Button -->
                            <a href="view_students.php?delete=<?= $student['student_id'] ?>" class="text-red-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
