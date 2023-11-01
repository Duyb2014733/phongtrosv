<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();
if (!isset($_SESSION['id_name'])) {
    header('Location: Dangnhap.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']))

if (!isset($_SESSION['id_post'])) {
    $id_post = $_SESSION['id_post'];
    function deletePost($id_post): bool
    {
        $sql = "DELETE FROM post WHERE id_post = :id_post";
       $statement = $PDO->prepare($sql);
        return $statement->execute([
            ":id_post" => $id_post
        ]);
    }
    if (deletePost($id_post)) {
        header('Location: dsbaidang.php');
    }
}
?>