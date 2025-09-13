<?php
class User {

    private $db;
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Create new user
    public function create($fullName, $username, $gender, $email, $password, $user_type = 'student'){
        $sql = "INSERT INTO users (full_name, username, gender, email, password, user_type) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ssssss", $fullName, $username, $gender, $email, $password, $user_type);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        return true;
    }

    // Get all users
    public function getAll() {
        $sql = "SELECT id, full_name, username, email, gender, user_type FROM users";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get user by ID
    public function getById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update user
    public function update($id, $fullName, $username, $gender, $email, $user_type) {
        $sql = "UPDATE users SET full_name=?, username=?, gender=?, email=?, user_type=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssi", $fullName, $username, $gender, $email, $user_type, $id);
        return $stmt->execute();
    }

    // Delete user
    public function delete($id) {
        $sql = "DELETE FROM users WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Find user by username OR email
    public function findByUsernameOrEmail($identifier){
        $sql = "SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ss", $identifier, $identifier);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();

    }

    //Update password
    public function updatePassword($userId, $newPassword){
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("si", $newPassword, $userId);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        return true;
    }
}
