<?php
require_once __DIR__ . '/../bootstrap.php';

use website\src\User;
use website\src\Owner;

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: Dangnhap.php');
    exit();
}

$owner = new Owner($PDO);
$user = new User($PDO);
$users = $user->getAllUsers();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name_owner'];
    $phone = $_POST['phone_owner'];
    $email = $_POST['email_owner'];
    $address = $_POST['address_owner'];
    $id_name = $user->getIdName($_POST['username']);
    if ($owner->addOwner($name, $phone, $email, $address, $id_name)) {
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
                        <?php if (isset($success)) { ?>
                            <div class="alert alert-success"><?= $success ?></div>
                        <?php } ?>
                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="username">Tài khoản :</label><br>
                            <select name="username" class="form-control">
                                <?php foreach ($users as $user) { ?>
                                    <option value="<?= $user['username'] ?>">
                                        <?= $user['username'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div><br>
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
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" class="form-control" name="register">Thêm</button>
                            <a class="btn btn-primary" href="dsRoom.php">Thoát</a>
                        </div>
                        
                    </form>
                </div>
                <br>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?><br>
            </div>
        </div>
    </div>
</body>


</html>