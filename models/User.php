<?php
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($id, $fullName, $username, $gender, $email, $password) {
        $query = "INSERT INTO users (id, full_name, username, gender, email, password) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ssssss", $id, $fullName, $username, $gender, $email, $password);
        return $stmt->execute();
    }

    public function findByUsernameOrEmail($usernameOrEmail) {
        $query = "SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
