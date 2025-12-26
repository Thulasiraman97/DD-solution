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
    $images = [];
    $existing_images = isset($_POST['existing_images']) ? $_POST['existing_images'] : [];
    
    // Preserve existing images if editing
    $images = $existing_images;

    if (!empty($_FILES['images']['name'][0])) {
        $target_dir = "../uploads/";
        foreach($_FILES['images']['name'] as $key => $name) {
            if ($_FILES['images']['error'][$key] == 0) {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $filename = uniqid() . "." . $ext;
                if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_dir . $filename)) {
                    $images[] = $filename;
                }
            }
        }
    }
    
    $images_json = json_encode(array_values($images));

    if ($id) {
        // Update
        $sql = "UPDATE products SET title=?, slug=?, short_desc=?, description=?, price=?, category_id=?, images_json=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $slug, $short_desc, $description, $price, $category_id, $images_json, $id]);
        setFlash('success', 'Product updated successfully');
    } else {
        // Create
        $sql = "INSERT INTO products (title, slug, short_desc, description, price, category_id, images_json) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $slug, $short_desc, $description, $price, $category_id, $images_json]);
        setFlash('success', 'Product created successfully');
    }
    redirect('products.php');
}

// Fetch single product for edit
$product = null;
if ($action == 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch();
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
                <?php if ($product && $product['images_json']): ?>
                    <div style="margin-top:10px; display:flex; gap:10px;">
                        <?php foreach(json_decode($product['images_json']) as $img): ?>
                            <div style="position:relative;">
                                <img src="../uploads/<?php echo $img; ?>" width="60" style="border:1px solid #ddd;">
                                <input type="hidden" name="existing_images[]" value="<?php echo $img; ?>">
                                <!-- Simple delete checkbox logic could be added here later -->
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
            $stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC");
            while ($row = $stmt->fetch()):
                $imgs = json_decode($row['images_json']);
                $thumb = !empty($imgs) ? "../uploads/" . $imgs[0] : "../assets/images/placeholder.png";
            ?>
            <tr>
                <td><img src="<?php echo $thumb; ?>" class="img-thumb" alt=""></td>
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
