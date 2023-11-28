<?php
require_once __DIR__ . '/../bootstrap.php';

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: Dangnhap.php');
    exit();
}

use phongtrosv\src\Owner;

if (!isset($_GET['id_owner']) || empty($_GET['id_owner'])) {
    header('Location: dsOwner_admin.php');
    exit();
}

$id_owner = $_GET['id_owner'];
$owner = new Owner($PDO);

$ownerDetails = $owner->getOwnerById($id_owner);
if (!$ownerDetails) {
    header('Location: dsOwner_admin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_owner = $_POST['name_owner'];
    $phone_owner = $_POST['phone_owner'];
    $email_owner = $_POST['email_owner'];
    $address_owner = $_POST['address_owner'];

    $owner->updateOwner($id_owner, $name_owner, $phone_owner, $email_owner, $address_owner);

    header('Location: danhSachOwner.php');
    exit();
}

require_once __DIR__ . '/../partials/header.php';
?>

<head>
    <title>Chỉnh sửa thông tin chủ nhà trọ</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php"; ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <h2>Chỉnh sửa thông tin chủ nhà trọ</h2><hr>
                    <form method="post">
                        <div class="mb-3">
                            <label for="name_owner" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="name_owner" name="name_owner" value="<?= $ownerDetails['name_owner']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_owner" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone_owner" name="phone_owner" value="<?= $ownerDetails['phone_owner']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email_owner" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_owner" name="email_owner" value="<?= $ownerDetails['email_owner']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="address_owner" class="form-label">Địa chỉ</label>
                            <textarea class="form-control" id="address_owner" name="address_owner" rows="3" required><?= $ownerDetails['address_owner']; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                        <a class="btn btn-primary" href="dsOwner_admin.php">Thoát</a>
                    </form>
                </div>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?><br>
            </div>
        </div>
    </div>
</body>

</html>
