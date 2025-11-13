<?php
class Student {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    
    public function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS online_courses (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(100) NOT NULL,
            age INT NOT NULL,
            course VARCHAR(50) NOT NULL,
            payment VARCHAR(50) NOT NULL,
            certificate VARCHAR(10) NOT NULL,
            registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }


    public function add($full_name, $age, $course, $payment, $certificate) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO online_courses (full_name, age, course, payment, certificate) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$full_name, $age, $course, $payment, $certificate]);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM online_courses ORDER BY registration_date DESC");
        return $stmt->fetchAll();
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM online_courses WHERE id=?");
        $stmt->execute([$id]);
    }
}
?>