<?php
require_once 'config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $stmt = $pdo->prepare("SELECT image_data, content_type FROM product_images WHERE id = ?");
    $stmt->execute([$id]);
    $img = $stmt->fetch();
    
    if ($img) {
        header("Content-Type: " . $img['content_type']);
        echo $img['image_data'];
    } else {
        // Return a placeholder or 404
        header("HTTP/1.0 404 Not Found");
    }
}
?>
