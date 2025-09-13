<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $db;
    private $userModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->userModel = new User($this->db);
    }

    private function ensureSession() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
            header("Location: /QuizApp/login");
            exit();
        }
    }

    private function ensureAdmin() {
        $this->ensureSession();
        if ($_SESSION['user_type'] !== 'admin') {
            http_response_code(403);
            echo "Access denied!";
            exit();
        }
    }

    public function dashboard() {
        $this->ensureSession();
        include __DIR__ . '/../views/dashboard.php';
    }

    public function profile() {
        $this->ensureSession();

        $db = (new Database())->getConnection();
        $stmt = $db->prepare("SELECT id, full_name, username, email, gender FROM users WHERE id = ?");
        if (!$stmt) die("Prepare failed: " . $db->error);

        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        include __DIR__ . '/../views/profile.php';
    }

    //Edit Profile
    public function editProfile() {
        $this->ensureSession();

        $db = (new Database())->getConnection();
        $stmt = $db->prepare("SELECT id, full_name, username, email, gender, user_type FROM users WHERE id = ?");
        if (!$stmt) die("Prepare failed: " . $db->error);

        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        include __DIR__ . '/../views/profile_edit.php';
    }


    public function updateProfile() {
        $this->ensureSession();

        $db = (new Database())->getConnection();
        $stmt = $db->prepare("UPDATE users SET full_name=?, username=?, email=?, gender=? WHERE id=?");
        if (!$stmt) die("Prepare failed: " . $db->error);

        $stmt->bind_param(
            "ssssi",
            $_POST['full_name'],
            $_POST['username'],
            $_POST['email'],
            $_POST['gender'],
            $_SESSION['user_id']
        );
        $stmt->execute();

        header("Location: /QuizApp/profile");
        exit();
    }

    public function deleteProfile() {
        $this->ensureSession();

        $db = (new Database())->getConnection();
        $stmt = $db->prepare("DELETE FROM users WHERE id=?");
        if (!$stmt) die("Prepare failed: " . $db->error);

        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();

        session_unset();
        session_destroy();

        header("Location: /QuizApp/index");
        exit();
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header("Location: /QuizApp/index");
        exit();
    }

    // === Manage Users (Admin only) ===
    public function listUsers() {
        $this->ensureAdmin();
        $users = $this->userModel->getAll();
        include __DIR__ . '/../views/manageusers.php';
    }

    public function createUser() {
        $this->ensureAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $this->userModel->create($_POST['full_name'], $_POST['username'], $_POST['gender'], $_POST['email'], $hashedPassword, $_POST['user_type']);
            header("Location: /QuizApp/users");
            exit();
        } else {
            include __DIR__ . '/../views/admin/user_create.php';
        }
    }

    public function editUser($id) {
        $this->ensureAdmin();
        $user = $this->userModel->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->update($id, $_POST['full_name'], $_POST['username'], $_POST['gender'], $_POST['email'], $_POST['user_type']);
            header("Location: /QuizApp/addusers");
            exit();
        } else {
            include __DIR__ . '/../views/admin/addusers.php';
        }
    }

    public function deleteUser($id) {
        $this->ensureAdmin();
        $this->userModel->delete($id);
        header("Location: /QuizApp/manageusers");
        exit();
    }
}