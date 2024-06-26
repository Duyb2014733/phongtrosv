<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();

use phongtrosv\src\Room;
use phongtrosv\src\Rental;

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}

if (isset($_GET['id_room'])) {
    $id_room = $_GET['id_room'];
    $rental = new Rental($PDO);
    $room = new Room($PDO);
    $images = $room->getImagesByRoomId($id_room);
    $rooms = $room->getRoomById($id_room);
    $rentalDetail = $rental->getRentalByIdRoom($id_room);
}

require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>Chi tiết thông tin thuê phòng</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php"; ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <?php
                            foreach ($images as $image) {
                                echo '<img src="' . $image['image'] . '" alt="Image" style="width: 100%; height: 100%; margin-bottom: 10px;">';
                            }
                            ?>
                        </div>
                        <div class="col">
                            <?php if ($rentalDetail) : ?>
                                <h2>Thông tin chi tiết thuê phòng</h2>
                                <hr>
                                <p>ID Rental: <?php echo htmlspecialchars($rentalDetail['id_rental']); ?></p>
                                <p>ID Room: <?php echo htmlspecialchars($rentalDetail['id_room']); ?></p>
                                <p>Tên Phòng: <?php echo htmlspecialchars($rooms['name_room']); ?></p>
                                <p>Tên khách hàng : <?php echo htmlspecialchars($rentalDetail['name_customer']); ?></p>
                                <p>Số điện thoại : <?php echo htmlspecialchars($rentalDetail['phone_customer']); ?></p>
                                <p>Địa chỉ email : <?php echo htmlspecialchars($rentalDetail['email_customer']); ?></p>
                                <p>Địa chỉ : <?php echo htmlspecialchars($rentalDetail['address_customer']); ?></p>
                                <p>Giá Phòng : <?php echo htmlspecialchars($rooms['price_room']); ?>đ</p>
                                <p>Giá điện : <?php echo htmlspecialchars($rooms['elec_room']); ?>đ</p>
                                <p>Giá nước : <?php echo htmlspecialchars($rooms['water_room']); ?>đ</p>
                                <p>Ngày bắt đầu : <?php echo htmlspecialchars($rentalDetail['start_date']); ?></p>
                                <p>Ngày kết thúc : <?php echo htmlspecialchars($rentalDetail['end_date']); ?></p>

                            <?php else : ?>
                                <div class="alert alert-danger">Không tìm thấy thông tin thuê phòng!</div>
                            <?php endif; ?>
                        </div>
                        <a class="btn btn-primary" href="dsRoom.php">Quay lại</a>
                    </div>


                </div>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?><br>
            </div>
        </div>
    </div>
</body>

</html>