<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();

use website\labs\Room;

if (!isset($_SESSION['id_owner'])) {
    header('Location: Dangnhap.php');
}

$room = new Room($PDO);

// Xử lý khi nhấn nút xóa phòng
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_room'])) {
    $id_room = $_GET['id_room'];
    if ($room->deleteRoom($id_room)) {
        $success = 'Xóa phòng thành công!';
    } else {
        $error = 'Xóa phòng thất bại!';
    }
}

// Lấy danh sách phòng từ cơ sở dữ liệu
$sql = "SELECT * FROM room";
$statement = $PDO->prepare($sql);
$statement->execute();
$rooms = $statement->fetchAll();

require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Danh sách phòng</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . '/../partials/navbar_sidebar.php'; ?>
            </div>
            <div class="col-sm-10">
                <h2>Danh sách phòng</h2><br>
                <?php if (isset($success)) { ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php } ?>
                <?php if (isset($error)) { ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php } ?>
                <table class="table table-striped">
                    <a href="/addRoom.php" class="btn btn-primary btn-lg" role="button">Thêm</a><br><br>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên phòng</th>
                            <th>Giá phòng</th>
                            <th>Diện tích</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rooms as $room) : ?>
                            <tr>
                                <td><?= $room['id_room'] ?></td>
                                <td><?= $room['name_room'] ?></td>
                                <td><?= $room['price_room'] ?></td>
                                <td><?= $room['area_room'] ?></td>
                                <td><?= $room['status_room'] ?></td>
                                <td>
                                    <a href="/addCustomer.php" class="btn btn-info" role="button">Thêm khách hàng</a>
                                    <a href="/editRoom.php?id_room=<?php echo $room['id_room']; ?>" class="btn btn-info" role="button">Sửa</a>
                                    <a href="/deleteRoom.php?id_room=<?php echo $room['id_room']; ?>" class="btn btn-danger" role="button" onclick="return confirm('Bạn có chắc chắn muốn xóa phòng này không?')">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>

</html>