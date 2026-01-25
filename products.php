<?php
// products.php
$pageTitle = 'Products';
include 'includes/header.php';

$category_slug = $_GET['category'] ?? null;
$whereSQL = "";
$params = [];

if ($category_slug) {
    $whereSQL = "WHERE c.slug = ?";
    $params[] = $category_slug;
}

// Fetch Categories for sidebar
$cats = $pdo->query("SELECT * FROM categories")->fetchAll();

// Fetch Products
$sql = "SELECT p.*, c.name as category_name, (SELECT id FROM product_images WHERE product_id = p.id LIMIT 1) as thumb_id FROM products p JOIN categories c ON p.category_id = c.id $whereSQL ORDER BY p.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<div class="container section-padding" style="max-width: 1400px;">
    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
        <!-- Sidebar -->
        <aside style="flex: 0 0 280px; min-width: 280px;">
            <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); position: sticky; top: 100px;">
                <h3 style="margin-bottom: 25px; padding-bottom: 15px; border-bottom: 3px solid #667eea; font-size: 1.4rem; color: #1a1a2e; font-weight: 700;">Categories</h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 12px;">
                        <a href="products.php" style="display: block; padding: 12px 15px; text-decoration: none; color: <?php echo !$category_slug ? 'white' : '#666'; ?>; background: <?php echo !$category_slug ? 'linear-gradient(135deg, #667eea, #764ba2)' : 'transparent'; ?>; border-radius: 10px; transition: all 0.3s; font-weight: <?php echo !$category_slug ? '600' : '500'; ?>;" onmouseover="if(!'<?php echo !$category_slug; ?>') { this.style.background='#f8f9fa'; this.style.paddingLeft='20px'; }" onmouseout="if(!'<?php echo !$category_slug; ?>') { this.style.background='transparent'; this.style.paddingLeft='15px'; }">
                            <i class="fas fa-th-large" style="margin-right: 10px;"></i>All Products
                        </a>
                    </li>
                    <?php foreach ($cats as $cat): ?>
                    <li style="margin-bottom: 12px;">
                        <a href="products.php?category=<?php echo $cat['slug']; ?>" style="display: block; padding: 12px 15px; text-decoration: none; color: <?php echo $category_slug == $cat['slug'] ? 'white' : '#666'; ?>; background: <?php echo $category_slug == $cat['slug'] ? 'linear-gradient(135deg, #667eea, #764ba2)' : 'transparent'; ?>; border-radius: 10px; transition: all 0.3s; font-weight: <?php echo $category_slug == $cat['slug'] ? '600' : '500'; ?>;" onmouseover="if('<?php echo $category_slug != $cat['slug']; ?>') { this.style.background='#f8f9fa'; this.style.paddingLeft='20px'; }" onmouseout="if('<?php echo $category_slug != $cat['slug']; ?>') { this.style.background='transparent'; this.style.paddingLeft='15px'; }">
                            <i class="fas fa-folder" style="margin-right: 10px;"></i><?php echo $cat['name']; ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>
        
        <!-- Product Grid -->
        <main style="flex: 3; min-width: 300px;">
            <h2 style="margin-bottom: 20px;"><?php echo $category_slug ? ucwords(str_replace('-', ' ', $category_slug)) : 'All Products'; ?></h2>
            
            <?php if (count($products) > 0): ?>
                <div class="product-grid">
                    <?php foreach ($products as $key => $prod): 
                        $thumb = "assets/images/logo.png"; // Default
                        if ($prod['thumb_id']) {
                            $thumb = "view_image.php?id=" . $prod['thumb_id'];
                        } elseif (!empty($prod['images_json']) && $prod['images_json'] != '[]') {
                            // Fallback
                            $imgs = json_decode($prod['images_json']);
                            if (!empty($imgs)) {
                                $thumb = "uploads/" . $imgs[0];
                            }
                        }
                    ?>
                    <div class="product-card" data-aos="fade-up" data-aos-delay="<?php echo $key * 100; ?>">
                        <div class="product-img">
                            <img src="<?php echo $thumb; ?>" alt="<?php echo $prod['title']; ?>">
                        </div>
                        <div class="product-body" style="padding: 20px;">
                    <span class="product-cat" style="color: #667eea; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;"><?php echo $prod['category_name']; ?></span>
                    <h3 style="margin: 10px 0; font-size: 1.2rem; color: #1a1a2e;"><?php echo $prod['title']; ?></h3>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                        <div class="price-wrap">
                        <?php if (!empty($prod['actual_price']) && $prod['actual_price'] > $prod['price']): ?>
                            <span class="actual-price" style="text-decoration: line-through; color: #999; font-size: 0.9rem; margin-right: 5px;"><?php echo formatPrice($prod['actual_price']); ?></span>
                        <?php endif; ?>
                        <span class="product-price" style="font-size: 1.3rem; font-weight: 700; color: #2d3436;"><?php echo formatPrice($prod['price']); ?></span>
                    </div>
                        <a href="product_details.php?id=<?php echo $prod['id']; ?>" class="btn-sm" style="padding: 8px 15px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 8px; text-decoration: none; font-size: 0.9rem; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">Buy Now</a>
                    </div>
                </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No products found in this category.</p>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
