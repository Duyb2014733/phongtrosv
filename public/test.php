<?php
require_once __DIR__ . '/../bootstrap.php';
use website\labs\Post;
session_start();
if (!isset($_SESSION['id_name'])) {
    header('Location: Dangnhap.php');
}

if (!isset($_POST['post']) && $_POST['post']) 
{
    $post = new Post($PDO);
    $title = $_POST['title'];
    $content = $_POST['content'];
    $status = $_POST['status'];
    $id_owner = $_SESSION['id_owner']; // lấy từ phiên đăng nhập
    $image_post = $_FILES['image_post'];
    $imagePath = uploadImage($image_post);
    $post->addPost($title, $content, $image, $status, $id_owner);
    $errors = $post->getErrors();
    echo $errors[0];
}

require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<?php require_once __DIR__ . '/../partials/navbar_owner.php'; ?>

<head>
    <title>Bài đăng</title>
</head>

<body>
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <form method="post" enctype="multipart/form-data" class="register-form">
                    <h1>
                        Đăng Bài
                    </h1>
                    <div class="form-group">
                        <label for="title" style="text-align: left;">Tiêu đề :</label>
                        <input class="form-post" type="text" name="title" placeholder="Tiêu đề bài viết">
                    </div>
                    <div style="color: #B22222;">
                        <?php if (!empty($titleErr)) { ?>
                            <span><?= $titleErr ?></span>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label for="content" style="text-align: left;"> Nội dung :</label>
                        <textarea class="form-post" name="content" placeholder="Nội dung bài viết"></textarea><br>
                    </div><br>
                    <div style="color: #B22222;">
                        <?php if (!empty($contentErr)) { ?>
                            <span><?= $contentErr ?></span>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <input class="form-post" type="file" name="image">
                    </div><br>
                    <div class="form-group">
                        <select name="status">
                            <option value="draft">Bản nháp</option>
                            <option value="published">Công khai</option>
                        </select><br>
                    </div>
                    <div class="from-group text-center " style="color: #B22222;">
                        <?php if (!empty($msg)) { ?>
                            <span><?= $msg ?></span>
                        <?php } ?>
                    </div> <br>
                    <input type="submit" name="post" value="Đăng bài">
                </form>
            </div>
        </div>
    </div>

</body>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>

</html>