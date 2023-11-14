<?php
require_once __DIR__ . '/../bootstrap.php';

use website\src\Room;
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $room = new Room($PDO);
    $id_room = $_GET['id_room'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $area = $_POST['area'];
    $security = $_POST['security'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $id_owner = $_SESSION['id_owner'];

    $roomId = $room->editRoom($id_room, $name, $price, $area, $security, $description, $status, $id_owner);

    if ($roomId) {
        $success = 'Phòng cập nhật thành công!';
    } else {
        $error = 'Có lỗi xảy ra khi cập nhật phòng.';
    }
}

$id_room = $_GET['id_room'];
$room = new Room($PDO);
$roomDatas = $room->getRoomById($id_room);

require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>
        Cập nhật phòng
    </title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <h2>Sửa thông tin phòng</h2>
                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php } ?>
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php } ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="name">Tên phòng:</label>
                            <input type="text" name="name" class="form-control" value="<?= $roomDatas['name_room'] ?>" required>
                        </div><br>
                        <div class="form-group">
                            <label for="price">Giá phòng:</label>
                            <input type="text" name="price" class="form-control" value="<?= $roomDatas['price_room'] ?>" required>
                        </div><br>
                        <div class="form-group">
                            <label for="area">Khu vực:</label>
                            <input type="text" name="area" class="form-control" value="<?= $roomDatas['area_room'] ?>" required>
                        </div><br>
                        <div class="form-group">
                            <label for="security">Cấp độ an toàn:</label>
                            <select name="security" class="form-control" required>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div><br>
                        <div class="form-group">
                            <label for="description">Mô tả phòng:</label>
                            <textarea name="description" class="form-control" value="<?= $roomData['description_room'] ?>" required></textarea>
                        </div><br>
                        <div class="form-group">
                            <label for="status">Trạng thái phòng:</label>
                            <select name="status" class="form-control" required>
                                <option value="available">Có sẵn</option>
                                <option value="occupied">Đã thuê</option>
                                <option value="reserved">Đã đặt trước</option>
                            </select>
                        </div><br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a class="btn btn-primary" href="dsRoom.php">Thoát</a>
                        </div>
                    </form>
                </div>
                <br>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?><br>
            </div>
        </div>

    </div>
</body>


</html>