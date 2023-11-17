<?php
require_once __DIR__ . '/../bootstrap.php';

use phongtrosv\src\Room;
use phongtrosv\src\Owner;

session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}
$owner = new Owner($PDO);
$owners = $owner->getAllOwners();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $room = new Room($PDO);
    $name = $_POST['name'];
    $price = $_POST['price'];
    $elec = $_POST['elec'];
    $water = $_POST['water'];
    $area = $_POST['area'];
    $security = $_POST['security'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    if ($_SESSION['role'] === 'Admin') {
        $id_owner = $owner->getIdOwner($_POST['name_owner']);
        $roomId = $room->addRoom($name, $price, $elec, $water, $area, $security, $description, $status, $id_owner);
    } elseif ($_SESSION['role'] === 'Owner') {
        $id_owner = $_SESSION['id_owner'];
        $roomId = $room->addRoom($name, $price, $elec, $water, $area, $security, $description, $status, $id_owner);
    }
    if ($roomId) {
        $success = 'Phòng đã được thêm thành công!';
    } else {
        $error = 'Có lỗi xảy ra khi thêm phòng.';
    }
}

require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>Thêm phòng</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <h2>Thêm phòng</h2>
                    <hr>
                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php } ?>
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php } ?>
                    <form method="post" class="form-group">
                        <?php if ($_SESSION['role'] === 'Admin') : ?>
                            <div class="form-group">
                                <label for="name_owner">Tên chủ trọ : </label><br>
                                <select name="name_owner" class="form-control">
                                    <?php foreach ($owners as $owner) { ?>
                                        <option value="<?= $owner['name_owner'] ?>">
                                            <?= $owner['name_owner'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div><br>
                        <?php endif; ?>
                        <div class="row">
                            <div class="form-group col">
                                <label for="name">Tên phòng:</label>
                                <input type="text" name="name" class="form-control" required>
                            </div><br>
                            <div class="form-group col">
                                <label for="price">Giá phòng:</label>
                                <input type="text" name="price" class="form-control" required>
                            </div><br>
                        </div><br>
                        <div class="row">
                            <div class="form-group col">
                                <label for="elec">Giá điện:</label>
                                <input type="text" name="elec" class="form-control" required>
                            </div><br>
                            <div class="form-group col">
                                <label for="water">Giá nước:</label>
                                <input type="text" name="water" class="form-control" required>
                            </div><br>
                        </div><br>
                        <div class="row">
                            <div class="form-group col">
                            <label for="area">Khu vực:</label>
                            <input type="text" name="area" class="form-control" required>
                        </div><br>
                        <div class="form-group col">
                            <label for="security">Cấp độ an toàn:</label>
                            <select name="security" class="form-control" required>
                                <option value="Thấp">Thấp</option>
                                <option value="Trung bình">Trung bình</option>
                                <option value="Cao">Cao</option>
                            </select>
                        </div><br>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Mô tả phòng:</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div><br>
                        <div class="form-group">
                            <label for="status">Trạng thái phòng:</label>
                            <select name="status" class="form-control" required>
                                <option value="Có sẵn">Có sẵn</option>
                                <option value="Đã thuê">Đã thuê</option>
                            </select>
                        </div><br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Thêm phòng</button>
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