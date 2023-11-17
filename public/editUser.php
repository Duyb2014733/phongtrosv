<?php
require_once __DIR__ . '/../bootstrap.php';

use phongtrosv\src\User;

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: login.php');
    exit();
}
$user = new User($PDO);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    if ($user->editUser($id, $username, $email)) {
        $success = 'Chỉnh sửa thông tin người dùng thành công!';
    } else {
        $errors = 'Lỗi khi chỉnh sửa thông tin người dùng.';
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $userData = $user->getUserIdName($id);
    if (!$userData) {
        $errors = 'Người dùng không tồn tại!';
    }
}
require_once __DIR__ . '/../partials/header.php';
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Chỉnh sửa người dùng</title>
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
                        <h2>Chỉnh sửa thông tin người dùng</h2>
                        <hr>
                        <input type="hidden" name="id" value="<?= $userData['id']; ?>">
                        <div class="form-group">
                            <label for="username">Tên người dùng:</label>
                            <input type="text" name="username" value="<?= $userData['username']; ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" value="<?= $userData['email']; ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a class="btn btn-primary" href="list_users.php">Quay lại</a>
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