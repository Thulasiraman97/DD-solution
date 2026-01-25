<?php
// checkout.php
require_once 'config/db.php';
require_once 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = 'Checkout';

if (empty($_SESSION['cart'])) {
    redirect('cart.php');
}

// Calculate Total
$ids = array_keys($_SESSION['cart']);
$placeholders = str_repeat('?,', count($ids) - 1) . '?';
$stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->execute($ids);
$products = $stmt->fetchAll();

$total = 0;
$orderItems = [];
foreach ($products as $prod) {
    $qty = $_SESSION['cart'][$prod['id']];
    $total += $prod['price'] * $qty;
    $orderItems[] = ['product' => $prod, 'qty' => $qty];
}

// Handle Order Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'])) {
        die("Invalid CSRF Token"); // Or handle gracefully
    }

    $name = cleanInput($_POST['name']);
    $email = cleanInput($_POST['email']);
    $phone = cleanInput($_POST['phone']);
    $address = cleanInput($_POST['address']);
    
    // Insert Order
    $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_email, customer_phone, address, total_amount, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$name, $email, $phone, $address, $total]);
    $order_id = $pdo->lastInsertId();
    
    // Insert Order Items
    $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_title, quantity, price) VALUES (?, ?, ?, ?, ?)");
    foreach ($orderItems as $item) {
        $stmtItem->execute([$order_id, $item['product']['id'], $item['product']['title'], $item['qty'], $item['product']['price']]);
    }
    
    // Prepare HTML Email Content
    $emailContent = '
    <html>
    <head>
        <style>
            table { width: 100%; border-collapse: collapse; }
            th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
            th { background-color: #f8f9fa; }
        </style>
    </head>
    <body style="font-family: Arial, sans-serif; color: #333;">
        <h2 style="color: #667eea;">Order Details #' . $order_id . '</h2>
        <p><strong>Customer:</strong> ' . htmlspecialchars($name) . '</p>
        <p><strong>Phone:</strong> ' . htmlspecialchars($phone) . '</p>
        <p><strong>Address:</strong><br>' . nl2br(htmlspecialchars($address)) . '</p>
        
        <h3>Items Ordered</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>';
    
    foreach ($orderItems as $item) {
        $itemTotal = $item['product']['price'] * $item['qty'];
        $emailContent .= '
                <tr>
                    <td>' . htmlspecialchars($item['product']['title']) . '</td>
                    <td>' . $item['qty'] . '</td>
                    <td>' . formatPrice($item['product']['price']) . '</td>
                    <td>' . formatPrice($itemTotal) . '</td>
                </tr>';
    }
    
    $emailContent .= '
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold;">Grand Total:</td>
                    <td style="font-weight: bold; color: #d32f2f;">' . formatPrice($total) . '</td>
                </tr>
            </tfoot>
        </table>
        <p style="margin-top: 20px; font-size: 0.9rem; color: #777;">Thank you for shopping with DD Solutions!</p>
    </body>
    </html>';

    // Email Headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: DD Solutions <no-reply@ddsolutions.in>" . "\r\n";

    // Send to Company
    @mail('info.ddsolutionscdl@gmail.com', "New Order #$order_id from $name", $emailContent, $headers);

    // Send to Customer
    @mail($email, "Order Confirmation #$order_id - DD Solutions", $emailContent, $headers);

    // Clear Cart
    unset($_SESSION['cart']);
    
    // Redirect to Success
    redirect("order_success.php?id=$order_id");
}

include 'includes/header.php';
?>

<div class="container section-padding">
    <h1>Checkout</h1>
    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 300px;">
<style>
                .modern-form label { font-weight: 500; color: #333; display: block; margin-bottom: 8px; }
                .modern-form input[type="text"],
                .modern-form input[type="email"],
                .modern-form input[type="tel"],
                .modern-form textarea {
                    width: 100%;
                    padding: 12px;
                    border: 1px solid #e1e1e1;
                    border-radius: 8px;
                    transition: border 0.3s;
                    box-sizing: border-box;
                    font-family: inherit;
                }
                .modern-form input:focus, .modern-form textarea:focus {
                    border-color: #667eea;
                    outline: none;
                    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
                }
            </style>
            <form method="POST" class="modern-form" style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                <?php echo csrfInput(); ?>
                <h3 style="margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #eee;">Billing & Shipping Details</h3>
                <div style="margin-bottom: 20px;">
                    <label>Full Name</label>
                    <input type="text" name="name" required placeholder="John Doe">
                </div>
                <div style="margin-bottom: 20px;">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="john@example.com">
                </div>
                <div style="margin-bottom: 20px;">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" required pattern="[0-9]{10}" maxlength="10" placeholder="10-digit Mobile Number" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                    <small style="color: #666; font-size: 0.85rem;">Format: 10 digits only</small>
                </div>
                <div style="margin-bottom: 20px;">
                    <label>Shipping Address</label>
                    <textarea name="address" required rows="4" placeholder="House No, Street, City, Pincode"></textarea>
                </div>
                
                <h3 style="margin-top: 30px;">Payment Method</h3>
                <div style="background: #f1f8e9; padding: 15px; border: 1px solid #c5e1a5; border-radius: 8px; color: #558b2f; margin-top: 10px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-money-bill-wave" style="font-size: 1.2rem;"></i> <strong>Cash on Delivery (COD)</strong> only.
                </div>
                
                <button type="submit" class="btn" style="width: 100%; margin-top: 25px; padding: 15px; font-weight: 600; font-size: 1.1rem;">Place Order</button>
            </form>
        </div>
        
        <div style="flex: 1; min-width: 300px;">
            <div class="card" style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
                <h3>Order Summary</h3>
                <ul style="list-style: none; margin-top: 20px;">
                    <?php foreach ($orderItems as $item): ?>
                    <li style="display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                        <span><?php echo $item['qty']; ?>x <?php echo $item['product']['title']; ?></span>
                        <span><?php echo formatPrice($item['product']['price'] * $item['qty']); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: bold; margin-top: 20px;">
                    <span>Total</span>
                    <span><?php echo formatPrice($total); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
