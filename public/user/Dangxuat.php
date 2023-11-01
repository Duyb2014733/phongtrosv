<?php
session_start();
// Kiểm tra đã đăng nhập
if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
}
header('Location: Dangnhap.php');
?>
