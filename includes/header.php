<!-- includes/header.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

$cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'DD Solutions'; ?> - DD Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/particles.js" defer></script>
</head>
<body>

<!-- Premium Header -->
<header style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); position: sticky; top: 0; z-index: 999; box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08); border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">
        <nav style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0;">
            
            <!-- Logo Section -->
            <div class="logo">
                <a href="index.php" style="display: block;">
                    <img src="assets/images/logo.png" alt="DD Solutions" style="height: 40px;">
                </a>
            </div>

            <!-- Navigation Links -->
            <ul style="display: flex; gap: 35px; list-style: none; margin: 0; padding: 0; align-items: center;">
                <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
                
                <li>
                    <a href="index.php" class="<?php echo $currentPage == 'index.php' ? 'active-link' : ''; ?>" style="color: <?php echo $currentPage == 'index.php' ? '#667eea' : '#1a1a2e'; ?>; text-decoration: none; font-weight: 500; font-size: 1rem; transition: all 0.3s; position: relative; padding: 8px 0;" onmouseover="this.style.color='#667eea'; this.querySelector('.nav-underline').style.width='100%'" onmouseout="if(!this.classList.contains('active-link')) { this.style.color='#1a1a2e'; this.querySelector('.nav-underline').style.width='0'; }">
                        <i class="fas fa-home" style="margin-right: 6px;"></i>Home
                        <span class="nav-underline" style="position: absolute; bottom: 0; left: 0; width: <?php echo $currentPage == 'index.php' ? '100%' : '0'; ?>; height: 2px; background: linear-gradient(90deg, #667eea, #764ba2); transition: width 0.3s;"></span>
                    </a>
                </li>
                <li>
                    <a href="products.php" class="<?php echo $currentPage == 'products.php' ? 'active-link' : ''; ?>" style="color: <?php echo $currentPage == 'products.php' ? '#667eea' : '#1a1a2e'; ?>; text-decoration: none; font-weight: 500; font-size: 1rem; transition: all 0.3s; position: relative; padding: 8px 0;" onmouseover="this.style.color='#667eea'; this.querySelector('.nav-underline').style.width='100%'" onmouseout="if(!this.classList.contains('active-link')) { this.style.color='#1a1a2e'; this.querySelector('.nav-underline').style.width='0'; }">
                        <i class="fas fa-box" style="margin-right: 6px;"></i>Products
                        <span class="nav-underline" style="position: absolute; bottom: 0; left: 0; width: <?php echo $currentPage == 'products.php' ? '100%' : '0'; ?>; height: 2px; background: linear-gradient(90deg, #667eea, #764ba2); transition: width 0.3s;"></span>
                    </a>
                </li>
                <li>
                    <a href="services.php" class="<?php echo $currentPage == 'services.php' ? 'active-link' : ''; ?>" style="color: <?php echo $currentPage == 'services.php' ? '#667eea' : '#1a1a2e'; ?>; text-decoration: none; font-weight: 500; font-size: 1rem; transition: all 0.3s; position: relative; padding: 8px 0;" onmouseover="this.style.color='#667eea'; this.querySelector('.nav-underline').style.width='100%'" onmouseout="if(!this.classList.contains('active-link')) { this.style.color='#1a1a2e'; this.querySelector('.nav-underline').style.width='0'; }">
                        <i class="fas fa-cogs" style="margin-right: 6px;"></i>Services
                        <span class="nav-underline" style="position: absolute; bottom: 0; left: 0; width: <?php echo $currentPage == 'services.php' ? '100%' : '0'; ?>; height: 2px; background: linear-gradient(90deg, #667eea, #764ba2); transition: width 0.3s;"></span>
                    </a>
                </li>
                <li>
                    <a href="about.php" class="<?php echo $currentPage == 'about.php' ? 'active-link' : ''; ?>" style="color: <?php echo $currentPage == 'about.php' ? '#667eea' : '#1a1a2e'; ?>; text-decoration: none; font-weight: 500; font-size: 1rem; transition: all 0.3s; position: relative; padding: 8px 0;" onmouseover="this.style.color='#667eea'; this.querySelector('.nav-underline').style.width='100%'" onmouseout="if(!this.classList.contains('active-link')) { this.style.color='#1a1a2e'; this.querySelector('.nav-underline').style.width='0'; }">
                        <i class="fas fa-info-circle" style="margin-right: 6px;"></i>About
                        <span class="nav-underline" style="position: absolute; bottom: 0; left: 0; width: <?php echo $currentPage == 'about.php' ? '100%' : '0'; ?>; height: 2px; background: linear-gradient(90deg, #667eea, #764ba2); transition: width 0.3s;"></span>
                    </a>
                </li>
                <li>
                    <a href="contact.php" class="<?php echo $currentPage == 'contact.php' ? 'active-link' : ''; ?>" style="color: <?php echo $currentPage == 'contact.php' ? '#667eea' : '#1a1a2e'; ?>; text-decoration: none; font-weight: 500; font-size: 1rem; transition: all 0.3s; position: relative; padding: 8px 0;" onmouseover="this.style.color='#667eea'; this.querySelector('.nav-underline').style.width='100%'" onmouseout="if(!this.classList.contains('active-link')) { this.style.color='#1a1a2e'; this.querySelector('.nav-underline').style.width='0'; }">
                        <i class="fas fa-envelope" style="margin-right: 6px;"></i>Contact
                        <span class="nav-underline" style="position: absolute; bottom: 0; left: 0; width: <?php echo $currentPage == 'contact.php' ? '100%' : '0'; ?>; height: 2px; background: linear-gradient(90deg, #667eea, #764ba2); transition: width 0.3s;"></span>
                    </a>
                </li>
                
                <!-- Cart Button -->
                <li>
                    <a href="cart.php" style="position: relative; display: flex; align-items: center; justify-content: center; width: 45px; height: 45px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 20px rgba(102, 126, 234, 0.5)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(102, 126, 234, 0.3)'">
                        <i class="fas fa-shopping-cart" style="color: white; font-size: 1.1rem;"></i>
                        <?php if ($cart_count > 0): ?>
                            <span style="position: absolute; top: -8px; right: -8px; background: linear-gradient(135deg, #f59e0b, #f97316); color: white; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.4);">
                                <?php echo $cart_count; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
