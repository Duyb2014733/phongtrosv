<?php
require_once __DIR__ . '/../bootstrap.php';

use website\src\Rental;
use website\src\Room;
use website\src\Chiso;
use website\src\Pagination;

session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}

$rental = new Rental($PDO);
$room = new Room($PDO);
$chiso = new Chiso($PDO);
$sql = "
    SELECT
        r.id_rental,
        r.start_date,
        r.end_date,
        r.name_customer,
        r.phone_customer,
        r.email_customer,
        r.address_customer,
        ro.id_room,
        ro.name_room,
        ro.price_room,
        ro.elec_room,
        ro.water_room,
        ro.area_room
    FROM rental r
    JOIN room ro ON r.id_room = ro.id_room
";

$statement = $PDO->prepare($sql);
$statement->execute();
$rentalDetails = $statement->fetchAll();

function calculateRentCost($startDate, $endDate, $roomPrice, $totalcost)
{
    $startTimestamp = strtotime($startDate);
    $endTimestamp = strtotime($endDate);

    $months = ceil(($endTimestamp - $startTimestamp) / (60 * 60 * 24 * 30));

    $rentCost = ($months * $roomPrice) +  $totalcost;

    return $rentCost;
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
                    <h2>Thông tin khách hàng và chi phí</h2>
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
                                $totalcost = $chiso->getLatestTotalCost($rentalDetail['id_room']); ?>
                                <tr>
                                    <td><?= $rentalDetail['id_rental']; ?></td>
                                    <td><?= $rentalDetail['start_date']; ?></td>
                                    <td><?= $rentalDetail['end_date']; ?></td>
                                    <td><?= $rentalDetail['name_customer']; ?></td>
                                    <td><?= $rentalDetail['name_room']; ?></td>
                                    <td><?= $rentalDetail['price_room']; ?></td>
                                    <td>
                                        <?= $tinhtien = calculateRentCost($rentalDetail['start_date'], $rentalDetail['end_date'], $rentalDetail['price_room'], $totalcost); ?>
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