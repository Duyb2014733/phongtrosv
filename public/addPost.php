<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();

use website\src\Post;

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}
$sql = "SELECT * FROM room";
$statement = $PDO->prepare($sql);
$statement->execute();
$rooms = $statement->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post = new Post($PDO);
    $title = $_POST['title'];
    $content = $_POST['content'];
    $status = $_POST['status_post'];
    $id_owner = $_SESSION['id_owner'];
    $id_room = $_POST['id_room'];
    $image = $_FILES['image_post'];

    if ($post->addPost($title, $content, $image, $status, $id_owner, $id_room)) {
        $success = 'Đăng bài thành công!';
    } else {
        $errors = $post->getErrors();
    }
}

require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>Đăng bài viết</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <h2>Đăng bài viết</h2>
                    <hr>
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
                        </div><br>
                        <div class="form-group">
                            <label for="content">Nội dung:</label>
                            <textarea class="form-control" name="content" placeholder="Nội dung bài viết"></textarea>
                        </div><br>
                        <div class="form-group">
                            <label for="image_post">Hình ảnh:</label>
                            <input type="file" name="image_post">
                        </div><br>
                        <div class="form-group">
                            <label for="room">Chọn phòng:</label>
                            <select class="form-control" name="id_room">
                                <?php
                                foreach ($rooms as $room) {
                                    echo '<option value="' . $room['id_room'] . '">' . $room['name_room'] . '</option>';
                                }
                                ?>
                            </select>
                        </div><br>
                        <div class="form-group">
                            <label for="status_post">Trạng thái:</label>
                            <select class="form-control" name="status_post">
                                <option value="draft">Bản nháp</option>
                                <option value="published">Công khai</option>
                            </select>
                        </div><br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Đăng bài</button>
                            <a class="btn btn-primary" href="dsPost.php">Close</a>
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