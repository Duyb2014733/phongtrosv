<?php
require_once __DIR__ . '/../bootstrap.php';
use website\src\Customer;
session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Owner')) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer = new Customer($PDO);
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $result = $customer->themCustomer($name, $phone, $email, $address);

    if (is_string($result)) {
        $error = $result;
    } else {
        $success = 'Thêm khách hàng thành công!';
    }
}

require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>Thêm khách hàng</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <h2>Thêm khách hàng</h2>
                    <hr>
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger">
                            <?= $error ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success">
                            <?= $success ?>
                        </div>
                    <?php } ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="name">Tên khách hàng:</label>
                            <input type="text" class="form-control" name="name" placeholder="Tên khách hàng" required>
                        </div><br>
                        <div class="form-group">
                            <label for="phone">Số điện thoại:</label>
                            <input type="text" class="form-control" name="phone" placeholder="Số điện thoại" required>
                        </div><br>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div><br>
                        <div class="form-group">
                            <label for="address">Địa chỉ:</label>
                            <textarea class="form-control" name="address" placeholder="Địa chỉ"></textarea>
                        </div><br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Thêm khách hàng</button>
                            <a class="btn btn-primary" href="dsCustomer.php">Quay lại</a>
                        </div>
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
