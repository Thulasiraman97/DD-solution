<?php
// product_details.php
require_once 'config/db.php';
require_once 'includes/functions.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    redirect('products.php');
}

$pageTitle = $product['title'];
include 'includes/header.php';
$stmt_img = $pdo->prepare("SELECT id FROM product_images WHERE product_id = ?");
$stmt_img->execute([$id]);
$product_images = $stmt_img->fetchAll(PDO::FETCH_COLUMN);

// Fallback to old images if no DB images found
if (empty($product_images) && !empty($product['images_json']) && $product['images_json'] != '[]') {
    $legacy_images = json_decode($product['images_json']);
} else {
    $legacy_images = [];
}
?>

<div class="container section-padding">
    <div style="display: flex; gap: 50px; flex-wrap: wrap;">
        <!-- Image Gallery -->
        <div style="flex: 1; min-width: 300px;">
            <?php 
            $mainImg = "assets/images/logo.png";
            if (!empty($product_images)) {
                $mainImg = "view_image.php?id=" . $product_images[0];
            } elseif (!empty($legacy_images)) {
                $mainImg = "uploads/" . $legacy_images[0];
            }
            ?>
            <div style="border: 1px solid #eee; border-radius: 10px; overflow: hidden; margin-bottom: 20px;">
                <img id="mainImage" src="<?php echo $mainImg; ?>" alt="<?php echo $product['title']; ?>" style="width: 100%; display: block;">
            </div>
            <div style="display: flex; gap: 10px; overflow-x: auto;">
                <?php if (!empty($product_images)): ?>
                    <?php foreach ($product_images as $img_id): ?>
                    <img src="view_image.php?id=<?php echo $img_id; ?>" onclick="document.getElementById('mainImage').src=this.src" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px; cursor: pointer; border: 1px solid #ddd;">
                    <?php endforeach; ?>
                <?php elseif (!empty($legacy_images)): ?>
                    <?php foreach ($legacy_images as $img): ?>
                    <img src="uploads/<?php echo $img; ?>" onclick="document.getElementById('mainImage').src=this.src" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px; cursor: pointer; border: 1px solid #ddd;">
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Product Info -->
        <div style="flex: 1; min-width: 300px;">
            <span class="product-cat"><?php echo $product['category_name']; ?></span>
            <h1 style="font-size: 2.5rem; margin: 10px 0;"><?php echo $product['title']; ?></h1>
            <span style="font-size: 2rem; color: var(--accent); font-weight: 700;"><?php echo formatPrice($product['price']); ?></span>
            
            <p style="margin: 20px 0; color: #555;"><?php echo nl2br(htmlspecialchars($product['short_desc'])); ?></p>
            
            <div style="margin-bottom: 30px; padding: 20px; background: #f9f9f9; border-radius: 8px;">
                <form action="includes/cart_actions.php" method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1" max="100" style="padding: 8px; width: 80px; border-radius: 4px; border: 1px solid #ddd; margin-left: 10px;">
                    </div>
                    <button type="submit" class="btn"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                    <a href="https://api.whatsapp.com/send?phone=919025142474&text=I want to inquire about <?php echo urlencode($product['title']); ?>" target="_blank" class="btn btn-outline" style="border-color: #25D366; color: #25D366;"><i class="fab fa-whatsapp"></i> Inquire</a>
                </form>
            </div>
            
            <div class="tabs">
                <h3 style="border-bottom: 2px solid var(--accent); display: inline-block; margin-bottom: 15px;">Description</h3>
                <div style="line-height: 1.8;">
                    <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
