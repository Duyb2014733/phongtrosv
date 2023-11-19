<?php
require_once __DIR__ . '/../bootstrap.php';

use phongtrosv\src\Owner;

session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Owner')) {
    header('Location: Dangnhap.php');
    exit();
}
$owner = new Owner($PDO);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name_owner'];
    $phone = $_POST['phone_owner'];
    $email = $_POST['email_owner'];
    $address = $_POST['address_owner'];
    $id_name = $_SESSION['id_name'];

    if ($owner->addOwner($name, $phone, $email, $address, $id_name)) {
        $success = 'Thêm chủ nhà thành công!';
    } else {
        $error = 'Lỗi khi thêm chủ nhà! Thông tin đã tồn tại.';
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
                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php } ?>
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php } ?>
                    <form method="post" class="register-form">
                        <h2>Nhập thông tin chủ trọ</h2>
                        <hr>
                        <div class="form-group">
                            <label for="name_owner">Name: </label>
                            <input type="text" name="name_owner" placeholder="Họ và tên chủ trọ" class="form-control" required>
                        </div><br>
                        <div class="form-group">
                            <label for="phone_owner">Phone: </label>
                            <input type="mumber" name="phone_owner" placeholder="Số điện thoại chủ trọ" class="form-control" required>
                        </div><br>
                        <div class="form-group">
                            <label for="email_owner">E-mail: </label>
                            <input type="text" name="email_owner" placeholder="Email chủ trọ" class="form-control" required>
                        </div><br>
                        <div class="form-group">
                            <label for="address_owner">Address: </label>
                            <input type="text" name="address_owner" placeholder="Địa chỉ chủ trọ" class="form-control" required>
                        </div><br>
                        <div class="form-group">
                            <a class="btn btn-primary" role="submit">Thêm</a>
                            <a href="Dangnhap.php" class="btn btn-primary" role="button">Thoát</a>
                        </div>
                    </form>
                </div>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?>
            </div>
        </div>
    </div>
</body>


</html>