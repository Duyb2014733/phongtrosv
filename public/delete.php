<?php
require_once __DIR__ . '/../bootstrap.php';
use website\src\User;
use website\src\Owner;
use website\src\Post;
use website\src\Room;
use website\src\Customer;
session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
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

if (isset($_GET['id_customer']) && is_numeric($_GET['id_customer'])) {
    $customer = new Customer($PDO);
    $id_customer = $_GET['id_customer'];
    $deleted = $customer->deleteCustomer($id_customer);

    if ($deleted) {
        $success = 'Xóa khách hàng thành công!';
        header('Location: dsCustomer.php');
    } else {
        $error = 'Lỗi khi xóa khách hàng.';
    }
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

if (isset($_GET['id_post'])) {
    $id_post = $_GET['id_post'];
    $post = new Post($PDO);
    
    if ($post->deletePost($id_post)) {
        $success = 'Xóa bài đăng thành công!';
        header('Location: dsbaidang.php');
    } else {
        $error = 'Xóa bài đăng thất bại!';
    }
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



?>