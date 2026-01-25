<?php
require_once 'config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $stmt = $pdo->prepare("SELECT image_path, content_type FROM product_images WHERE id = ?");
    $stmt->execute([$id]);
    $img = $stmt->fetch();
    
    if ($img && $img['image_path']) {
        $filepath = __DIR__ . '/uploads/' . $img['image_path'];
        if (file_exists($filepath)) {
            // content_type in DB might still be useful, or we can detect it
             header("Content-Type: " . ($img['content_type'] ?: mime_content_type($filepath)));
             readfile($filepath);
        } else {
            header("HTTP/1.0 404 Not Found");
        }
    } else {
        // Return a placeholder or 404
        header("HTTP/1.0 404 Not Found");
    }
}
?>
