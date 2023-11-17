<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();

use phongtrosv\src\Chiso;

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}

if (isset($_GET['id_Chiso'])) {
    $id_Chiso = $_GET['id_Chiso'];
    $id_room = $_GET['id_room'];
    $chiso = new Chiso($PDO);

    if ($chiso->deleteChiso($id_Chiso)) {
        $success = 'Xóa thông tin chỉ số thành công!';
        header("Location: addChiso.php?id_room=$id_room");
        exit();
    } else {
        $error = 'Lỗi khi xóa thông tin chỉ số!';
    }
}
