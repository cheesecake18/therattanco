<?php
require_once 'Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function register($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $hashedPassword])) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateEmail($id, $email) {
        $stmt = $this->db->prepare("UPDATE users SET email = ? WHERE id = ?");
        return $stmt->execute([$email, $id]);
    }

    public function updatePassword($id, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashedPassword, $id]);
    }

    public function updateAddress($id, $province, $city, $barangay, $street, $type = 'default') {
        $columns = $type === 'alt' ? 'alt_province, alt_city, alt_barangay, alt_street' : 'default_province, default_city, default_barangay, default_street';
        $stmt = $this->db->prepare("UPDATE users SET $columns = ?, ?, ?, ? WHERE id = ?");
        return $stmt->execute([$province, $city, $barangay, $street, $id]);
    }

    public function updateContact($id, $contact) {
        $stmt = $this->db->prepare("UPDATE users SET contact = ? WHERE id = ?");
        return $stmt->execute([$contact, $id]);
    }

    public function updateLastPayment($id, $payment) {
        $stmt = $this->db->prepare("UPDATE users SET last_payment = ? WHERE id = ?");
        return $stmt->execute([$payment, $id]);
    }
}
?>