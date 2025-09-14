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

// Get the quiz ID from the URL. If not provided, list all quizzes.
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : null;

function getQuizPerformance($conn, $quiz_id) {
    $sql = "SELECT
                q.id AS question_id,
                q.question_text,
                COUNT(sqa.id) AS total_attempts,
                SUM(CASE WHEN sqa.is_correct = 1 THEN 1 ELSE 0 END) AS correct_answers,
                (SUM(CASE WHEN sqa.is_correct = 1 THEN 1 ELSE 0 END) / COUNT(sqa.id)) * 100 AS success_rate
            FROM
                questions q
            LEFT JOIN
                student_quiz_answers sqa ON q.id = sqa.question_id
            WHERE
                q.quiz_id = ?
            GROUP BY
                q.id
            ORDER BY
                success_rate DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    return $stmt->get_result();
}

function getQuizTitle($conn, $quiz_id) {
    $stmt = $conn->prepare("SELECT title FROM quizzes WHERE id = ?");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['title'] ?? 'Unknown Quiz';
}

function listAllQuizzes($conn) {
    $sql = "SELECT id, title FROM quizzes ORDER BY title";
    $result = $conn->query($sql);
    return $result;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Analytics - Quiz App</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Quiz Analytics</h1>
        <?php if ($quiz_id): ?>
            <?php
            $quiz_title = getQuizTitle($conn, $quiz_id);
            $analytics_result = getQuizPerformance($conn, $quiz_id);
            ?>
            <h2>Analytics for: <?php echo htmlspecialchars($quiz_title); ?></h2>
            <?php if ($analytics_result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Total Attempts</th>
                            <th>Correct Answers</th>
                            <th>Success Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $analytics_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['question_text']); ?></td>
                                <td><?php echo htmlspecialchars($row['total_attempts']); ?></td>
                                <td><?php echo htmlspecialchars($row['correct_answers']); ?></td>
                                <td>
                                    <div class="bar-container">
                                        <div class="success-bar" style="width: <?php echo $row['success_rate']; ?>%;"></div>
                                    </div>
                                    <span class="bar-label"><?php echo number_format($row['success_rate'], 2); ?>%</span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-data">No data available for this quiz. Students may not have attempted it yet.</p>
            <?php endif; ?>
            <p><a href="quiz_level_analytics.php">← Back to Quiz List</a></p>
        <?php else: ?>
            <h2>Select a Quiz to Analyze</h2>
            <?php
            $quizzes = listAllQuizzes($conn);
            if ($quizzes->num_rows > 0): ?>
                <ul class="quiz-list">
                    <?php while ($row = $quizzes->fetch_assoc()): ?>
                        <li>
                            <a href="quiz_level_analytics.php?quiz_id=<?php echo htmlspecialchars($row['id']); ?>">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="no-data">No quizzes found.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
