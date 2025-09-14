<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz_app";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is a student and if the feedback form was submitted
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student' || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

$quiz_id = $_POST['quiz_id'] ?? null;
$feedback_text = $_POST['feedback_text'] ?? '';
$student_id = $_SESSION['user_id'];

if ($quiz_id && !empty($feedback_text)) {
    // Insert feedback into the database
    $sql = "INSERT INTO quiz_feedback (quiz_id, student_id, feedback_text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $quiz_id, $student_id, $feedback_text);

    if ($stmt->execute()) {
        // Redirect back to the quiz page with a success message
        header("Location: quiz.php?quiz_id=" . urlencode($quiz_id) . "&success=feedback");
        exit();
    } else {
        die("Error submitting feedback: " . $stmt->error);
    }
} else {
    die("Quiz ID and feedback are required.");
}
?>
