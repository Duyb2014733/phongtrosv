<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();

use phongtrosv\src\Room;
use phongtrosv\src\Chiso;
use phongtrosv\src\Pagination;

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}

$chiso = new Chiso($PDO);
$room = new Room($PDO);
$id_room = $_GET['id_room'];
$rooms = $room->getRoomById($id_room);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_room = $_GET['id_room'];
    $date_Chiso = $_POST['date'];
    $electricity = $_POST['electricity'];
    $water = $_POST['water'];
    $total_cost = $chiso->calculateTotalCost($id_room, $date_Chiso, $electricity, $water);

    if ($chiso->addChiso($id_room, $date_Chiso, $electricity, $water, $total_cost)) {
        $success = 'Thêm thông tin chỉ số thành công!';
    } else {
        $error = 'Lỗi khi thêm thông tin chỉ số!';
    }
}

require_once __DIR__ . '/../partials/header.php';
?>

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
                        <div class="mb-3 mt-3">
                            <label for="id_room">Chọn phòng:</label>
                            <input type="text" class="form-control" name="id_room" value="<?= $rooms['name_room'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="date">Ngày nhập chỉ số:</label>
                            <input type="date" class="form-control" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="electricity">Chỉ số điện:</label>
                            <input type="number" class="form-control" name="electricity" required>
                        </div>
                        <div class="mb-3">
                            <label for="water">Chỉ số nước:</label>
                            <input type="number" class="form-control" name="water" required>
                        </div><br>
                        <button type="submit" class="btn btn-primary" name="submit">Thêm</button>
                    </form>
                </div>
                <br>
                <div>
                    <h2>Thông tin chỉ số và thành tiền</h2>
                    <table class="table  table-striped">
                        <thead>
                            <tr>
                                <th>ID Room</th>
                                <th>Ngày nhập chỉ số</th>
                                <th>Chỉ số điện</th>
                                <th>Chỉ số nước</th>
                                <th>Thành tiền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $chisoList = $chiso->getChisoList($id_room);
                            foreach ($chisoList as $item) : ?>
                                <tr>
                                    <td><?= $item['id_room']; ?></td>
                                    <td><?= $item['date_Chiso']; ?></td>
                                    <td><?= $item['elec_Chiso']; ?></td>
                                    <td><?= $item['water_Chiso']; ?></td>
                                    <td><?= $item['total_cost']; ?></td>
                                    <td>
                                        <a href="editChiso.php?id_Chiso=<?= $item['id_Chiso']; ?>" class="btn btn-warning" role="button">Sửa</a>
                                        <a onclick="return confirm('Bạn có muốn xóa dòng chỉ số này không!')" href="deleteChiso.php?id_Chiso=<?= $item['id_Chiso']; ?>&id_room=<?= $item['id_room']; ?>" class="btn btn-danger" role="button">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <?php
                    // Sử dụng lớp Pagination
                    $totalItems = 10;
                    $itemsPerPage = 3;
                    $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                    $baseUrl = 'dsPost.php';
                    $queryParameters = array('category' => 'news');

                    $pagination = new Pagination($totalItems, $itemsPerPage, $currentPage, $baseUrl, $queryParameters);
                    echo $pagination->generatePaginationHtml();
                    ?>
                </div>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?><br>
            </div>
        </div>
    </div>
</body>

</html>