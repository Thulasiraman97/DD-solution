<?php
/**
 * Database Migration Script
 * Run this ONCE on Hostinger to fix the database schema issues
 * 
 * This script will:
 * 1. Add missing 'actual_price' column to products table
 * 2. Ensure product_images table exists with correct schema
 * 3. Display detailed error messages if anything fails
 */

require_once 'config/db.php';

echo "<!DOCTYPE html><html><head><title>Database Fix</title>";
echo "<style>body{font-family:Arial;padding:20px;background:#f5f5f5;}";
echo ".success{color:green;padding:10px;background:#d4edda;border:1px solid green;margin:10px 0;border-radius:5px;}";
echo ".error{color:red;padding:10px;background:#f8d7da;border:1px solid red;margin:10px 0;border-radius:5px;}";
echo ".info{color:blue;padding:10px;background:#d1ecf1;border:1px solid blue;margin:10px 0;border-radius:5px;}";
echo "</style></head><body>";
echo "<h1>Database Migration Script</h1>";

$errors = [];
$success = [];

// Step 1: Check if actual_price column exists
echo "<h2>Step 1: Checking 'actual_price' column...</h2>";
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM products LIKE 'actual_price'");
    $column_exists = $stmt->fetch();
    
    if (!$column_exists) {
        echo "<div class='info'>Column 'actual_price' does not exist. Adding it now...</div>";
        
        // Add the column after 'price'
        $pdo->exec("ALTER TABLE products ADD COLUMN actual_price DECIMAL(10,2) DEFAULT NULL AFTER price");
        
        $success[] = "✓ Successfully added 'actual_price' column to products table";
        echo "<div class='success'>{$success[count($success)-1]}</div>";
    } else {
        $success[] = "✓ Column 'actual_price' already exists";
        echo "<div class='success'>{$success[count($success)-1]}</div>";
    }
} catch (PDOException $e) {
    $errors[] = "✗ Error checking/adding actual_price column: " . $e->getMessage();
    echo "<div class='error'>{$errors[count($errors)-1]}</div>";
}

// Step 2: Check if product_images table exists with correct schema
echo "<h2>Step 2: Checking 'product_images' table...</h2>";
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'product_images'");
    $table_exists = $stmt->fetch();
    
    if (!$table_exists) {
        echo "<div class='info'>Table 'product_images' does not exist. Creating it now...</div>";
        
        // Create the table with correct schema (using image_path, NOT image_data)
        $sql = "CREATE TABLE product_images (
            id INT(11) NOT NULL AUTO_INCREMENT,
            product_id INT(11) NOT NULL,
            image_path VARCHAR(255) NOT NULL,
            content_type VARCHAR(50) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY product_id (product_id),
            CONSTRAINT product_images_ibfk_1 FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        
        $pdo->exec($sql);
        
        $success[] = "✓ Successfully created 'product_images' table";
        echo "<div class='success'>{$success[count($success)-1]}</div>";
    } else {
        echo "<div class='info'>Table 'product_images' exists. Checking schema...</div>";
        
        // Check if it has the correct columns
        $stmt = $pdo->query("SHOW COLUMNS FROM product_images");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo "<div class='info'>Current columns: " . implode(', ', $columns) . "</div>";
        
        // Check if it has image_data (wrong) or image_path (correct)
        if (in_array('image_data', $columns)) {
            $errors[] = "✗ WARNING: Table has 'image_data' column (BLOB storage). Expected 'image_path' column (file path storage).";
            echo "<div class='error'>{$errors[count($errors)-1]}</div>";
            echo "<div class='error'>⚠️ You need to manually migrate this table or drop and recreate it.</div>";
        } elseif (in_array('image_path', $columns)) {
            $success[] = "✓ Table 'product_images' has correct schema (image_path column)";
            echo "<div class='success'>{$success[count($success)-1]}</div>";
        } else {
            $errors[] = "✗ Table 'product_images' has unexpected schema";
            echo "<div class='error'>{$errors[count($errors)-1]}</div>";
        }
    }
} catch (PDOException $e) {
    $errors[] = "✗ Error checking/creating product_images table: " . $e->getMessage();
    echo "<div class='error'>{$errors[count($errors)-1]}</div>";
}

// Step 3: Verify uploads directory exists
echo "<h2>Step 3: Checking 'uploads' directory...</h2>";
$uploads_dir = __DIR__ . '/uploads';
if (!is_dir($uploads_dir)) {
    echo "<div class='info'>Creating uploads directory...</div>";
    if (mkdir($uploads_dir, 0755, true)) {
        $success[] = "✓ Created uploads directory";
        echo "<div class='success'>{$success[count($success)-1]}</div>";
    } else {
        $errors[] = "✗ Failed to create uploads directory";
        echo "<div class='error'>{$errors[count($errors)-1]}</div>";
    }
} else {
    $success[] = "✓ Uploads directory exists";
    echo "<div class='success'>{$success[count($success)-1]}</div>";
    
    // Check permissions
    if (is_writable($uploads_dir)) {
        $success[] = "✓ Uploads directory is writable";
        echo "<div class='success'>{$success[count($success)-1]}</div>";
    } else {
        $errors[] = "✗ Uploads directory is NOT writable. Change permissions to 755 or 777";
        echo "<div class='error'>{$errors[count($errors)-1]}</div>";
    }
}

// Summary
echo "<h2>Migration Summary</h2>";
echo "<h3>Successful Operations (" . count($success) . "):</h3>";
foreach ($success as $msg) {
    echo "<div class='success'>$msg</div>";
}

if (!empty($errors)) {
    echo "<h3>Errors/Warnings (" . count($errors) . "):</h3>";
    foreach ($errors as $msg) {
        echo "<div class='error'>$msg</div>";
    }
    echo "<div class='error'><strong>⚠️ Please fix the errors above before uploading products.</strong></div>";
} else {
    echo "<div class='success'><strong>✓ All checks passed! Your database is ready for product uploads.</strong></div>";
}

echo "<hr><p><a href='admin/products.php'>Go to Products Admin</a> | <a href='index.php'>Go to Homepage</a></p>";
echo "</body></html>";
?>
