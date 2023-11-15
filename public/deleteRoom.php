<?php
require_once __DIR__ . '/../bootstrap.php';
use website\src\Room;

session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: login.php');
    exit();
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