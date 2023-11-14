<?php
session_start();
// Kiểm tra đã đăng nhập
if (isset($_SESSION['user_id'])) {
    session_destroy();
}
header('Location: Dangnhap.php');
?>
