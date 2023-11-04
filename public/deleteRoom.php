<?php
require_once __DIR__ . '/../bootstrap.php';
use website\labs\Room;

session_start();

if (!isset($_SESSION['id_owner'])) {
    header('Location: Dangnhap.php');
}

if (isset($_GET['id_room'])) {
    $id_room = $_GET['id_room'];
    $room = new Room($PDO);
    
    if ($room->deleteRoom($id_room)) {
        $success = 'Xóa bài phòng công!';
        header('Location: dsroom.php');
    } else {
        $error = 'Xóa bài phòng bại!';
    }
}
?>
?>