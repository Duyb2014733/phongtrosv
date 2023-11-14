<?php
require_once __DIR__ . '/../bootstrap.php';
use website\src\Post;
session_start();
if (!isset($_SESSION['id_owner'])) {
    header('Location: Dangnhap.php');
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
?>
