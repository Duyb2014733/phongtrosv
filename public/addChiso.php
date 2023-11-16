<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();
use website\src\Room;
use website\src\Chiso;

// Kiểm tra quyền truy cập
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}

$chiso = new Chiso($PDO);
$room = new Room($PDO);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_room = $_GET['id_room'];
    $date_Chiso = $_POST['date'];
    $electricity = $_POST['electricity'];
    $water = $_POST['water'];

    // Thêm thông tin chỉ số vào CSDL
    if ($chiso->addChiso($id_room, $date_Chiso, $electricity, $water)) {
        $success = 'Thêm thông tin chỉ số thành công!';
    } else {
        $error = 'Lỗi khi thêm thông tin chỉ số!';
    }
}

$rooms = $room->getAllRooms(); // Lấy danh sách phòng
require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Thêm thông tin chỉ số</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <form method="post">
                        <h2>Thêm thông tin chỉ số</h2>
                        <?php if (isset($success)) : ?>
                            <div class="alert alert-success"><?= $success ?></div>
                        <?php endif; ?>
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="id_room">Chọn phòng:</label>
                            <select name="id_room" class="form-control">
                                <?php foreach ($rooms as $room) : ?>
                                    <option value="<?= $room['id_room']; ?>"><?= $room['name_room']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date">Ngày nhập chỉ số:</label>
                            <input type="date" class="form-control" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="electricity">Chỉ số điện:</label>
                            <input type="number" class="form-control" name="electricity" required>
                        </div>
                        <div class="form-group">
                            <label for="water">Chỉ số nước:</label>
                            <input type="number" class="form-control" name="water" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Thêm</button>
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
