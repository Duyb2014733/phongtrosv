<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();

use website\labs\Post;

if (!isset($_SESSION['id_owner'])) {
    header('Location: Dangnhap.php');
}

$post = new Post($PDO);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="container text-center">
        <div class="form-container">
            <form method="post" enctype="multipart/form-data" class="form-horizontal">
                <h1>Đăng bài viết</h1>
                <div class="form-group">
                    <label for="title" class="col-sm-3 control-label">Tiêu đề:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="title" placeholder="Tiêu đề bài viết">
                    </div>
                </div>
                <div class="form-group">
                    <label for="content" class="col-sm-3 control-label">Nội dung:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="content" placeholder="Nội dung bài viết"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image_post" class="col-sm-3 control-label">Hình ảnh:</label>
                    <div class="col-sm-9">
                        <input type="file" name="image_post">
                    </div>
                </div>
                <div class="form-group">
                    <label for="status_post" class="col-sm-3 control-label">Trạng thái:</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="status_post">
                            <option value="draft">Bản nháp</option>
                            <option value="published">Công khai</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
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
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-primary" name="submit">Đăng bài</button>
                    </div>
                    <div class="col-sm-offset-3 col-sm-9">
                    <a href="dsbaidang.php" type="button" class="btn btn-default">Close</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>

</html>