<?php
require_once 'Database.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getCategories() {
        $stmt = $this->db->query("SELECT DISTINCT category FROM inventory ORDER BY category");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAllProducts() {
        $stmt = $this->db->query("SELECT * FROM inventory ORDER BY item_id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsByCategory($category) {
        $stmt = $this->db->prepare("SELECT * FROM inventory WHERE category = ? ORDER BY item_id");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT * FROM inventory WHERE item_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>