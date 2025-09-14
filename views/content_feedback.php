<?php
session_start();

// Ensure the user is a quiz author
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'quiz_author') {
    die("Access denied. You must be a Quiz Author to view this page.");
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

// Fetch quizzes created by the logged-in user
$author_id = $_SESSION['user_id'];
$sql_quizzes = "SELECT id, title FROM quizzes WHERE author_id = ?";
$stmt_quizzes = $conn->prepare($sql_quizzes);
$stmt_quizzes->bind_param("i", $author_id);
$stmt_quizzes->execute();
$quizzes_result = $stmt_quizzes->get_result();

$quizzes = [];
while ($row = $quizzes_result->fetch_assoc()) {
    $quizzes[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Content Feedback - Quiz App</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Content Feedback</h1>
        <?php if (count($quizzes) > 0): ?>
            <?php foreach ($quizzes as $quiz): ?>
                <div class="feedback-section">
                    <h2>Feedback for: <?php echo htmlspecialchars($quiz['title']); ?></h2>
                    <?php
                    // Fetch feedback for the current quiz
                    $sql_feedback = "SELECT
                                        qf.feedback_text,
                                        u.full_name AS student_name,
                                        qf.created_at
                                     FROM
                                         quiz_feedback qf
                                     JOIN
                                         users u ON qf.student_id = u.id
                                     WHERE
                                         qf.quiz_id = ?
                                     ORDER BY
                                         qf.created_at DESC";
                    $stmt_feedback = $conn->prepare($sql_feedback);
                    $stmt_feedback->bind_param("i", $quiz['id']);
                    $stmt_feedback->execute();
                    $feedback_result = $stmt_feedback->get_result();
                    ?>
                    <?php if ($feedback_result->num_rows > 0): ?>
                        <div class="feedback-list">
                            <?php while ($feedback = $feedback_result->fetch_assoc()): ?>
                                <div class="feedback-item">
                                    <p class="feedback-text">"<?php echo nl2br(htmlspecialchars($feedback['feedback_text'])); ?>"</p>
                                    <p class="feedback-meta">
                                        — <?php echo htmlspecialchars($feedback['student_name']); ?> on <?php echo date("F j, Y, g:i a", strtotime($feedback['created_at'])); ?>
                                    </p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p class="no-data">No feedback yet for this quiz.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-data">You have not created any quizzes yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
