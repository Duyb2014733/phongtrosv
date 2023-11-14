<?php
require_once __DIR__ . '/../bootstrap.php';
use website\src\User;
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id_user'])) {
    $user = new User($PDO);
    $id_user = $_GET['id_user'];

    if ($user->getUserIdName($id_user)) {
        if ($user->deleteUser($id_user)) {
            $success = 'Xóa user thành công!';
        } else {
            $errors = 'Lỗi khi xóa user!';
        }
    } else {
        $errors = 'User không tồn tại!';
    }
}

?>