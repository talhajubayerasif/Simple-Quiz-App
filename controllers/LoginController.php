<?php
require_once __DIR__ . '/../models/User.php';

class LoginController {
    public function index() {
        require_once __DIR__ . '/../views/login.php';
    }

    public function authenticate() {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usernameOrEmail = trim($_POST['username_or_email']);
            $password = trim($_POST['password']);

            $userModel = new User();
            $user = $userModel->getUserByUsernameOrEmail($usernameOrEmail);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php"); // redirect to home
                exit();
            } else {
                $error = "Invalid username/email or password!";
                require_once __DIR__ . '/../views/login.php';
            }
        }
    }
}