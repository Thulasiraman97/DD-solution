<?php
// order_success.php
require_once 'config/db.php';
require_once 'includes/functions.php';

$order_id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    redirect('index.php');
}

$pageTitle = 'Order Confirmed';
include 'includes/header.php';

// Construct WhatsApp Message
$wa_message = "Hello DD Solutions, I have placed order #$order_id. " . 
              "Name: " . $order['customer_name'] . ". " . 
              "Total: " . formatPrice($order['total_amount']) . ". " .
              "Please confirm delivery.";
$wa_link = "https://api.whatsapp.com/send?phone=919025142474&text=" . urlencode($wa_message);
?>

<div class="container section-padding" style="text-align: center;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 50px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
        <i class="fas fa-check-circle" style="font-size: 4rem; color: #2ecc71; margin-bottom: 20px;"></i>
        <h1>Thank You!</h1>
        <p style="font-size: 1.2rem; color: #555;">Your order <strong>#<?php echo $order_id; ?></strong> has been placed successfully.</p>
        <p style="margin: 20px 0;">We will contact you shortly via phone/email.</p>
        
        <div style="margin-top: 30px;">
            <p style="margin-bottom: 10px;">For faster processing, send your order details on WhatsApp:</p>
            <a href="<?php echo $wa_link; ?>" target="_blank" class="btn" style="background: #25D366;">
                <i class="fab fa-whatsapp"></i> Send Order on WhatsApp
            </a>
        </div>
        
        <div style="margin-top: 40px;">
            <a href="index.php" class="btn btn-outline" style="border-color: var(--primary); color: var(--primary);">Back to Home</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
