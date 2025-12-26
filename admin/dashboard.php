<?php
// admin/dashboard.php
require_once '../config/db.php';
require_once 'auth_check.php';

// Fetch stats
$productCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$orderCount = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$pendingOrders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();

include 'includes/header.php';
?>

<div class="dashboard-content">
    <h1>Dashboard</h1>
    
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Products</h3>
            <p class="number"><?php echo $productCount; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Orders</h3>
            <p class="number"><?php echo $orderCount; ?></p>
        </div>
        <div class="stat-card warning">
            <h3>Pending Orders</h3>
            <p class="number"><?php echo $pendingOrders; ?></p>
        </div>
    </div>
    
    <div class="recent-actions">
        <h2>Quick Actions</h2>
        <a href="products.php?action=add" class="btn btn-primary">Add New Product</a>
        <a href="orders.php" class="btn btn-secondary">View Orders</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
