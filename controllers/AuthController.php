<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new User($this->db);
    }

    // Show the signup form & handle POST submission
    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect and sanitize form data
            $id = uniqid("U"); // auto-generated user id
            $fullName = trim($_POST['full_name']);
            $username = trim($_POST['username']);
            $gender = $_POST['gender'];
            $email = trim($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            // Save user to database
            if ($this->userModel->create($id, $fullName, $username, $gender, $email, $password)) {
                // Redirect to index with success
                header("Location: /QuizApp/index.php?success=1");
                exit;
            } else {
                // Redirect to index with error
                header("Location: /QuizApp/index.php?error=1");
                exit;
            }
        } else {
            // Show signup form
            require __DIR__ . '/../views/register.php';
        }
    }

    // Show the login form
    public function login() {
        require __DIR__ . '/../views/login.php';
    }

    // Process login
    public function authenticate() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usernameOrEmail = trim($_POST['username_or_email']);
            $password = trim($_POST['password']);

            $user = $this->userModel->findByUsernameOrEmail($usernameOrEmail);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: /QuizApp/index.php");
                exit();
            } else {
                $error = "Invalid username/email or password!";
                require __DIR__ . '/../views/login.php';
            }
        }
    }
}
?>
