<?php
require_once __DIR__ . '/../bootstrap.php';

use website\labs\Customer;

session_start();

if (!isset($_SESSION['id_owner'])) {
    header('Location: Dangnhap.php');
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer = new Customer($PDO);
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $customerId = $customer->themCustomer($name, $phone, $email, $address);

    if ($customerId) {
        $success = 'Khách hàng được thêm thàng công!';
    } else {
        $error = 'Có lỗi khi thêm khách hàng!';
    }
}
require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>Add Customer</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed_owner.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3">
                <div>
                    <?php if (isset($errors) && !empty($errors)) { ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $field => $error) { ?>
                                    <li><?= $error ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php } ?>

                    <form method="post">
                        <h2>Thêm khách hàng</h2><hr>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input class="form-control" type="text" name="name" required>
                        </div><br>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input class="form-control" type="text" name="phone" required>
                        </div><br>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input class="form-control" type="email" name="email" required>
                        </div><br>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <textarea class="form-control" name="address"></textarea> 
                        </div><br>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Thêm</button>
                            <a class="btn btn-primary" href="dsbaidang.php">Close</a>
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