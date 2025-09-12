<?php
require_once __DIR__ . '/../config/database.php';

class UserController {
    private function ensureSession() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
            header("Location: /QuizApp/login");
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
}
