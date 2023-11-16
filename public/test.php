<?php
require_once __DIR__ . '/../bootstrap.php';

use website\src\Rental;
use website\src\Room;

session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}

$rental = new Rental($PDO);
$room = new Room($PDO);

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

function calculateRentCost($startDate, $endDate, $roomPrice, $elec_room, $water_room)
{
    $startTimestamp = strtotime($startDate);
    $endTimestamp = strtotime($endDate);

    $months = ceil(($endTimestamp - $startTimestamp) / (60 * 60 * 24 * 30));

    $rentCost = ($months * $roomPrice) + ($_POST['elec'] * $elec_room) + ($_POST['water'] * $water_room);

    return $rentCost;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $elec = $_POST['elec'];
    $water = $_POST['water'];

    // Lấy dữ liệu từ bảng modal để tính toán chi phí
    $tinhtien = calculateRentCost($rentalDetail['start_date'], $rentalDetail['end_date'], $rentalDetail['price_room'], $rentalDetail['elec_room'], $rentalDetail['water_room']);
}
require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Thông tin khách hàng và chi phí</title>
</head>

<body>
    <div class="container-fluid">
        <div class="col-sm-2">
            <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
        </div>
        <div class="col-sm-10 pt-4 px-3 main">
            <div class="table-responsive">
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
                        <?php foreach ($rentalDetails as $rentalDetail) : ?>
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
        </div>
    </div>
</body>

</html>
