<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();

use website\src\Room;

if (isset($_GET['id_room'])) {
    $room = new Room($PDO);
    $id_room = $_GET['id_room'];
    $images = $room->getImagesByRoomId($id_room);
    $rooms = $room->getRoomById($id_room);
    if (!$rooms) {
        $errors = 'Không có thông tin của phòng này!';
    }
} else {
}

require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Chi tiết phòng</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                foreach ($images as $image) {
                                    echo '<img src="' . $image['image'] . '" alt="Image" style="max-width: 100%; margin-bottom: 10px;">';
                                }
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <h1>Chi tiết phòng</h1>
                                <hr>
                                <p>Tên phòng: <?php echo $rooms['name_room']; ?></p>
                                <p>Giá phòng: <?php echo $rooms['price_room']; ?> đ</p>
                                <p>Khu vực: <?php echo $rooms['area_room']; ?></p>
                                <p>Cấp độ an toàn: <?php echo $rooms['security_room']; ?></p>
                                <p>Mô tả: <?php echo $rooms['description_room']; ?></p>
                                <p>Trạng thái: <?php echo $rooms['status_room']; ?></p>

                            </div>
                            <a class="btn btn-primary" href="index.php">Quay lại</a>
                        </div>
                    </div>

                </div>
                <br>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?><br>
            </div>
        </div>
    </div>

</body>

</html>