<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'quiz_author') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Author Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Add a New Quiz Question</h2>
        <form id="add-question-form">
            <label for="quiz-title">Quiz Title:</label>
            <input type="text" id="quiz-title" name="quiz_title" required>

            <label for="question-text">Question:</label>
            <textarea id="question-text" name="question_text" rows="4" required></textarea>

            <div class="options-input">
                <label for="option-a">Option A:</label>
                <input type="text" id="option-a" name="option_a" required>

                <label for="option-b">Option B:</label>
                <input type="text" id="option-b" name="option_b" required>

                <label for="option-c">Option C:</label>
                <input type="text" id="option-c" name="option_c" required>

                <label for="option-d">Option D:</label>
                <input type="text" id="option-d" name="option_d" required>
            </div>

            <label for="correct-option">Correct Answer:</label>
            <select id="correct-option" name="correct_option" required>
                <option value="">Select correct option</option>
                <option value="option_a">Option A</option>
                <option value="option_b">Option B</option>
                <option value="option_c">Option C</option>
                <option value="option_d">Option D</option>
            </select>

            <button type="submit">Add Question</button>
        </form>
        <p id="response-message"></p>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('add-question-form');
            const responseMessage = document.getElementById('response-message');

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(form);

                try {
                    const response = await fetch('add_question.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.text();
                    responseMessage.textContent = result;
                    responseMessage.style.color = 'green';

                    if (result.includes("Question added successfully")) {
                        form.reset();
                    }
                } catch (error) {
                    responseMessage.textContent = 'An error occurred. Please try again.';
                    responseMessage.style.color = 'red';
                }
            });
        });
    </script>
</body>
</html>
