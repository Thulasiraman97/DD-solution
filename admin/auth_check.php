<?php
// admin/auth_check.php
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}
?>
