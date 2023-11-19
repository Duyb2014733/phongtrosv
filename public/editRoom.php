<?php
require_once __DIR__ . '/../bootstrap.php';

use phongtrosv\src\Room;

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
    $elec = $_POST['elec'];
    $water = $_POST['water'];
    $area = $_POST['area'];
    $security = $_POST['security'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $id_owner = $_SESSION['id_owner'];

    $roomId = $room->editRoom($id_room, $name, $price, $elec, $water, $area, $security, $description, $status, $id_owner);

    if ($roomId) {
        $success = 'Phòng cập nhật thành công!';
    } else {
        $error = 'Có lỗi xảy ra khi cập nhật phòng.';
    }
}

$id_room = $_GET['id_room'];
$room = new Room($PDO);
$roomData = $room->getRoomById($id_room);

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
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php } ?>
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php } ?>
                    <form method="post">
                        <div class="row">
                            <div class="form-group col">
                                <label for="name">Tên phòng:</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($roomData['name_room']) ?>" required>
                            </div><br>
                            <div class="form-group col">
                                <label for="price">Giá phòng:</label>
                                <input type="text" name="price" class="form-control" value="<?= htmlspecialchars($roomData['price_room']) ?>" required>
                            </div><br>
                        </div><br>
                        <div class="row">
                            <div class="form-group col">
                                <label for="elec">Giá điện:</label>
                                <input type="text" name="elec" class="form-control" value="<?= htmlspecialchars($roomData['elec_room']) ?>" required>
                            </div><br>
                            <div class="form-group col">
                                <label for="water">Giá nước:</label>
                                <input type="text" name="water" class="form-control" value="<?= htmlspecialchars($roomData['water_room']) ?>" required>
                            </div><br>
                        </div><br>
                        <div class="row">
                            <div class="form-group col">
                                <label for="area">Khu vực:</label>
                                <input type="text" name="area" class="form-control" value="<?= htmlspecialchars($roomData['area_room']) ?>" required>
                            </div><br>
                            <div class="form-group col">
                                <label for="security">Cấp độ an toàn:</label>
                                <select name="security" class="form-control" required>
                                    <option value="Thấp">Thấp</option>
                                    <option value="Trung bình">Trung bình</option>
                                    <option value="Cao">Cao</option>
                                </select>
                            </div><br>
                        </div><br>
                        <div class="form-group">
                            <label for="description">Mô tả phòng:</label>
                            <textarea name="description" class="form-control" required><?= htmlspecialchars($roomData['description_room']) ?></textarea>
                        </div><br>
                        <div class="form-group">
                            <label for="status">Trạng thái phòng:</label>
                            <select name="status" class="form-control" required>
                                <option value="Có sẵn">Có sẵn</option>
                                <option value="Đã thuê">Đã thuê</option>
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