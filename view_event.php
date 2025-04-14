<?php
include('includes/db.php'); // Include the database connection

$event_id = $_GET['id']; // Get the event ID from the URL

// Fetch event details from the database
$sql_event = "SELECT * FROM events WHERE id = $event_id";
$event_result = $conn->query($sql_event);
$event = $event_result->fetch_assoc();

// Initialize variables to handle registration confirmation
$registration_success = false;
$student_name = $student_email = $student_phone = $student_id = '';
$error_message = '';

// Handle Registration Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['name'];
    $student_email = $_POST['email'];
    $student_phone = $_POST['phone'];
    $student_id = $_POST['student_id']; // Fetch student ID from the form

    // Step 1: Check if the Student ID is already registered for the event
    $sql_check_student_id = "SELECT * FROM registrations WHERE student_id = '$student_id' AND event_id = '$event_id'";
    $result_check = $conn->query($sql_check_student_id);

    if ($result_check->num_rows > 0) {
        // If Student ID already exists for this event, show an error message
        $error_message = "This Student ID is already registered for the event.";
    } else {
        // Step 2: Insert the registration details into the database
        $sql_register = "INSERT INTO registrations (event_id, name, student_id, email, phone, registration_time) 
                         VALUES ('$event_id', '$student_name', '$student_id', '$student_email', '$student_phone', NOW())";

        if ($conn->query($sql_register) === TRUE) {
            // Mark registration as successful
            $registration_success = true;
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $event['title'] ?> - Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Include Global Navbar -->
    <?php include('includes/navbar_frontend.php'); ?>

    <!-- Event Details -->
    <header class="text-center pt-16 pb-8">
        <h1 class="text-3xl font-bold"><?= $event['title'] ?></h1>
    </header>

    <main class="pt-8 pb-8 px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <p class="text-sm text-gray-600"><?= date("F j, Y, g:i a", strtotime($event['date'])) ?> | <?= $event['location'] ?></p>
            <p class="mt-4"><?= nl2br($event['description']) ?></p>
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
            <div id="ticket" class="bg-white p-6 rounded-lg shadow-lg max-w-xl mx-auto mt-8 text-center border border-gray-300">
                <!-- Title for Registration Success -->
                <h1 class="text-2xl font-semibold text-blue-600 mb-4">Registration Successful!</h1>
                
                <!-- Event Details Section -->
                <p class="text-lg text-gray-600 mb-4">Thank you for registering for <strong><?= $event['title'] ?></strong></p>
                <p class="text-sm text-gray-600 mb-4">Date: <?= date("F j, Y, g:i a", strtotime($event['date'])) ?></p>
                <p class="text-sm text-gray-600 mb-4">Location: <?= $event['location'] ?></p>

                <!-- Your Ticket Section -->
                <div class="mt-6 text-left">
                    <h2 class="text-xl font-semibold mb-2">Your Ticket</h2>
                    <p><strong>Name:</strong> <?= $student_name ?></p>
                    <p><strong>Email:</strong> <?= $student_email ?></p>
                    <p><strong>Phone:</strong> <?= $student_phone ?></p>
                    <p><strong>Student ID:</strong> <?= $student_id ?></p>
                </div>

                <!-- Print Button -->
                <div class="text-center mt-6">
                    <button onclick="printTicket()" class="bg-blue-600 text-white py-2 px-4 rounded-md">Print Ticket</button>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <!-- JavaScript to Print Only the Ticket Section -->
    <script>
    function printTicket() {
        var printContent = document.getElementById('ticket');
        var newWindow = window.open('', '', 'width=600,height=600');
        
        newWindow.document.write('<html><head><title>Print Ticket</title><style>body { font-family: Arial, sans-serif; padding: 20px; }</style></head><body>');
        newWindow.document.write(printContent.innerHTML);
        newWindow.document.write('</body></html>');
        
        newWindow.document.close();
        newWindow.print();
    }
    </script>
    
    <!-- Include Footer -->
    <?php include('includes/footer.php'); ?>
    
</body>
</html>
