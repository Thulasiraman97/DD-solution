<?php
// checkout.php
$pageTitle = 'Checkout';
include 'includes/header.php';

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
    
    // Send Email (Basic PHP Mail)
    $subject = "New Order #$order_id - DD Solutions";
    $message = "New Order Received from $name.\nTotal: " . formatPrice($total) . "\n\nDetails:\n";
    foreach ($orderItems as $item) {
        $message .= $item['qty'] . "x " . $item['product']['title'] . "\n";
    }
    $message .= "\nAddress: $address\nPhone: $phone";
    $headers = "From: no-reply@ddsolutions.in";
    
    @mail('info.ddsolutionscdl@gmail.com', $subject, $message, $headers); // Admin Notification
    @mail($email, "Order Confirmation #$order_id", "Thank you for your order! We will contact you shortly.", $headers); // Customer Notification

    // Clear Cart
    unset($_SESSION['cart']);
    
    // Redirect to Success
    redirect("order_success.php?id=$order_id");
}
?>

<div class="container section-padding">
    <h1>Checkout</h1>
    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 300px;">
            <form method="POST" style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <h3>Billing & Shipping Details</h3>
                <div style="margin-bottom: 15px; margin-top: 20px;">
                    <label style="display: block; margin-bottom: 5px;">Full Name</label>
                    <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Email Address</label>
                    <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Phone Number</label>
                    <input type="text" name="phone" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Shipping Address</label>
                    <textarea name="address" required rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
                </div>
                
                <h3 style="margin-top: 30px;">Payment Method</h3>
                <div style="background: #f1f8e9; padding: 15px; border: 1px solid #c5e1a5; border-radius: 4px; color: #558b2f; margin-top: 10px;">
                    <i class="fas fa-money-bill-wave"></i> <strong>Cash on Delivery (COD)</strong> only.
                </div>
                
                <button type="submit" class="btn" style="width: 100%; margin-top: 20px;">Place Order</button>
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
