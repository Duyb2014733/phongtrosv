<?php
require_once __DIR__ . '/../bootstrap.php';

use website\labs\Customer;

session_start();
if (!isset($_SESSION['id_owner'])) {
    header('Location: Dangnhap.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $customer = new Customer($PDO);
    $id = $_POST['id_customer'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address_customer'];

    if ($customerId = $customer->editCustomer($id, $name, $phone, $email, $address)) {
        $success = 'Cập nhật khách hàng thành công!';
    } else {
        $errors = 'Lỗi khi cập nhật!';
    }
}

$id_customer = $_GET['id_customer'];
$customer = new Customer($PDO);
$customerData = $customer->getCustomerById($id_customer);

require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>
        Chỉnh sửa khách hàng
    </title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed_owner.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <?php if (!empty($success)) : ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>
                    <?php if (!empty($errors)) : ?>
                        <div class="alert alert-danger"><?= $errors ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <h2>Chỉnh sửa thông tin khách hàng</h2>
                        <hr>
                        <input type="hidden" name="id_customer" value="<?= $id_customer ?>">
                        <div class="form-group">
                            <label for="name">Tên khách hàng:</label>
                            <input type="text" name="name" value="<?= $customerData['name_customer'] ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" value="<?= $customerData['phone_customer'] ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" value="<?= $customerData['email_customer'] ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <textarea name="address_customer" class="form-control" required><?= $customerData['address_customer'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a class="btn btn-primary" href="dsCustomer.php">Close</a>
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