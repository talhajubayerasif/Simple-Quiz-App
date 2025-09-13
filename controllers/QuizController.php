<?php
require_once 'models/Quiz.php';
require_once 'models/Result.php';

class QuizController {
    public function takeQuiz() {
        $quizModel = new Quiz();
        $quizzes = $quizModel->getAvailableQuizzes();
        include 'views/quiz/take.php';
    }

    public function viewResults() {
        $resultModel = new Result();
        $results = $resultModel->getUserResults($_SESSION['user_id']);
        include 'views/quiz/results.php';
    }

    public function progress() {
        $resultModel = new Result();
        $progress = $resultModel->getProgress($_SESSION['user_id']);
        include 'views/quiz/progress.php';
    }
}
