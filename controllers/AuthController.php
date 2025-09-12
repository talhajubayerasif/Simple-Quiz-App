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

    // Signup form and processing
    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect POST data
            $fullName = trim($_POST['full_name'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $gender   = $_POST['gender'] ?? '';
            $password = $_POST['password'] ?? '';

            // Basic validation
            if (empty($fullName) || empty($username) || empty($email) || empty($password) || empty($gender)) {
                $error = "All fields are required!";
                require __DIR__ . '/../views/register.php';
                return;
            }

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Generate a unique ID for user (you said id is auto-generated, so you can pass NULL)
            $id = null;

            // Create user
            $success = $this->userModel->create($id, $fullName, $username, $gender, $email, $hashedPassword);

            if ($success) {
                // Redirect to login page
                header("Location: /QuizApp/login");
                exit();
            } else {
                $error = "Signup failed! Username or email might already exist.";
                require __DIR__ . '/../views/register.php';
                return;
            }

        } else {
            // GET request: show signup form
            require __DIR__ . '/../views/register.php';
        }
    }

    // Login form
    public function login() {
        $error = null;
        require __DIR__ . '/../views/login.php';
    }

    // Process login
    public function authenticate() {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usernameOrEmail = trim($_POST['username_or_email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($usernameOrEmail) || empty($password)) {
                $error = "Please enter both username/email and password.";
                require __DIR__ . '/../views/login.php';
                return;
            }

            $user = $this->userModel->findByUsernameOrEmail($usernameOrEmail);

            if ($user && password_verify($password, $user['password'])) {
                // Store session
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['user_type'] = $user['user_type'] ?? 'student';

                // Redirect to dashboard
                header("Location: /QuizApp/dashboard");
                exit();
            } else {
                $error = "Invalid username/email or password!";
                require __DIR__ . '/../views/login.php';
                return;
            }

        } else {
            // GET request: show login form
            require __DIR__ . '/../views/login.php';
        }
    }

    // Logout user
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header("Location: /QuizApp/index");
        exit();
    }
}

