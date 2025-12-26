<?php
// admin/products.php
require_once '../config/db.php';
require_once 'auth_check.php';

$action = $_GET['action'] ?? 'list';
$pageTitle = 'Manage Products';
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($action == 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    setFlash('success', 'Product deleted successfully');
    redirect('products.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $title = cleanInput($_POST['title']);
    $short_desc = cleanInput($_POST['short_desc']);
    $description = $_POST['description']; // Allow HTML? Let's keep it simple for now, raw
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    
    // Slug generation
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

    // Image Upload Handling
    // We now store images in `product_images` table as BLOB
    
    // Process new uploads if any
    $uploaded_image_ids = [];

    if (!empty($_FILES['images']['name'][0])) {
        foreach($_FILES['images']['name'] as $key => $name) {
            if ($_FILES['images']['error'][$key] == 0) {
                $tmp_name = $_FILES['images']['tmp_name'][$key];
                $type = mime_content_type($tmp_name);
                
                // Read binary data
                $data = file_get_contents($tmp_name);
                
                // We need the product ID to insert.
                // If creating ($id is null), we must insert product first, then images. 
                // We'll handle this insertion down below or re-structure.
                // A better approach: gather data, then insert/update.
                
                // Temporary solution: Store in array to insert AFTER product ID is known/confirmed
                $uploaded_image_ids[] = [
                    'data' => $data,
                    'type' => $type
                ];
            }
        }
    }
    
    // Existing images logic - previously filenames in JSON.
    // If we migrate fully, we might stop using existing_images JSON for new items, 
    // but for now, let's keep the JSON structure for backward compatibility or refactor.
    // Actually, the prompt implies "save in db NOT in local".
    // So for new products, we rely on the DB.
    // For existing products, we might have mixed state.
    
    // If updating, we keep existing JSON? 
    // Let's assume we are moving towards DB-only for display.
    // But `products` table still has `images_json`. We can leave it empty or store IDs.
    
    // Let's update the logic:
    // 1. Insert/Update Product
    // 2. Insert Images linked to Product ID
    
    // Re-organize the flow:
    if ($id) {
        // Update
        $sql = "UPDATE products SET title=?, slug=?, short_desc=?, description=?, price=?, category_id=? WHERE id=?"; // removed images_json update for now or keep separate?
        // Let's keep updating images_json for legacy/fallback support if using IDs there?
        // Let's just update the main fields first.
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $slug, $short_desc, $description, $price, $category_id, $id]);
        $product_id = $id;
        setFlash('success', 'Product updated successfully');
    } else {
        // Create
        // We initialize images_json as empty array for now
        $sql = "INSERT INTO products (title, slug, short_desc, description, price, category_id, images_json) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $slug, $short_desc, $description, $price, $category_id, '[]']);
        $product_id = $pdo->lastInsertId();
        setFlash('success', 'Product created successfully');
    }

    // Now insert images
    if (!empty($uploaded_image_ids)) {
        $stmt_img = $pdo->prepare("INSERT INTO product_images (product_id, image_data, content_type) VALUES (?, ?, ?)");
        foreach ($uploaded_image_ids as $img_data) {
            $stmt_img->execute([$product_id, $img_data['data'], $img_data['type']]);
        }
    }
    
    // We should also look at how to maintain the `images_json` if we want to display references?
    // Or we update the query in fetching pages to join `product_images`.
    // Let's update `images_json` with the NEW IDs just as a quick reference if that helps refactoring?
    // Actually, better to decouple. Let's redirect and fix display logic.
    
    redirect('products.php');
}

// Fetch single product for edit
$product = null;
$product_images = [];
if ($action == 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch();
    
    // Fetch images
    $stmt_img = $pdo->prepare("SELECT id FROM product_images WHERE product_id = ?");
    $stmt_img->execute([$_GET['id']]);
    $product_images = $stmt_img->fetchAll(PDO::FETCH_COLUMN);
}

include 'includes/header.php';
?>

<?php if ($action == 'create' || $action == 'edit'): ?>
    <div class="card" style="background:#fff; padding:20px; border-radius:8px;">
        <h3><?php echo $action == 'edit' ? 'Edit Product' : 'Add New Product'; ?></h3>
        <form method="POST" enctype="multipart/form-data">
            <?php if ($product): ?><input type="hidden" name="id" value="<?php echo $product['id']; ?>"><?php endif; ?>
            
            <div style="margin-bottom:15px;">
                <label>Title</label>
                <input type="text" name="title" value="<?php echo $product['title'] ?? ''; ?>" required style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:15px;">
                <label>Category</label>
                <select name="category_id" required style="width:100%; padding:8px;">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo ($product && $product['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                            <?php echo $cat['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div style="margin-bottom:15px;">
                <label>Price (₹)</label>
                <input type="number" step="0.01" name="price" value="<?php echo $product['price'] ?? ''; ?>" style="width:100%; padding:8px;">
            </div>
            
            <div style="margin-bottom:15px;">
                <label>Short Description (for cards)</label>
                <input type="text" name="short_desc" value="<?php echo $product['short_desc'] ?? ''; ?>" style="width:100%; padding:8px;">
            </div>
            
            <div style="margin-bottom:15px;">
                <label>Full Description</label>
                <textarea name="description" rows="5" style="width:100%; padding:8px;"><?php echo $product['description'] ?? ''; ?></textarea>
            </div>
            
            <div style="margin-bottom:15px;">
                <label>Images</label>
                <input type="file" name="images[]" multiple accept="image/*">
                
                <?php if (!empty($product_images)): ?>
                    <div style="margin-top:10px; display:flex; gap:10px;">
                        <?php foreach($product_images as $img_id): ?>
                            <div style="position:relative;">
                                <img src="../view_image.php?id=<?php echo $img_id; ?>" width="60" style="border:1px solid #ddd;">
                                <!-- Simple delete checkbox logic could be added here later -->
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php elseif ($product && !empty($product['images_json']) && $product['images_json'] != '[]'): ?>
                    <!-- Fallback for legacy file-based images -->
                    <div style="margin-top:10px; display:flex; gap:10px;">
                         <?php foreach(json_decode($product['images_json']) as $img): ?>
                            <div style="position:relative;">
                                <img src="../uploads/<?php echo $img; ?>" width="60" style="border:1px solid #ddd;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary">Save Product</button>
            <a href="products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
<?php else: ?>
    <div style="margin-bottom:20px; text-align:right;">
        <a href="products.php?action=create" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Updated query to fetch a thumbnail from DB if available
            $stmt = $pdo->query("SELECT p.*, c.name as category_name, (SELECT id FROM product_images WHERE product_id = p.id LIMIT 1) as thumb_id FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC");
            while ($row = $stmt->fetch()):
                $thumb_src = "../assets/images/logo.png"; // Default placeholder
                if ($row['thumb_id']) {
                    $thumb_src = "../view_image.php?id=" . $row['thumb_id'];
                } elseif (!empty($row['images_json']) && $row['images_json'] != '[]') {
                    // Fallback to legacy
                    $imgs = json_decode($row['images_json']);
                    if (!empty($imgs)) {
                        $thumb_src = "../uploads/" . $imgs[0];
                    }
                }
            ?>
            <tr>
                <td><img src="<?php echo $thumb_src; ?>" class="img-thumb" alt=""></td>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['category_name']; ?></td>
                <td><?php echo formatPrice($row['price']); ?></td>
                <td>
                    <a href="products.php?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                    <a href="products.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
