<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();
use phongtrosv\src\Room;
use phongtrosv\src\Post;
use phongtrosv\src\Owner;

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}

$room = new Room($PDO);
$rooms = $room->getAllRooms();
$owner = new Owner($PDO);
$owners = $owner->getAllOwners();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post = new Post($PDO);
    $title = $_POST['title'];
    $content = $_POST['content'];
    $status = $_POST['status_post'];
    $id_room = $_POST['id_room'];
    $image = $_FILES['image_post'];

    if ($_SESSION['role'] === 'Admin') {
        $id_owner = $owner->getIdOwner($_POST['name_owner']);
        $post->addPost($title, $content, $image, $status, $id_owner, $id_room);
    } elseif ($_SESSION['role'] === 'Owner') {
        $id_owner = $_SESSION['id_owner'];
        $post->addPost($title, $content, $image, $status, $id_owner, $id_room);
    }
    if ($post) {
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
                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php } ?>
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php } ?>
                    <form method="post" enctype="multipart/form-data">
                    <?php if ($_SESSION['role'] === 'Admin') : ?>
                            <div class="form-group">
                                <label for="name_owner">Tên chủ trọ : </label><br>
                                <select name="name_owner" class="form-control">
                                    <?php foreach ($owners as $owner) { ?>
                                        <option value="<?= htmlspecialchars($owner['name_owner']) ?>">
                                            <?= htmlspecialchars($owner['name_owner']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div><br>
                        <?php endif; ?>
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
                                    echo '<option value="' . htmlspecialchars($room['id_room']) . '">' . htmlspecialchars($room['name_room']) . '</option>';
                                }
                                ?>
                            </select>
                        </div><br>
                        <div class="form-group">
                            <label for="status_post">Trạng thái:</label>
                            <select class="form-control" name="status_post">
                                <option value="Bản nháp">Bản nháp</option>
                                <option value="Công khai">Công khai</option>
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