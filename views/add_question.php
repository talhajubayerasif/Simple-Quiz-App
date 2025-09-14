<?php
session_start();

// Ensure only quiz authors can access this page
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'quiz_author') {
    die("Access denied.");
}

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

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and collect form data
    $quizTitle = $conn->real_escape_string($_POST['quiz_title']);
    $questionText = $conn->real_escape_string($_POST['question_text']);
    $optionA = $conn->real_escape_string($_POST['option_a']);
    $optionB = $conn->real_escape_string($_POST['option_b']);
    $optionC = $conn->real_escape_string($_POST['option_c']);
    $optionD = $conn->real_escape_string($_POST['option_d']);
    $correctOption = $conn->real_escape_string($_POST['correct_option']);

    // Find the quiz_id based on the quiz title
    $stmt = $conn->prepare("SELECT id FROM quizzes WHERE title = ?");
    $stmt->bind_param("s", $quizTitle);
    $stmt->execute();
    $result = $stmt->get_result();

    $quizId = null;
    if ($result->num_rows > 0) {
        $quiz = $result->fetch_assoc();
        $quizId = $quiz['id'];
    } else {
        // If the quiz doesn't exist, create a new one
        $stmt_insert_quiz = $conn->prepare("INSERT INTO quizzes (title) VALUES (?)");
        $stmt_insert_quiz->bind_param("s", $quizTitle);
        $stmt_insert_quiz->execute();
        $quizId = $conn->insert_id;
        $stmt_insert_quiz->close();
    }
    $stmt->close();

    // Insert the new question into the questions table
    $sql = "INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $quizId, $questionText, $optionA, $optionB, $optionC, $optionD, $correctOption);

    if ($stmt->execute()) {
        echo "Question added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
