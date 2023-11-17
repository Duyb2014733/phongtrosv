<?php
require_once __DIR__ . '/../bootstrap.php';

use phongtrosv\src\Owner;

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit();
}
if (!isset($_GET['id_owner'])) {
    header('Location: dsOwner_admin.php');
    exit();
}
if (isset($_GET['id_owner'])) {
    $owner = new Owner($PDO);
    $id_owner = $_GET['id_owner'];
    if ($owner->deleteOwner($id_owner)) {
        $success = 'Xóa chủ nhà thành công!';
        header('Location: dsOwner_admin.php');
    } else {
        $error = 'Lỗi khi xóa chủ nhà!';
    }
}
