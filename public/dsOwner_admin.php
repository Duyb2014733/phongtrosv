<?php
require_once __DIR__ . '/../bootstrap.php';

use website\src\Owner;

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit();
}

$owner = new Owner($PDO);
$owners = $owner->getAllOwners();

require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Danh Sách Chủ Nhà</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div>
                    <h2>Danh Sách Chủ Nhà</h2>
                    <hr>
                    <a class="btn btn-primary btn-lg" href="addOwner_admin.php">Thêm Chủ Nhà</a>
                    <hr>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Số Điện Thoại</th>
                                <th>Email</th>
                                <th>Địa Chỉ</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($owners as $owner) : ?>
                                <tr>
                                    <td><?php echo $owner['id_owner']; ?></td>
                                    <td><?php echo $owner['name_owner']; ?></td>
                                    <td><?php echo $owner['phone_owner']; ?></td>
                                    <td><?php echo $owner['email_owner']; ?></td>
                                    <td><?php echo $owner['address_owner']; ?></td>
                                    <td>
                                        <a href="/editOwner.php?id_owner=<?php echo $owner['id_owner']; ?>" class="btn btn-info" style="background-color: #FF7F50;" role="button">Sửa</a>
                                        <a href="/deleteOwner_admin.php?id_owner=<?php echo $owner['id_owner']; ?>" class="btn btn-danger" role="button" onclick="return confirm('Bạn có chắc chắn muốn xóa phòng này không?')">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <br>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?><br>
            </div>
        </div>
    </div>
</body>

</html>