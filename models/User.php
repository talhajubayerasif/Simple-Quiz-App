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
    }
}
