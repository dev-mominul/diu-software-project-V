<?php 
session_start();
include('../includes/db.php'); // Include the database connection

// If not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Get the student_id from the URL
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Fetch student data
    $sql = "SELECT * FROM registrations WHERE student_id = '$student_id'";
    $result = $conn->query($sql);
    $student = $result->fetch_assoc();

    // Check if student exists
    if (!$student) {
        echo "Student not found!";
        exit();
    }

    // Handle form submission for updating student data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // Update student details (don't modify student_id)
        $sql_update = "UPDATE registrations SET name = '$name', email = '$email', phone = '$phone' WHERE student_id = '$student_id'";

        if ($conn->query($sql_update) === TRUE) {
            // Set success message after successful update
            $success_message = "Student information updated successfully!";
        } else {
            $error_message = "Error updating student: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Include Global Navbar -->
    <?php include('../includes/navbar.php'); ?>

    <!-- Edit Student -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold">Edit Student Information</h1>
    </header>

    <main class="pt-8 px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto">
        <!-- Success Message Notification -->
        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-md mb-6">
                <p><?= $success_message ?></p>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6">
                <p><?= $error_message ?></p>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <form action="edit_student.php?student_id=<?= $student['student_id'] ?>" method="POST">
                <!-- Display Student ID but don't allow editing -->
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID</label>
                    <input type="text" name="student_id" value="<?= $student['student_id'] ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" disabled>
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="<?= $student['name'] ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="<?= $student['email'] ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" value="<?= $student['phone'] ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md">Update Student</button>
            </form>
        </div>
    </main>

</body>
</html>
