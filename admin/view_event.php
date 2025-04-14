<?php 
session_start();
include('includes/db.php'); // Include the database connection

// Check if event ID is passed and sanitize it
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $event_id = $_GET['id']; // Get the event ID from the URL
} else {
    die("Invalid event ID.");
}

// Fetch event details from the database using prepared statements
$sql_event = "SELECT * FROM events WHERE id = ?";
$stmt = $conn->prepare($sql_event);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$event_result = $stmt->get_result();

// Check if the event exists
if ($event_result->num_rows > 0) {
    $event = $event_result->fetch_assoc();
} else {
    die("Event not found.");
}

// Initialize variables for registration
$registration_success = false;
$student_name = $student_email = $student_phone = $student_id = '';
$error_message = '';

// Handle Registration Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['name'];
    $student_email = $_POST['email'];
    $student_phone = $_POST['phone'];
    $student_id = $_POST['student_id']; // Fetch student ID from the form

    // Step 1: Check if the Student ID already exists for this event
    $sql_check_student_id = "SELECT * FROM registrations WHERE student_id = ? AND event_id = ?";
    $stmt_check = $conn->prepare($sql_check_student_id);
    $stmt_check->bind_param("si", $student_id, $event_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // If Student ID exists, show an error message
        $error_message = "This Student ID is already registered for the event.";
    } else {
        // Step 2: Insert the student data into the `registrations` table
        $sql_register = "INSERT INTO registrations (event_id, name, student_id, email, phone, registration_time) 
                         VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt_register = $conn->prepare($sql_register);
        $stmt_register->bind_param("issss", $event_id, $student_name, $student_id, $student_email, $student_phone);

        if ($stmt_register->execute()) {
            // Mark registration as successful
            $registration_success = true;
        } else {
            $error_message = "Error registering student: " . $stmt_register->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['title']) ?> - Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Include Global Navbar -->
    <?php include('includes/navbar.php'); ?>

    <!-- Event Details -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold"><?= htmlspecialchars($event['title']) ?></h1>
    </header>

    <main class="pt-8 pb-8 px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <p class="text-sm text-gray-600"><?= date("F j, Y, g:i a", strtotime($event['date'])) ?> | <?= htmlspecialchars($event['location']) ?></p>
            <p class="mt-4"><?= nl2br(htmlspecialchars($event['description'])) ?></p>
        </div>

        <!-- Registration Form -->
        <?php if (!$registration_success): ?>
            <h2 class="text-xl font-semibold mb-4">Register for this Event</h2>
            <form action="view_event.php?id=<?= $event['id'] ?>" method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <!-- Student ID Field -->
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700">Student ID</label>
                    <input type="text" name="student_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <!-- Error Message for Duplicate Student ID -->
                <?php if ($error_message): ?>
                    <div class="text-red-500 text-sm mb-4"><?= $error_message ?></div>
                <?php endif; ?>

                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md">Register Now</button>
            </form>
        <?php else: ?>
            <!-- Display the ticket confirmation after successful registration -->
            <div id="ticket" class="bg-white p-6 rounded-lg shadow-lg max-w-xl mx-auto mt-8">
                <h1 class="text-3xl font-bold text-center">Registration Successful!</h1>
                <p class="text-lg text-center">Thank you for registering for <strong><?= htmlspecialchars($event['title']) ?></strong></p>
                <p class="text-center">Date: <?= date("F j, Y, g:i a", strtotime($event['date'])) ?></p>
                <p class="text-center">Location: <?= htmlspecialchars($event['location']) ?></p>
                <div class="mt-4">
                    <h2 class="text-2xl font-semibold">Your Ticket</h2>
                    <p><strong>Name:</strong> <?= htmlspecialchars($student_name) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($student_email) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($student_phone) ?></p>
                    <p><strong>Student ID:</strong> <?= htmlspecialchars($student_id) ?></p>
                </div>
                <div class="text-center mt-4">
                    <button onclick="window.print()" class="bg-blue-600 text-white py-2 px-4 rounded-md">Print Ticket</button>
                </div>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>
