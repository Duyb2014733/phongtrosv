<?php
require_once __DIR__ . '/../bootstrap.php';

use website\labs\Room;

session_start();
if (!isset($_SESSION['id_owner'])) {
    header('Location: Dangnhap.php');
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
                <?php require_once __DIR__ . "/../partials/navbar_fixed_owner.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3">
                <div>
                    <h2>Cập nhật phòng</h2>
                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php } ?>
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php } ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="name">Tên phòng:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div><br>
                        <div class="form-group">
                            <label for="price">Giá phòng:</label>
                            <input type="text" name="price" class="form-control" required>
                        </div><br>
                        <div class="form-group">
                            <label for="area">Khu vực:</label>
                            <input type="text" name="area" class="form-control" required>
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
                            <textarea name="description" class="form-control" required></textarea>
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
                            <a class="btn btn-primary" href="dsRoom.php">Close</a>
                        </div>
                    </form>
                </div>
                <br><hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?>
            </div>
        </div>

    </div>
</body>


</html>