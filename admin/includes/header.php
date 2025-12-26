<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - DD Solutions</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Admin Specific Styles */
        body.admin-body { display: flex; min-height: 100vh; background: #f4f7f6; }
        .sidebar { width: 250px; background: #2c3e50; color: #ecf0f1; display: flex; flex-direction: column; }
        .sidebar .brand { padding: 20px; font-size: 1.5rem; text-align: center; background: #1a252f; }
        .sidebar nav a { display: block; padding: 15px 20px; color: #bdc3c7; text-decoration: none; transition: 0.3s; }
        .sidebar nav a:hover, .sidebar nav a.active { background: #34495e; color: #fff; }
        .sidebar nav a i { margin-right: 10px; width: 20px; text-align: center; }
        .main-content { flex: 1; padding: 20px; overflow-y: auto; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); text-align: center; }
        .stat-card h3 { font-size: 0.9rem; color: #7f8c8d; }
        .stat-card .number { font-size: 2rem; font-weight: bold; color: #2c3e50; margin: 10px 0 0; }
        .stat-card.warning .number { color: #e67e22; }

        .btn { padding: 8px 15px; border-radius: 4px; text-decoration: none; display: inline-block; font-size: 0.9rem; cursor: pointer; border: none; }
        .btn-primary { background: #3498db; color: #fff; }
        .btn-secondary { background: #95a5a6; color: #fff; }
        .btn-danger { background: #e74c3c; color: #fff; }
        .btn-success { background: #2ecc71; color: #fff; }
        
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; font-weight: 600; color: #2c3e50; }
        tr:hover { background: #f1f1f1; }
        .img-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }
    </style>
</head>
<body class="admin-body">

<div class="sidebar">
    <div class="brand">DD Admin</div>
    <nav>
        <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>"><i class="fas fa-home"></i> Dashboard</a>
        <a href="products.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>"><i class="fas fa-box"></i> Products</a>
        <a href="orders.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : ''; ?>"><i class="fas fa-shopping-cart"></i> Orders</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
</div>

<div class="main-content">
    <div class="top-bar">
        <h2><?php echo isset($pageTitle) ? $pageTitle : 'Admin Panel'; ?></h2>
        <div class="user-info">Logged in as: <?php echo $_SESSION['admin_email'] ?? 'Admin'; ?></div>
    </div>
    
    <?php if ($flash = getFlash()): ?>
        <div class="alert alert-<?php echo $flash['type']; ?>" style="padding: 10px; margin-bottom: 20px; border-radius: 4px; color: #fff; background: <?php echo $flash['type'] == 'success' ? '#2ecc71' : '#e74c3c'; ?>;">
            <?php echo $flash['message']; ?>
        </div>
    <?php endif; ?>
