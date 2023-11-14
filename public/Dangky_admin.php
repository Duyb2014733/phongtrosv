<?php
require_once __DIR__ . '/../bootstrap.php';

use website\src\User;

ob_start();
session_start();
// Xử lý đăng ký tài khoản
if (isset($_POST['register']) && ($_POST['register'])) {
    $user = new User($PDO);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $add = $user->addUser($username, $password, $role);
}


require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Đăng ký thành viên</title>
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
                        <h1>Đăng ký thành viên </h1>
                        <hr>
                        <div class="from-group text-center " style="color: #B22222;">
                            <?php if (!empty($error)) { ?>
                                <span><?= $error ?></span>
                            <?php } ?>
                        </div><br>
                        <label for="username">Tên đăng ký :</label><br>
                        <input type="text" class="form-control mr-sm-2" name="username" placeholder="Tên đăng ký" required>
                        <br>
                        <label for="password">Mật khẩu :</label><br>
                        <input type="password" class="form-control mr-sm-2" name="password" placeholder="Mật khẩu" required>
                        <br>
                        <label for="role">Vai trò :</label><br>
                        <select name="role">
                            <option value="Owner">Chủ trọ</option>
                            <option value="Admin">Admin</option>
                        </select>
                        <br>
                        <input type="submit" class="btn btn-primary" name="register" value="Đăng ký">
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