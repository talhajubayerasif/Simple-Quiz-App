<?php
class Quiz {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAvailableQuizzes() {
        $stmt = $this->db->query("SELECT * FROM quizzes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
