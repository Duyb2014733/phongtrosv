<?php
require_once __DIR__ . '/../bootstrap.php';

use website\src\Post;

session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: login.php');
    exit();
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

<head>
    <title>Chỉnh sửa bài đăng</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
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
                        <input type="hidden" name="id_post" value="<?= $id_post ?>" class="form-control" required>
                        <div class="form-group">
                            <label for="title">Tiêu đề:</label>
                            <input type="text" name="title" value="<?= $postData['title'] ?>" class="form-control" required>
                        </div><br>
                        <div class="form-group">
                            <label for="content">Nội dung:</label>
                            <textarea name="content" class="form-control" required><?= $postData['content'] ?></textarea>
                        </div><br>
                        <div class="form-group">
                            <label for="image_post">Hình ảnh:</label>
                            <input type="file" name="image_post" class="form-control" required>
                        </div><br>
                        <div class="form-group">
                            <label for="status_post">Trạng thái:</label>
                            <select class="form-control" name="status_post">
                                <option value="draft">Bản nháp</option>
                                <option value="published">Công khai</option>
                            </select>
                        </div><br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập nhật bài đăng</button>
                            <a class="btn btn-primary" href="dsbaidang.php">Close</a>
                        </div>
                    </form>
                </div>
                <br>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?>
            </div>
        </div>

    </div>
</body>

</html>