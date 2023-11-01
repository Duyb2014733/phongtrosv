
<?php
if (isset($_SESSION['delete'])) {
    // ID bài đăng
    $id_post = $_GET['id_post'];

    // Câu lệnh DELETE
    $sql = "DELETE FROM post WHERE id_post = :id_post";

    $statement = $PDO->prepare($sql);

    $statement->execute([
        ':id_post' => $id_post
    ]);
}