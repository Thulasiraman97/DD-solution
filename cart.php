<?php
// cart.php
$pageTitle = 'Shopping Cart';
include 'includes/header.php';

$cartItems = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    if (!empty($ids)) {
        $placeholders = str_repeat('?,', count($ids) - 1) . '?';
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        $products = $stmt->fetchAll();
        
        foreach ($products as $prod) {
            $prod['qty'] = $_SESSION['cart'][$prod['id']];
            $prod['subtotal'] = $prod['price'] * $prod['qty'];
            $total += $prod['subtotal'];
            $cartItems[] = $prod;
        }
    }
}
?>

<div class="container section-padding">
    <h1>Your Shopping Cart</h1>
    
    <?php if (empty($cartItems)): ?>
        <div style="text-align: center; padding: 50px;">
            <p>Your cart is empty.</p>
            <a href="products.php" class="btn">Continue Shopping</a>
        </div>
    <?php else: ?>
        <div style="display: flex; gap: 30px; flex-wrap: wrap; margin-top: 30px;">
            <div style="flex: 2; min-width: 300px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #eee;">
                            <th style="text-align: left; padding: 10px;">Product</th>
                            <th style="padding: 10px;">Price</th>
                            <th style="padding: 10px;">Quantity</th>
                            <th style="padding: 10px;">Total</th>
                            <th style="padding: 10px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 15px 10px;">
                                <strong><?php echo $item['title']; ?></strong>
                            </td>
                            <td style="padding: 15px 10px; text-align: center;"><?php echo formatPrice($item['price']); ?></td>
                            <td style="padding: 15px 10px; text-align: center;">
                                <form action="includes/cart_actions.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['qty']; ?>" min="1" max="100" style="width: 50px; padding: 5px;" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td style="padding: 15px 10px; text-align: center;"><?php echo formatPrice($item['subtotal']); ?></td>
                            <td style="padding: 15px 10px; text-align: center;">
                                <form action="includes/cart_actions.php" method="POST">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" style="background: none; border: none; color: red; cursor: pointer;"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div style="flex: 1; min-width: 250px;">
                <div class="card" style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
                    <h3>Cart Summary</h3>
                    <div style="display: flex; justify-content: space-between; margin: 20px 0; font-size: 1.2rem; font-weight: bold;">
                        <span>Total:</span>
                        <span><?php echo formatPrice($total); ?></span>
                    </div>
                    <a href="checkout.php" class="btn" style="width: 100%; text-align: center; display: block;">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
