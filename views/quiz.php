<?php
session_start();

// This is a placeholder for the actual quiz page.
// The code below assumes a quiz has been loaded and a quiz_id is available.
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 1; // Example quiz ID

// Check if the user is a student
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
    die("Access denied. You must be a Student to take a quiz.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Page</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Take a Quiz</h1>
        <p>This is a placeholder page for taking a quiz. Imagine the quiz questions are here.</p>
        
        <!-- Feedback Form -->
        <div class="feedback-form">
            <h2>Leave Feedback for the Quiz Author</h2>
            <form action="submit_feedback.php" method="POST">
                <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quiz_id); ?>">
                <textarea name="feedback_text" rows="4" placeholder="Your thoughts on the quiz... (e.g., 'The questions were great!', 'I found a typo on question 5.')" required></textarea>
                <button type="submit" class="submit-feedback-btn">Submit Feedback</button>
            </form>
        </div>
    </div>
</body>
</html>
