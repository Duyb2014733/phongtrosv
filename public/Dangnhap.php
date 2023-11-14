<?php
require_once __DIR__ . '/../bootstrap.php';

use website\src\User;

session_start();

if (isset($_POST['login']) && ($_POST['login'])) {
    $user = new User($PDO);

    $username = $_POST['username'];
    $password = $_POST['password'];
    $kq = $user->getUser($username);

    $role = $user->checkUserRole($username, $password);

    $id_owner = $user->getOwnerIdByIdName($username);
    if ($role != null) {
        if ($role == 'Admin') {
            $_SESSION['role'] = $role;
            header('Location: admin.php');
        } else if ($role == 'Owner') {
            $_SESSION['role'] = $role;
            $_SESSION['username'] = $kq;
            $_SESSION['id_owner'] = $id_owner;
            header('Location: index.php');
        } else {
            $error = 'Tài khoản và mật khẩu sai!';
        }
    } else {
        $error = 'Tài khoản và mật khẩu sai!';
    }
}
require_once __DIR__ . '/../partials/header.php';
?>

<!DOCTYPE html>
<html lang=vi>

<head>
    <title>Đăng nhập tài khoản</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            <div class="col-sm-10 pt-4 px-3 main">
                <div class="">
                    <form action="" method="post" class="register-form ">
                        <h1>Đăng nhập</h1><hr>
                        <label for="username">Tên đăng nhập :</label><br>
                        <input type="text" class="form-control mr-sm-2" name="username" placeholder="Tên đăng nhập" required>
                        <br>
                        <label for="password">Mật khẩu :</label><br>
                        <input type="password" class="form-control mr-sm-2" name="password" placeholder="Mật khẩu" required>
                        <br>
                        <div class="from-group text-center " style="color: #B22222;">
                            <?php if (!empty($error)) { ?>
                                <span><?= $error ?></span>
                            <?php } ?>
                        </div> <br>

                        <input type="submit" class="btn btn-primary" name="login" value="Đăng nhập">
                        <br>
                        <div class="from-group" style="text-align: right;">
                            <span class="psw">Quên <a href="#">mật khẩu?</a></span>
                        </div>
                    </form>
                </div>
                <br>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?>
            </div>
        </div>
</body>

</html>