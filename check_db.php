<?php
require 'config/db.php';
try {
    echo "Connected to database: " . $pdo->query('select database()')->fetchColumn();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
