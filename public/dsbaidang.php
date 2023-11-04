<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();
if (!isset($_SESSION['id_owner'])) {
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

    <head>
        <title>
            Danh sách bài đăng
        </title>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2">
                    <?php require_once __DIR__ . '/../partials/navbar_sidebar.php'; ?>
                </div>
                <div class="col-sm-10">
                    <div>
                        <h2>Danh sách bài đăng</h2><br>
                        <a href="/Dangbai.php" class="btn btn-primary btn-lg" role="button">Thêm</a><br><br>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tiêu đề</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posts as $post) : ?>
                                    <tr>
                                        <td><?php echo $post['id_post']; ?></td>
                                        <td><?php echo $post['title']; ?></td>
                                        <td><?php echo $post['created_at']; ?></td>
                                        <td>
                                            <a href="/edit_post.php?id_post=<?php echo $post['id_post']; ?>" class="btn btn-info" role="button" style="background-color: #FF7F50;">
                                                Edit
                                            </a>
                                            <a onclick="return confirm('Bạn có muốn xóa bài đăng này không')" href="/delete_post.php?id_post=<?php echo $post['id_post']; ?>" class="btn btn-danger" role="button" style="background-color: #B22222;">
                                                Delete
                                                <?php $_SESSION['id_post'] = $post['id_post']; ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php require_once __DIR__ . '/../partials/footer.php'; ?>
</htm>