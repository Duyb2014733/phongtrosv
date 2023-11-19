<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}

use phongtrosv\src\Owner;
use phongtrosv\src\Rental;
use phongtrosv\src\Room;

$id_room = $_GET['id_room'];

$owner = new Owner($PDO);
$owners = $owner->getAllOwners();

$room = new Room($PDO);
$room -> updateRoomStatusToReserved($id_room);
$rooms = $room->getRoomById($id_room);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name_customer = $_POST['name_customer'];
    $phone_customer = $_POST['phone_customer'];
    $email_customer = $_POST['email_customer'];
    $address_customer = $_POST['address_customer'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $R_deposit = $_POST['R_deposit'];
    $id_owner = $_POST['id_owner'];

    $rental = new Rental($PDO);
    if ($rental->addRental($name_customer, $phone_customer, $email_customer, $address_customer, $start_date, $end_date, $R_deposit, $id_room, $id_owner)) {
        $success = 'Thêm Rental thành công!';
    } else {
        $error = 'Lỗi khi thêm Rental!';
    }
}



require_once __DIR__ . '/../partials/header.php';
?>


<!DOCTYPE html>
<html>

<head>
    <title>Thêm Rental</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <h2>Thêm Rental</h2>
                    <hr>
                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php } ?>
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php } ?>
                    <form method="post" class="form-group">
                        <div class="row">
                            <div class="form-group col">
                                <label for="name_customer">Tên khách hàng :</label><br>
                                <input type="text" class="form-control" name="name_customer" required>
                            </div><br>
                            <div class="form-group col">
                                <label for="phone_customer">Số điện thoại :</label><br>
                                <input type="mumber" class="form-control" name="phone_customer" required>
                            </div><br>
                        </div><br>
                        <div class="row">
                            <div class="form-group col">
                                <label for="email_customer">Địa chỉ email :</label><br>
                                <input type="text" class="form-control" name="email_customer" required>
                            </div><br>
                            <div class="form-group col">
                                <label for="address_customer">Địa chỉ :</label><br>
                                <input type="text" class="form-control" name="address_customer" required>
                            </div><br>
                        </div><br>
                        <div class="row">
                            <div class="form-group col">
                                <label for="start_date">Ngày bắt đầu:</label><br>
                                <input type="date" class="form-control" name="start_date" required>
                            </div><br>
                            <div class="form-group col">
                                <label for="end_date">Ngày kết thúc:</label><br>
                                <input type="date" class="form-control" name="end_date" required>
                            </div><br>
                        </div><br>
                        <div class="row">
                            <div class="form-group col">
                                <label for="id_owner">Chủ sở hữu:</label><br>
                                <select name="id_owner" class="form-control">
                                    <?php foreach ($owners as $owner) { ?>
                                        <option value="<?php echo htmlspecialchars($owner['id_owner']); ?>">
                                            <?php echo htmlspecialchars($owner['name_owner']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div><br>
                            <div class="form-group col">
                                <label for="id_room">Phòng:</label><br>
                                <input type="text" class="form-control" name="id_room" value="<?= $rooms['name_room'] ?>" required>
                            </div><br>
                        </div><br>
                        <div class="form-group">
                            <label for="R_deposit">Tiền đặt cọc:</label><br>
                            <input type="text" class="form-control" name="R_deposit" required>
                        </div><br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Thêm Rental</button>
                            <a class="btn btn-primary" href="dsRoom.php">Thoát</a>
                        </div><br>
                    </form>
                </div>
                <br>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?>
            </div>
        </div>
    </div>

</body>

</html>