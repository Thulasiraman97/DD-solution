<?php
// includes/cart_actions.php
session_start();
require_once '../config/db.php'; // Though not strictly needed if just manipulating session, but good for price verification if we were advanced

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_POST['action'] ?? '';
$product_id = $_POST['product_id'] ?? 0;
$quantity = $_POST['quantity'] ?? 1;

if ($action == 'add') {
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    header('Location: ../cart.php');
} elseif ($action == 'update') {
    if ($quantity > 0) {
        $_SESSION['cart'][$product_id] = $quantity;
    } else {
        unset($_SESSION['cart'][$product_id]);
    }
    header('Location: ../cart.php');
} elseif ($action == 'remove') {
    unset($_SESSION['cart'][$product_id]);
    header('Location: ../cart.php');
}

exit();
?>
