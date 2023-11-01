<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();
if (!isset($_SESSION['id_name'])) {
    header('Location: Dangnhap.php');
}
// lấy danh sách bài Post
$sql = "SELECT * FROM post ORDER BY created_at DESC";
$statement = $PDO->prepare($sql);
$statement->execute();
$posts = $statement->fetchAll();

require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<htm lang="vi">
    <?php require_once __DIR__ . '/../partials/navbar_owner.php'; ?>

    <head>
        <title>
            Danh sách bài đăng
        </title>
    </head>

    <body>
        <div class="container">
            <h2>Danh sách bài đăng</h2><br>
            <div class="row">
                <div class="col-12">
                    <a href="/Dangbai.php" class="btn btn-primary btn-lg" role="button">Thêm</a><br><br>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post) : ?>
                                <tr>
                                    <td><?php echo $post['id_post']; $_SESSION['id_post'] = $id_post['id_post'];?></td>
                                    <td><?php echo $post['title']; ?></td>
                                    <td><?php echo $post['created_at']; ?></td>
                                    <td>
                                        <a href="/edit_post.php"class="btn btn-info" role="button" style="background-color: #FF7F50;">Edit</a>
                                        <a href="/delete.php"class="btn btn-danger" role="button" style="background-color: #B22222;">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
    <?php require_once __DIR__ . '/../partials/footer.php'; ?>
</htm>