<?php
require_once __DIR__ . '/../bootstrap.php';

use phongtrosv\src\User;

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
            <div class="col-sm-2">
                <?php require_once __DIR__ . "/../partials/navbar_fixed.php" ?>
            </div>
            <div class="col-sm-10 pt-4 px-3 main">
                <div class="container">
                    <form method="post" class="">
                        <h1>Đăng nhập</h1>
                        <hr>
                        <?php if (isset($success)) { ?>
                            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                        <?php } ?>
                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php } ?>
                        <div class="mb-3 mt-3">
                            <label for="username">Tên đăng nhập :</label>
                            <input type="text" class="form-control" name="username" placeholder="Tên đăng nhập" required>
                        </div>
                        <div class="mb-3">
                            <label for="password">Mật khẩu :</label>
                            <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
                        </div>
                        <input type="submit" class="btn btn-primary " name="login" value="Đăng nhập"><br>
                        <div class="from-group" style="text-align: right;">
                            <span class="psw">Quên <a href="#">mật khẩu?</a></span>
                        </div>
                    </form>
                </div>
                <br>
                <hr><br>
                <?php require_once __DIR__ . '/../partials/footer.php'; ?><br>
            </div>
        </div>
</body>

</html>