<?php
require_once __DIR__ . '/../bootstrap.php';

use website\src\Owner;

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit();
}
$owner = new Owner($PDO);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name_owner'];
    $phone = $_POST['phone_owner'];
    $email = $_POST['email_owner'];
    $address = $_POST['address_owner'];

    if ($owner->addOwner($name, $phone, $email, $address)) {
        $success = 'Thêm chủ nhà thành công!';
    } else {
        $error = 'Lỗi khi thêm chủ nhà!';
    }
}

require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>Nhập thông tin chủ trọ</title>
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
                        <h2>Nhập thông tin chủ trọ</h2>
                        <hr>
                        <div class="form-group">
                            <label for="name_owner">Name :</label><br>
                            <input type="text" name="name_owner" class="form-control" placeholder="Họ và tên chủ trọ">
                        </div><br>
                        <div class="form-group">
                            <label for="phone_owner">Phone: </label><br>
                            <input type="mumber" name="phone_owner" class="form-control" placeholder="Số điện thoại chủ trọ">
                        </div><br>
                        <div class="form-group">
                            <label for="email_owner">E-mail: </label><br>
                            <input type="text" name="email_owner" class="form-control" placeholder="Email chủ trọ">
                        </div><br>
                        <div class="form-group">
                            <label for="address_owner">Address: </label><br>
                            <input type="text" name="address_owner" class="form-control" placeholder="Địa chỉ chủ trọ">
                        </div><br>
                        <button type="submit" class="btn btn-primary" class="form-control" name="register">Thêm</button>
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