<?php
// admin/orders.php
require_once '../config/db.php';
require_once 'auth_check.php';

$pageTitle = 'Manage Orders';

// Handle Status Update
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $order_id]);
    setFlash('success', "Order #$order_id status updated to $status");
    redirect('orders.php');
}

include 'includes/header.php';
?>

<div class="card" style="background:#fff; padding:20px; border-radius:8px;">
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Items</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM orders ORDER BY order_date DESC");
            while ($row = $stmt->fetch()):
                $itemsStmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
                $itemsStmt->execute([$row['id']]);
                $items = $itemsStmt->fetchAll();
            ?>
            <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo date('d M Y', strtotime($row['order_date'])); ?></td>
                <td>
                    <strong><?php echo $row['customer_name']; ?></strong><br>
                    <small><?php echo $row['customer_phone']; ?></small>
                </td>
                <td><?php echo formatPrice($row['total_amount']); ?></td>
                <td>
                    <span class="badge badge-<?php echo $row['status']; ?>" style="padding: 4px 8px; border-radius: 4px; font-size:0.8rem; background: #eee;">
                        <?php echo ucfirst($row['status']); ?>
                    </span>
                </td>
                <td>
                    <ul style="padding-left:15px; margin:0; font-size:0.9rem;">
                        <?php foreach($items as $item): ?>
                            <li><?php echo $item['quantity']; ?>x <?php echo $item['product_title']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                        <select name="status" onchange="this.form.submit()" style="padding:4px; border-radius:4px; border:1px solid #ddd;">
                            <option value="pending" <?php echo $row['status']=='pending'?'selected':''; ?>>Pending</option>
                            <option value="confirmed" <?php echo $row['status']=='confirmed'?'selected':''; ?>>Confirmed</option>
                            <option value="shipped" <?php echo $row['status']=='shipped'?'selected':''; ?>>Shipped</option>
                            <option value="delivered" <?php echo $row['status']=='delivered'?'selected':''; ?>>Delivered</option>
                            <option value="cancelled" <?php echo $row['status']=='cancelled'?'selected':''; ?>>Cancelled</option>
                        </select>
                        <input type="hidden" name="update_status" value="1">
                    </form>
                    <!-- <a href="order_details.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a> -->
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
