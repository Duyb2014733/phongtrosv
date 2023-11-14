<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();

use website\src\Pagination;
use website\src\Room;

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: login.php');
    exit();
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

<head>
    <title>Danh sách phòng</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php
                require_once __DIR__ . "/../partials/navbar_fixed.php";
                ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <h2>Danh sách phòng</h2>
                    <hr>
                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php } ?>
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php } ?>
                    <table class="table table-striped">
                        <a href="/addRoom.php" class="btn btn-primary btn-lg" role="button">Thêm</a>
                        <hr>
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
                                        <a href="/addRental.php" class="btn btn-info" role="button">Cho thuê</a>
                                        <a href="/editRoom.php?id_room=<?php echo $room['id_room']; ?>" class="btn btn-info" style="background-color: #FF7F50;" role="button">Sửa</a>
                                        <a href="/deleteRoom.php?id_room=<?php echo $room['id_room']; ?>" class="btn btn-danger" role="button" onclick="return confirm('Bạn có chắc chắn muốn xóa phòng này không?')">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div>
                        <?php
                        // Sử dụng lớp Pagination
                        $totalItems = 10;
                        $itemsPerPage = 3;
                        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                        $baseUrl = 'index.php';
                        $queryParameters = array('category' => 'news');

                        $pagination = new Pagination($totalItems, $itemsPerPage, $currentPage, $baseUrl, $queryParameters);
                        echo $pagination->generatePaginationHtml();
                        ?>
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