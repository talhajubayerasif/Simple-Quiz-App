<?php
class DashboardController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /QuizApp/login");
            exit();
        }
        $username = $_SESSION['username'];
        $role = $_SESSION['user_type'];

        include 'views/dashboard/index.php';
    }
}
