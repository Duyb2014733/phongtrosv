<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}

use website\src\Customer;
use website\src\Owner;
use website\src\Rental;
use website\src\Room;

$id_room = $_GET['id_room'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $R_deposit = $_POST['R_deposit'];
    $id_customer = $_POST['id_customer'];
    $id_owner = $_POST['id_owner'];

    $rental = new Rental($PDO);
    if ($rental->addRental($start_date, $end_date, $R_deposit, $id_customer, $id_owner, $id_room)) {
        $success = 'Thêm Rental thành công!';
    } else {
        $error = 'Lỗi khi thêm Rental!';
    }
}

$customer = new Customer($PDO);
$customers = $customer->getAllCustomers();

$owner = new Owner($PDO);
$owners = $owner->getAllOwners();

$room = new Room($PDO);
$rooms = $room->getRoomById($id_room);

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
                    <h2>Thêm Rental</h2><hr>
                    <?php if (isset($error)) { ?>
                        <div class="error">
                            <?php echo $error; ?>
                        </div>
                    <?php } elseif (isset($success)) { ?>
                        <div class="success">
                            <?php echo $success; ?>
                        </div>
                    <?php } ?>
                    <form method="post">
                        <label for="start_date">Ngày bắt đầu:</label>
                        <input type="date" class="form-control" name="start_date" required>
                        <br>
                        <label for="end_date">Ngày kết thúc:</label>
                        <input type="date" class="form-control" name="end_date" required>
                        <br>
                        <label for="R_deposit">Tiền đặt cọc:</label>
                        <input type="text" class="form-control" name="R_deposit" required>
                        <br>
                        <label for="id_customer">Khách hàng:</label>
                        <select name="id_customer" class="form-control">
                            <?php foreach ($customers as $customer) { ?>
                                <option value="<?php echo $customer['id_customer']; ?>">
                                    <?php echo $customer['name_customer']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <br>
                        <label for="id_owner">Chủ sở hữu:</label>
                        <select name="id_owner" class="form-control">
                            <?php foreach ($owners as $owner) { ?>
                                <option value="<?php echo $owner['id_owner']; ?>">
                                    <?php echo $owner['name_owner']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <br>
                        <label for="id_room">Phòng:</label>
                        <input type="text" class="form-control" name="id_room" value="<?= $rooms['name_room'] ?>" required>
                        <br>
                        <button type="submit" class="btn btn-primary">Thêm Rental</button>
                        <a class="btn btn-primary" href="dsRoom.php">Thoát</a>
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