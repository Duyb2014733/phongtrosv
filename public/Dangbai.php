<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();

use website\labs\Post;

if (!isset($_SESSION['id_owner'])) {
    header('Location: Dangnhap.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post = new Post($PDO);
    $title = $_POST['title'];
    $content = $_POST['content'];
    $status = $_POST['status_post'];
    $id_owner = $_SESSION['id_owner'];

    $image = $_FILES['image_post'];

    if ($post->addPost($title, $content, $image, $status, $id_owner)) {
        $success = 'Đăng bài thành công!';
    } else {
        $errors = $post->getErrors();
    }
}

require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<?php require_once __DIR__ . '/../partials/navbar_owner.php'; ?>

<head>
    <title>Đăng bài viết</title>
</head>

<body>
    <div class="container">
        <h1>Đăng bài viết</h1>
        <?php if (isset($errors) && !empty($errors)) { ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $field => $error) { ?>
                        <li><?= $error ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
        <?php if (isset($success)) { ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php } ?>
        <form method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="title">Tiêu đề:</label>
                <input type="text" class="form-control" name="title" placeholder="Tiêu đề bài viết">
            </div>
            <div class="form-group">
                <label for="content">Nội dung:</label>
                <textarea class="form-control" name="content" placeholder="Nội dung bài viết"></textarea>
            </div>
            <div class="form-group">
                <label for="image_post">Hình ảnh:</label>
                <input type="file" name="image_post">
            </div>
            <div class="form-group">
                <label for="status_post">Trạng thái:</label>
                <select class="form-control" name="status_post">
                    <option value="draft">Bản nháp</option>
                    <option value="published">Công khai</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Đăng bài</button>
                <a class="btn btn-primary" href="dsbaidang.php">Close</a>
            </div>
        </form>
    </div>
</body>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>

</html>