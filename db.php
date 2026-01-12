<?php
require_once 'classes/Database.php';

// For backward compatibility, set $pdo
$pdo = Database::getInstance()->getConnection();
?>