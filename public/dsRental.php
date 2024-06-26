<?php
require_once __DIR__ . '/../bootstrap.php';

use phongtrosv\src\Rental;
use phongtrosv\src\Room;
use phongtrosv\src\Chiso;
use phongtrosv\src\Pagination;

session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}

$rental = new Rental($PDO);
$room = new Room($PDO);
$chiso = new Chiso($PDO);
if ($_SESSION['role'] === 'Admin') {
    $rentalDetails = $rental->getRentalRoomAll();
} elseif ($_SESSION['role'] === 'Owner') {
    $id_owner = $_SESSION['id_owner'];
    $rentalDetails = $rental->getRentalRoomById($id_owner);
}

require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>Thông tin khách hàng và chi phí</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <h2>Thông tin khách hàng và chi phí</h2><hr>
                    <table class="table  table-striped">
                        <thead>
                            <tr>
                                <th>ID Rental</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Tên khách hàng</th>
                                <th>Tên phòng</th>
                                <th>Giá phòng</th>
                                <th>Chi phí trọ</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rentalDetails as $rentalDetail) :
                                $totalcost = $chiso->getLatestTotalCost($rentalDetail['id_room']);
                                $tinhtien = $rental -> calculateRentCost($rentalDetail['start_date'], $rentalDetail['end_date'], $rentalDetail['price_room'], $totalcost);
                                ?>
                                <tr>
                                    <td><?= $rentalDetail['id_rental']; ?></td>
                                    <td><?= $rentalDetail['start_date']; ?></td>
                                    <td><?= $rentalDetail['end_date']; ?></td>
                                    <td><?= $rentalDetail['name_customer']; ?></td>
                                    <td><?= $rentalDetail['name_room']; ?></td>
                                    <td><?= $rentalDetail['price_room']; ?></td>
                                    <td>
                                        <?= isset($tinhtien) ? $tinhtien : ''; ?>
                                    </td>
                                    <td>
                                        <a href="addChiso.php?id_room=<?= $rentalDetail['id_room']; ?>" class="btn btn-primary" role="button">Tính tiền</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <?php
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