<?php
require_once __DIR__ . '/../bootstrap.php';

use website\labs\Post;

session_start();

if (!isset($_SESSION['id_name'])) {
    header('Location: Dangnhap.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu bài đăng được chỉnh sửa từ form và thực hiện cập nhật vào cơ sở dữ liệu
    $id_post = $_POST['id_post'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image_post'];
    $status = $_POST['status_post'];
    $post = new Post($PDO);

    if ($post->editPost($id_post, $title, $content, $image, $status)) {
        $success = 'Cập nhật bài đăng thành công!';
    } else {
        $errors = $post->getErrors();
    }
}

// Lấy thông tin bài đăng cần chỉnh sửa
$id_post = $_GET['id_post'];
$post = new Post($PDO);
$postData = $post->getPostById($id_post);

// Hiển thị biểu mẫu chỉnh sửa bài đăng
require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
    <?php require_once __DIR__ . '/../partials/navbar_owner.php'; ?>

    <head>
        <title>Chỉnh sửa bài đăng</title>
    </head>

    <body>
        <div class="container">
            <h2>Chỉnh sửa bài đăng</h2><br>
            <?php if (isset($success)) { ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php } ?>
            <?php if (isset($errors) && !empty($errors)) { ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $field => $error) { ?>
                            <li><?= $error ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_post" value="<?= $id_post ?>">
                <div class="form-group">
                    <label for="title">Tiêu đề:</label>
                    <input type="text" name="title" value="<?= $postData['title'] ?>">
                </div>
                <div class="form-group">
                    <label for="content">Nội dung:</label>
                    <textarea name="content"><?= $postData['content'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="image_post">Hình ảnh:</label>
                    <input type="file" name="image_post">
                </div>
                <div class="form-group">
                    <select class="form-control" name="status_post">
                        <option value="draft" <?= $postData['status_post'] === 'draft' ? 'selected' : '' ?>>Bản nháp</option>
                        <option value="published" <?= $postData['status_post'] === 'published' ? 'selected' : '' ?>>Công khai</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit">Cập nhật bài đăng</button>
                </div>
            </form>
        </div>
    </body>
    <?php require_once __DIR__ . '/../partials/footer.php'; ?>

</html>
