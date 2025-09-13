<?php
class Result {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getUserResults($studentId) {
        $stmt = $this->db->prepare("SELECT * FROM results WHERE student_id = ?");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProgress($studentId) {
        $stmt = $this->db->prepare("SELECT quiz_id, score, attempted_at FROM results WHERE student_id = ?");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
