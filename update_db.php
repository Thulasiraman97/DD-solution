<?php
require 'config/db.php';

try {
    echo "Connected to: " . $pdo->query('select database()')->fetchColumn() . "\n";
    
    // Check if column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM products LIKE 'actual_price'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE products ADD COLUMN actual_price DECIMAL(10,2) DEFAULT NULL AFTER price");
        echo "Added actual_price column.\n";
    } else {
        echo "actual_price column already exists.\n";
    }

    $stmt = $pdo->query("SHOW COLUMNS FROM products LIKE 'specs_json'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE products ADD COLUMN specs_json LONGTEXT DEFAULT NULL AFTER actual_price");
        echo "Added specs_json column.\n";
    } else {
        echo "specs_json column already exists.\n";
    }
    
    echo "Database updated successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
